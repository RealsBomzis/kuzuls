@php
    use App\Enums\ContentType;
    use App\Models\{Jaunums, Lapa, Pasakums, Projekts, SaturaSaite};

    $links = SaturaSaite::query()
        ->approvedAuto()
        ->where('avots_tips', $sourceType)
        ->where('avots_id', $sourceId)
        ->orderByDesc('atbilstibas_punkti')
        ->limit(8)
        ->get();

    $byType = $links->groupBy('merkis_tips');

    $targets = collect();

    foreach ($byType as $type => $rows) {
        $ids = $rows->pluck('merkis_id')->map(fn($x)=>(int)$x)->unique()->values();

        $items = match ($type) {
            'pasakumi' => Pasakums::whereIn('id', $ids)->where('publicets',1)->get(['id','nosaukums']),
            'projekti' => Projekts::whereIn('id', $ids)->where('publicets',1)->get(['id','nosaukums']),
            'jaunumi'  => Jaunums::whereIn('id', $ids)->where('publicets',1)->get(['id','virsraksts']),
            'lapas'    => Lapa::whereIn('id', $ids)->where('publicets',1)->get(['id','virsraksts','slug']),
            default    => collect(),
        };

        foreach ($items as $it) {
            $title = property_exists($it, 'nosaukums') ? $it->nosaukums : $it->virsraksts;
            $url = match ($type) {
                'pasakumi' => route('public.pasakumi.show', $it->id),
                'projekti' => route('public.projekti.show', $it->id),
                'jaunumi'  => route('public.jaunumi.show', $it->id),
                'lapas'    => route('public.page.show', $it->slug),
                default    => '#',
            };

            $targets["{$type}:{$it->id}"] = ['title' => $title, 'url' => $url];
        }
    }
@endphp

@if($links->count())
<div class="mt-6 rounded-2xl bg-white border p-5">
    <h2 class="font-semibold">Saistītais saturs</h2>
    <ul class="mt-3 space-y-2 text-sm">
        @foreach($links as $l)
            @php $t = $targets["{$l->merkis_tips}:{$l->merkis_id}"] ?? null; @endphp
            @if($t)
                <li class="flex items-center justify-between gap-4">
                    <a class="text-zinc-800 hover:underline"
                       href="{{ $t['url'] }}">
                       {{ $t['title'] }}
                    </a>
                    <span class="text-yellow-700 shrink-0">+{{ $l->atbilstibas_punkti }}</span>
                </li>
            @endif
        @endforeach
    </ul>
</div>
@endif