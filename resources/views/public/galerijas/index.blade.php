@extends('layouts.public')
@section('title','Galerijas')

@section('content')
<div class="space-y-10">
    <section class="page-hero reveal-up">
        <div class="section-header">
            <div class="section-eyebrow">Galerijas</div>
            <h1 class="section-title">Momenti, notikumi un ieskats mūsu aktivitātēs</h1>
            <p class="section-text">
                Foto galerijas, kas atspoguļo mūsu pasākumus, projektus un kopienas dzīvi.
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
                <option value="newest" {{ request('sort','newest') === 'newest' ? 'selected' : '' }}>Jaunākās</option>
                <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Vecākās</option>
            </select>
        </div>

        <button class="btn-primary btn-pill" type="submit">Filtrēt</button>

        @if(request()->hasAny(['q','sort','kategorija_id']))
            <a class="btn-secondary btn-pill" href="{{ route('public.galerijas.index') }}">Notīrīt</a>
        @endif
    </form>

    @if($galerijas->count() === 0)
        <div class="content-card text-zinc-600">
            Nav atrastu galeriju.
        </div>
    @else
        <div class="page-grid">
            @foreach($galerijas as $index => $g)
                <a class="reveal-up home-card group"
                   style="transition-delay: {{ $index * 70 }}ms;"
                   href="{{ route('public.galerijas.show',$g) }}">
                    <div class="flex items-center justify-between gap-2">
                        <div class="text-xl font-semibold text-zinc-950 group-hover:text-yellow-800">
                            {{ $g->nosaukums }}
                        </div>
                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs bg-yellow-50 border border-yellow-200 text-yellow-800">
                            {{ $g->atteli_count }} att.
                        </span>
                    </div>

                    @if($g->apraksts)
                        <div class="mt-3 text-sm leading-7 text-zinc-600 line-clamp-4">
                            {{ $g->apraksts }}
                        </div>
                    @endif

                    <div class="mt-5 text-sm font-medium text-yellow-700">Skatīt galeriju →</div>
                </a>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $galerijas->links() }}
        </div>
    @endif
</div>
@endsection