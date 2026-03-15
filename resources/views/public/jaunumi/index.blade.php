@extends('layouts.public')
@section('title','Jaunumi')

@section('content')
<div class="space-y-10">
    <section class="page-hero reveal-up">
        <div class="section-header">
            <div class="section-eyebrow">Jaunumi</div>
            <h1 class="section-title">Aktuālais par mūsu darbību un notikumiem</h1>
            <p class="section-text">
                Iepazīsti jaunākās ziņas, paziņojumus un stāstus par Biedrības Kūzuls aktivitātēm.
            </p>
        </div>
    </section>

    <form class="reveal-up delay-1 rounded-[1.5rem] bg-white border p-4 flex flex-wrap gap-3 items-end shadow-sm" method="get">
        <div class="flex-1 min-w-[240px]">
            <label class="block text-sm font-medium" for="q">Meklēt</label>
            <input id="q" name="q" value="{{ request('q') }}"
                   class="mt-1 w-full rounded-xl border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400" />
        </div>

        <div>
            <label class="block text-sm font-medium" for="sort">Kārtot</label>
            <select id="sort" name="sort"
                    class="mt-1 rounded-xl border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
                <option value="newest" @selected(request('sort','newest')==='newest')>Jaunākie</option>
                <option value="oldest" @selected(request('sort')==='oldest')>Vecākie</option>
            </select>
        </div>

        <button class="btn-primary btn-pill" type="submit">Filtrēt</button>

        @if(request()->hasAny(['q','sort','kategorija_id']))
            <a class="btn-secondary btn-pill" href="{{ route('public.jaunumi.index') }}">Notīrīt</a>
        @endif
    </form>

    @if($jaunumi->count() === 0)
        <div class="content-card text-zinc-600">Nav atrastu jaunumu.</div>
    @else
        <div class="grid gap-5 lg:grid-cols-3">
            @foreach($jaunumi as $index => $j)
                <a class="reveal-up home-card group {{ $index === 0 ? 'lg:col-span-2' : '' }}"
                   style="transition-delay: {{ $index * 70 }}ms;"
                   href="{{ route('public.jaunumi.show',$j) }}">
                    <div class="text-sm text-zinc-500">
                        {{ $j->publicesanas_datums?->format('d.m.Y') ?? '—' }}
                    </div>
                    <div class="mt-3 text-xl font-semibold text-zinc-950 group-hover:text-yellow-800">
                        {{ $j->virsraksts }}
                    </div>
                    @if($j->ievads)
                        <div class="mt-3 text-sm leading-7 text-zinc-600 line-clamp-4">{{ $j->ievads }}</div>
                    @else
                        <div class="mt-3 text-sm leading-7 text-zinc-600 line-clamp-4">
                            {{ \Illuminate\Support\Str::limit(strip_tags($j->saturs), 220) }}
                        </div>
                    @endif
                    <div class="mt-5 text-sm font-medium text-yellow-700">Lasīt vairāk →</div>
                </a>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $jaunumi->links() }}
        </div>
    @endif
</div>
@endsection