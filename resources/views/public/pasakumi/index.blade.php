@extends('layouts.public')
@section('title','Pasākumi')

@section('content')
<div class="space-y-10">
    <section class="page-hero reveal-up">
        <div class="section-header">
            <div class="section-eyebrow">Pasākumi</div>
            <h1 class="section-title">Aktivitātes un notikumi, kuros vari iesaistīties</h1>
            <p class="section-text">
                Apskati tuvākos un aktuālākos pasākumus, kas notiek Biedrības Kūzuls darbības ietvaros.
            </p>
        </div>
    </section>

    <form class="reveal-up delay-1 rounded-[1.5rem] bg-white border p-4 flex flex-wrap gap-3 items-end shadow-sm" method="get">
        <div class="flex-1 min-w-[240px]">
            <label class="block text-sm font-medium">Meklēt</label>
            <input name="q" value="{{ request('q') }}"
                   class="mt-1 w-full rounded-xl border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400" />
        </div>
        <div>
            <label class="block text-sm font-medium">Kārtot</label>
            <select name="sort" class="mt-1 rounded-xl border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
                <option value="date_asc" @selected(request('sort','date_asc')==='date_asc')>Datums ↑</option>
                <option value="date_desc" @selected(request('sort')==='date_desc')>Datums ↓</option>
            </select>
        </div>
        <button class="btn-primary btn-pill" type="submit">Filtrēt</button>
    </form>

    @if($pasakumi->count())
        <div class="page-grid">
            @foreach($pasakumi as $index => $p)
                <a class="reveal-up home-card group"
                   style="transition-delay: {{ $index * 70 }}ms;"
                   href="{{ route('public.pasakumi.show',$p) }}">
                    <div class="text-sm text-zinc-500">
                        {{ $p->norises_datums?->format('d.m.Y') }} · {{ $p->vieta }}
                    </div>
                    <div class="mt-3 text-xl font-semibold text-zinc-950 group-hover:text-yellow-800">
                        {{ $p->nosaukums }}
                    </div>
                    @if($p->apraksts)
                        <div class="mt-3 text-sm leading-7 text-zinc-600 line-clamp-4">{{ $p->apraksts }}</div>
                    @endif
                    <div class="mt-5 text-sm font-medium text-yellow-700">Skatīt pasākumu →</div>
                </a>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $pasakumi->links() }}
        </div>
    @else
        <div class="content-card text-zinc-600">Nav atrastu pasākumu.</div>
    @endif
</div>
@endsection