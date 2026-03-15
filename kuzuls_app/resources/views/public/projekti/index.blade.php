@extends('layouts.public')
@section('title','Projekti')

@section('content')
<div class="flex items-end justify-between gap-4">
    <div>
        <h1 class="text-2xl font-semibold">Projekti</h1>
        <p class="text-zinc-600">Tikai publicētie projekti.</p>
    </div>
</div>

<form class="mt-6 rounded-2xl bg-white border p-4 flex flex-wrap gap-3 items-end" method="get">
    <div class="flex-1 min-w-[240px]">
        <label class="block text-sm font-medium" for="q">Meklēt</label>
        <input id="q" name="q" value="{{ request('q') }}"
               class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400" />
    </div>

    <div>
        <label class="block text-sm font-medium" for="statuss">Statuss</label>
        <select id="statuss" name="statuss"
                class="mt-1 rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
            <option value="">Visi</option>
            <option value="planots" @selected(request('statuss')==='planots')>Plānots</option>
            <option value="aktivs" @selected(request('statuss')==='aktivs')>Aktīvs</option>
            <option value="pabeigts" @selected(request('statuss')==='pabeigts')>Pabeigts</option>
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium" for="sort">Kārtot</label>
        <select id="sort" name="sort"
                class="mt-1 rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
            <option value="start_desc" @selected(request('sort','start_desc')==='start_desc')>Sākums ↓</option>
            <option value="start_asc" @selected(request('sort')==='start_asc')>Sākums ↑</option>
            <option value="end_desc" @selected(request('sort')==='end_desc')>Beigas ↓</option>
            <option value="end_asc" @selected(request('sort')==='end_asc')>Beigas ↑</option>
        </select>
    </div>

    <button class="btn-primary" type="submit">Filtrēt</button>

    @if(request()->hasAny(['q','statuss','sort','kategorija_id']))
        <a class="btn-secondary" href="{{ route('public.projekti.index') }}">Notīrīt</a>
    @endif
</form>

@if($projekti->count() === 0)
    <div class="mt-6 rounded-2xl bg-white border p-6 text-zinc-700">
        Nav atrastu projektu.
    </div>
@else
    <div class="mt-6 grid md:grid-cols-2 gap-4">
        @foreach($projekti as $p)
            <a class="rounded-2xl bg-white border p-5 hover:border-yellow-300 focus:outline-none focus:ring-2 focus:ring-yellow-400"
               href="{{ route('public.projekti.show',$p) }}">
                <div class="flex items-center justify-between gap-3">
                    <div class="font-semibold">{{ $p->nosaukums }}</div>
                    <span class="inline-flex items-center rounded-full px-2 py-1 text-xs bg-yellow-50 border border-yellow-200 text-yellow-800">
                        {{ ucfirst($p->statuss?->value ?? 'planots') }}
                    </span>
                </div>

                <div class="mt-1 text-sm text-zinc-600">
                    Sākums: {{ optional($p->sakuma_datums)->format('d.m.Y') }}
                    @if($p->beigu_datums)
                        · Beigas: {{ optional($p->beigu_datums)->format('d.m.Y') }}
                    @endif
                </div>

                <div class="mt-2 text-sm text-zinc-700 line-clamp-3">
                    {{ $p->apraksts }}
                </div>
            </a>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $projekti->links() }}
    </div>
@endif
@endsection