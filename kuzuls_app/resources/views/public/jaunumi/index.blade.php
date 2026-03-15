@extends('layouts.public')
@section('title','Jaunumi')

@section('content')
<div class="flex items-end justify-between gap-4">
    <div>
        <h1 class="text-2xl font-semibold">Jaunumi</h1>
        <p class="text-zinc-600">Tikai publicētie jaunumi.</p>
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
            <option value="newest" @selected(request('sort','newest')==='newest')>Jaunākie</option>
            <option value="oldest" @selected(request('sort')==='oldest')>Vecākie</option>
        </select>
    </div>

    <button class="btn-primary" type="submit">Filtrēt</button>

    @if(request()->hasAny(['q','sort','kategorija_id']))
        <a class="btn-secondary" href="{{ route('public.jaunumi.index') }}">Notīrīt</a>
    @endif
</form>

@if($jaunumi->count() === 0)
    <div class="mt-6 rounded-2xl bg-white border p-6 text-zinc-700">
        Nav atrastu jaunumu.
    </div>
@else
    <div class="mt-6 grid md:grid-cols-2 gap-4">
        @foreach($jaunumi as $j)
            <a class="rounded-2xl bg-white border p-5 hover:border-yellow-300 focus:outline-none focus:ring-2 focus:ring-yellow-400"
               href="{{ route('public.jaunumi.show',$j) }}">
                <div class="font-semibold">{{ $j->virsraksts }}</div>
                <div class="mt-1 text-sm text-zinc-600">
                    {{ $j->publicesanas_datums?->format('d.m.Y') ?? '—' }}
                </div>
                @if($j->ievads)
                    <div class="mt-2 text-sm text-zinc-700 line-clamp-3">{{ $j->ievads }}</div>
                @else
                    <div class="mt-2 text-sm text-zinc-700 line-clamp-3">{{ \Illuminate\Support\Str::limit(strip_tags($j->saturs), 160) }}</div>
                @endif
            </a>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $jaunumi->links() }}
    </div>
@endif
@endsection