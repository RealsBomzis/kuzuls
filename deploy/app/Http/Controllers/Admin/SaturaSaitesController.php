<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Jaunums, Lapa, Pasakums, Projekts, SaturaSaite};
use App\Enums\{LinkKind, LinkReviewStatus};
use App\Services\AuditLogger;
use Illuminate\Http\Request;

class SaturaSaitesController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', SaturaSaite::class);

        $q = SaturaSaite::query();

        if ($request->filled('status')) $q->where('review_status', $request->string('status'));
        if ($request->filled('tips')) $q->where('tips', $request->string('tips'));
        if ($request->filled('avots_tips')) $q->where('avots_tips', $request->string('avots_tips'));
        if ($request->filled('merkis_tips')) $q->where('merkis_tips', $request->string('merkis_tips'));

        if ($request->filled('q')) {
            $s = trim((string)$request->query('q'));
            $q->where(function ($w) use ($s) {
                $w->where('avots_tips', 'like', "%{$s}%")
                  ->orWhere('merkis_tips', 'like', "%{$s}%")
                  ->orWhere('avots_id', $s)
                  ->orWhere('merkis_id', $s);
            });
        }

        $saites = $q->orderByRaw("FIELD(review_status,'pending','approved','rejected')")
            ->orderByDesc('atbilstibas_punkti')
            ->paginate(30)
            ->withQueryString();
            $avotsTitles = $this->bulkTitles($saites->items(), 'avots_tips', 'avots_id');
$merkisTitles = $this->bulkTitles($saites->items(), 'merkis_tips', 'merkis_id');

// For lapas public URL, we need slug bulk map:
$lapaSlugs = \App\Models\Lapa::whereIn('id', collect($saites->items())
    ->filter(fn($x) => $x->merkis_tips === 'lapas')
    ->pluck('merkis_id')
    ->unique()
)->pluck('slug','id')->all();

        return view('admin.saites.index', compact('saites', 'avotsTitles', 'merkisTitles', 'lapaSlugs'));
    }

    public function create()
    {
        $this->authorize('create', SaturaSaite::class);

        return view('admin.saites.create', [
            'pasakumi' => Pasakums::orderByDesc('id')->limit(300)->get(['id','nosaukums']),
            'projekti' => Projekts::orderByDesc('id')->limit(300)->get(['id','nosaukums']),
            'jaunumi'  => Jaunums::orderByDesc('id')->limit(300)->get(['id','virsraksts']),
            'lapas'    => Lapa::orderByDesc('id')->limit(300)->get(['id','virsraksts','slug']),
        ]);
    }

    public function store(Request $request, AuditLogger $audit)
    {
        $this->authorize('create', SaturaSaite::class);

        $data = $request->validate([
            'avots_tips'  => ['required','in:pasakumi,projekti,jaunumi,lapas'],
            'avots_id'    => ['required','integer','min:1'],
            'merkis_tips' => ['required','in:pasakumi,projekti,jaunumi,lapas'],
            'merkis_id'   => ['required','integer','min:1'],
        ]);

        if ($data['avots_tips'] === $data['merkis_tips'] && (int)$data['avots_id'] === (int)$data['merkis_id']) {
            return back()->withErrors(['merkis_id' => 'Nevar izveidot saiti uz pašu ierakstu.'])->withInput();
        }

        $this->ensureExists($data['avots_tips'], (int)$data['avots_id'], 'avots_id');
        $this->ensureExists($data['merkis_tips'], (int)$data['merkis_id'], 'merkis_id');

        $saite = SaturaSaite::updateOrCreate(
            [
                ...$data,
                'tips' => LinkKind::Manualas->value,
            ],
            [
                'review_status' => LinkReviewStatus::Approved->value,
                'atbilstibas_punkti' => 100,
                'izveidoja_user_id' => $request->user()->id,
            ]
        );

        $audit->log('admin_satura_saites_manual_store', $saite);

        return redirect()->route('admin.saites.index')->with('status', 'Manuālā saite izveidota.');
    }

    /**
     * Minimal generator (safe default): creates pending auto links from newest jaunumi -> pasakumi if IDs exist.
     * This avoids adding a big service right now; we can improve it after it works end-to-end.
     */
