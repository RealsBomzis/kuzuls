@extends('layouts.public')
@section('title','Pasākumi')

@section('content')
<div class="flex items-end justify-between gap-4">
    <div>
        <h1 class="text-2xl font-semibold">Pasākumi</h1>
        <p class="text-zinc-600">Tikai publicētie pasākumi.</p>
    </div>
</div>

<form class="mt-6 rounded-2xl bg-white border p-4 flex flex-wrap gap-3 items-end" method="get">
    <div class="flex-1 min-w-[240px]">
        <label class="block text-sm font-medium">Meklēt</label>
        <input name="q" value="{{ request('q') }}" class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400" />
    </div>
    <div>
        <label class="block text-sm font-medium">Kārtot</label>
        <select name="sort" class="mt-1 rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
            <option value="date_asc" @selected(request('sort','date_asc')==='date_asc')>Datums ↑</option>
            <option value="date_desc" @selected(request('sort')==='date_desc')>Datums ↓</option>
        </select>
    </div>
    <button class="btn-primary" type="submit">Filtrēt</button>
</form>

<div class="mt-6 grid md:grid-cols-2 gap-4">
@foreach($pasakumi as $p)
    <a class="rounded-2xl bg-white border p-5 hover:border-yellow-300" href="{{ route('public.pasakumi.show',$p) }}">
        <div class="font-semibold">{{ $p->nosaukums }}</div>
        <div class="mt-1 text-sm text-zinc-600">{{ $p->norises_datums?->format('d.m.Y') }} · {{ $p->vieta }}</div>
        @if($p->apraksts)
            <div class="mt-2 text-sm text-zinc-700 line-clamp-3">{{ $p->apraksts }}</div>
        @endif
    </a>
@endforeach
</div>

<div class="mt-6">
    {{ $pasakumi->links() }}
</div>
@endsection