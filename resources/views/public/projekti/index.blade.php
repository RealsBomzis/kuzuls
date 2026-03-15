@extends('layouts.public')
@section('title','Projekti')

@section('content')
<div class="space-y-10">
    <section class="page-hero reveal-up">
        <div class="section-header">
            <div class="section-eyebrow">Projekti</div>
            <h1 class="section-title">Darbi un ieceres, kas veido nozīmīgu kopienas virzību</h1>
            <p class="section-text">
                Apskati projektus, kuros Biedrība Kūzuls iesaistās, sadarbojas un rada paliekošu vērtību.
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
            <label class="block text-sm font-medium" for="statuss">Statuss</label>
            <select id="statuss" name="statuss"
                    class="mt-1 rounded-xl border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
                <option value="">Visi</option>
                <option value="planots" {{ request('statuss') === 'planots' ? 'selected' : '' }}>Plānots</option>
                <option value="aktivs" {{ request('statuss') === 'aktivs' ? 'selected' : '' }}>Aktīvs</option>
                <option value="pabeigts" {{ request('statuss') === 'pabeigts' ? 'selected' : '' }}>Pabeigts</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium" for="sort">Kārtot</label>
            <select id="sort" name="sort"
                    class="mt-1 rounded-xl border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
                <option value="start_desc" {{ request('sort','start_desc') === 'start_desc' ? 'selected' : '' }}>Sākums ↓</option>
                <option value="start_asc" {{ request('sort') === 'start_asc' ? 'selected' : '' }}>Sākums ↑</option>
                <option value="end_desc" {{ request('sort') === 'end_desc' ? 'selected' : '' }}>Beigas ↓</option>
                <option value="end_asc" {{ request('sort') === 'end_asc' ? 'selected' : '' }}>Beigas ↑</option>
            </select>
        </div>

        <button class="btn-primary btn-pill" type="submit">Filtrēt</button>

        @if(request()->hasAny(['q','statuss','sort','kategorija_id']))
            <a class="btn-secondary btn-pill" href="{{ route('public.projekti.index') }}">Notīrīt</a>
        @endif
    </form>

    @if($projekti->count() === 0)
        <div class="content-card text-zinc-600">
            Nav atrastu projektu.
        </div>
    @else
        <div class="page-grid">
            @foreach($projekti as $index => $p)
                <a class="reveal-up home-card group"
                   style="transition-delay: {{ $index * 70 }}ms;"
                   href="{{ route('public.projekti.show',$p) }}">
                    <div class="flex items-center justify-between gap-3">
                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs bg-yellow-50 border border-yellow-200 text-yellow-800">
                            {{ ucfirst($p->statuss?->value ?? 'planots') }}
                        </span>
                    </div>

                    <div class="mt-4 text-xl font-semibold text-zinc-950 group-hover:text-yellow-800">
                        {{ $p->nosaukums }}
                    </div>

                    <div class="mt-2 text-sm text-zinc-500">
                        Sākums: {{ optional($p->sakuma_datums)->format('d.m.Y') }}
                        @if($p->beigu_datums)
                            · Beigas: {{ optional($p->beigu_datums)->format('d.m.Y') }}
                        @endif
                    </div>

                    <div class="mt-3 text-sm leading-7 text-zinc-600 line-clamp-4">
                        {{ $p->apraksts }}
                    </div>

                    <div class="mt-5 text-sm font-medium text-yellow-700">Skatīt projektu →</div>
                </a>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $projekti->links() }}
        </div>
    @endif
</div>
@endsection