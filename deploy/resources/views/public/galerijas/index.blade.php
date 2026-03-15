@extends('layouts.public')
@section('title','Galerijas')

@section('content')
<div class="flex items-end justify-between gap-4">
    <div>
        <h1 class="text-2xl font-semibold">Galerijas</h1>
        <p class="text-zinc-600">Tikai publicētās galerijas.</p>
    </div>
</div>

<form class="mt-6 rounded-2xl bg-white border p-4 flex flex-wrap gap-3 items-end" method="get">
    <div class="flex-1 min-w-[240px]">
        <label class="block text-sm font-medium" for="q">Meklēt</label>
        <input id="q" name="q" value="{{ request('q') }}"
               class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400" />
    </div>

    <div>
        <label class="block text-sm font-medium" for="sort">Kārtot</label>
        <select id="sort" name="sort"
                class="mt-1 rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
            <option value="newest" @selected(request('sort','newest')==='newest')>Jaunākās</option>
            <option value="oldest" @selected(request('sort')==='oldest')>Vecākās</option>
        </select>
    </div>

    <button class="btn-primary" type="submit">Filtrēt</button>

    @if(request()->hasAny(['q','sort','kategorija_id']))
        <a class="btn-secondary" href="{{ route('public.galerijas.index') }}">Notīrīt</a>
    @endif
</form>

@if($galerijas->count() === 0)
    <div class="mt-6 rounded-2xl bg-white border p-6 text-zinc-700">
        Nav atrastu galeriju.
    </div>
@else
    <div class="mt-6 grid md:grid-cols-3 gap-4">
        @foreach($galerijas as $g)
            <a class="rounded-2xl bg-white border p-5 hover:border-yellow-300 focus:outline-none focus:ring-2 focus:ring-yellow-400"
               href="{{ route('public.galerijas.show',$g) }}">
                <div class="flex items-center justify-between gap-2">
                    <div class="font-semibold">{{ $g->nosaukums }}</div>
                    <span class="inline-flex items-center rounded-full px-2 py-1 text-xs bg-yellow-50 border border-yellow-200 text-yellow-800">
                        {{ $g->atteli_count }} att.
                    </span>
                </div>
                @if($g->apraksts)
                    <div class="mt-2 text-sm text-zinc-700 line-clamp-3">{{ $g->apraksts }}</div>
                @endif
            </a>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $galerijas->links() }}
    </div>
@endif
@endsection