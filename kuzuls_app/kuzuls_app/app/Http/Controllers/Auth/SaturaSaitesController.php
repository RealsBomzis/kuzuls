<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Jaunums, Lapa, Pasakums, Projekts, SaturaSaite};
use App\Enums\{LinkKind, LinkReviewStatus};
use App\Services\AuditLogger;
use App\Services\SaturaSaites\AutoSuggestionService;
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
            $s = trim((string)$request->get('q'));
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

        return view('admin.saites.index', compact('saites'));
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

        // prevent self link
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

    public function generate(Request $request, AutoSuggestionService $generator, AuditLogger $audit)
    {
        $this->authorize('create', SaturaSaite::class);

        $created = $generator->generate(
            maxPerSource: (int)($request->integer('max_per_source') ?: 5),
            limitSourcesPerType: (int)($request->integer('limit_sources') ?: 200),
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