public function generate(
    Request $request,
    \App\Services\SaturaSaites\AutoSuggestionService $generator,
    AuditLogger $audit
) {
    @set_time_limit(60);

$created = $generator->generate(
    maxPerSource: (int)($request->integer('max_per_source') ?: 5),
    limitSourcesPerType: (int)($request->integer('limit_sources') ?: 80),
    limitTargetsPerType: (int)($request->integer('limit_targets') ?: 300),
    minScore: (int)($request->integer('min_score') ?: 25),
);
    $audit->log('admin_satura_saites_generate', null, ['created' => $created]);

    return back()->with('status', "Ģenerētas ieteiktās saites: {$created}");
}
    public function approve(SaturaSaite $saite, AuditLogger $audit)
    {
        $this->authorize('approve', $saite);

        $saite->update(['review_status' => LinkReviewStatus::Approved->value]);
        $audit->log('admin_satura_saites_approve', $saite);

        return back()->with('status', 'Saite apstiprināta.');
    }

    public function reject(SaturaSaite $saite, AuditLogger $audit)
    {
        $this->authorize('approve', $saite);

        $saite->update(['review_status' => LinkReviewStatus::Rejected->value]);
        $audit->log('admin_satura_saites_reject', $saite);

        return back()->with('status', 'Saite noraidīta.');
    }

    public function destroy(SaturaSaite $saite, AuditLogger $audit)
    {
        $this->authorize('delete', $saite);

        $saite->delete();
        $audit->log('admin_satura_saites_delete', $saite);

        return back()->with('status', 'Saite dzēsta.');
    }
    private function bulkTitles(array $items, string $typeField, string $idField): array
{
    $idsByType = collect($items)
        ->groupBy($typeField)
        ->map(fn($rows) => $rows->pluck($idField)->unique()->values());

    $map = [];

    foreach ($idsByType as $type => $ids) {
        $ids = $ids->map(fn($v) => (int)$v)->all();

        $titles = match ($type) {
            'pasakumi' => \App\Models\Pasakums::whereIn('id', $ids)->pluck('nosaukums', 'id')->all(),
            'projekti' => \App\Models\Projekts::whereIn('id', $ids)->pluck('nosaukums', 'id')->all(),
            'jaunumi'  => \App\Models\Jaunums::whereIn('id', $ids)->pluck('virsraksts', 'id')->all(),
            'lapas'    => \App\Models\Lapa::whereIn('id', $ids)->pluck('virsraksts', 'id')->all(),
            default    => [],
        };

        foreach ($titles as $id => $title) {
            $map["{$type}:{$id}"] = $title;
        }
    }

    return $map;
}
public function bulk(Request $request, AuditLogger $audit)
{
    $this->authorize('update', SaturaSaite::class); // or viewAny/create depending on your policy; update is safe

    $data = $request->validate([
        'action' => ['required', 'in:approve,reject,delete'],
        'ids' => ['array'],
        'ids.*' => ['integer'],
        // If user chooses “select all matching”
        'apply_to_filtered' => ['sometimes', 'boolean'],
        'filters' => ['array'], // contains status/tips/avots_tips/merkis_tips/q
    ]);

    $action = $data['action'];

    $query = SaturaSaite::query();

    // If selecting “all filtered”, apply the same filters used in index
    $applyAll = (bool)($data['apply_to_filtered'] ?? false);
    if ($applyAll) {
        $filters = $data['filters'] ?? [];

        if (!empty($filters['status'])) $query->where('review_status', $filters['status']);
        if (!empty($filters['tips'])) $query->where('tips', $filters['tips']);
        if (!empty($filters['avots_tips'])) $query->where('avots_tips', $filters['avots_tips']);
        if (!empty($filters['merkis_tips'])) $query->where('merkis_tips', $filters['merkis_tips']);

        if (!empty($filters['q'])) {
            $s = trim((string)$filters['q']);
            $query->where(function ($w) use ($s) {
                $w->where('avots_tips', 'like', "%{$s}%")
                    ->orWhere('merkis_tips', 'like', "%{$s}%")
                    ->orWhere('avots_id', $s)
                    ->orWhere('merkis_id', $s);
            });
        }
    } else {
        $ids = $data['ids'] ?? [];
        if (count($ids) === 0) {
            return back()->with('status', 'Nav izvēlēta neviena saite.');
        }
        $query->whereIn('id', $ids);
    }

    // Authorization per-record (important)
    $links = $query->get();

    if ($links->isEmpty()) {
        return back()->with('status', 'Nekas netika atrasts izvēlētajai darbībai.');
    }

    $count = 0;

    if ($action === 'approve') {
        foreach ($links as $saite) {
            $this->authorize('approve', $saite);
            $saite->update(['review_status' => \App\Enums\LinkReviewStatus::Approved->value]);
            $count++;
        }
        $audit->log('admin_satura_saites_bulk_approve', null, ['count' => $count, 'apply_all' => $applyAll]);
        return back()->with('status', "Apstiprinātas saites: {$count}");
    }

    if ($action === 'reject') {
        foreach ($links as $saite) {
            $this->authorize('approve', $saite);
            $saite->update(['review_status' => \App\Enums\LinkReviewStatus::Rejected->value]);
            $count++;
        }
        $audit->log('admin_satura_saites_bulk_reject', null, ['count' => $count, 'apply_all' => $applyAll]);
        return back()->with('status', "Noraidītas saites: {$count}");
    }

    // delete
    foreach ($links as $saite) {
        $this->authorize('delete', $saite);
        $saite->delete();
        $count++;
    }
    $audit->log('admin_satura_saites_bulk_delete', null, ['count' => $count, 'apply_all' => $applyAll]);

    return back()->with('status', "Dzēstas saites: {$count}");
}
    private function ensureExists(string $tips, int $id, string $field): void
    {
        $ok = match ($tips) {
            'pasakumi' => Pasakums::whereKey($id)->exists(),
            'projekti' => Projekts::whereKey($id)->exists(),
            'jaunumi'  => Jaunums::whereKey($id)->exists(),
            'lapas'    => Lapa::whereKey($id)->exists(),
            default    => false,
        };

        if (!$ok) {
            abort(422, "Izvēlētais {$field} neeksistē ({$tips} #{$id}).");
        }
    }
}