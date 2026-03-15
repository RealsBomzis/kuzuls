@extends('layouts.public')
@section('title',$pasakums->nosaukums)

@section('content')
<article class="rounded-2xl bg-white border p-6">
    <h1 class="text-2xl font-semibold">{{ $pasakums->nosaukums }}</h1>
    <div class="mt-2 text-sm text-zinc-600">
        {{ $pasakums->norises_datums?->format('d.m.Y') }}
        · {{ $pasakums->sakuma_laiks }}@if($pasakums->beigu_laiks)–{{ $pasakums->beigu_laiks }}@endif
        · {{ $pasakums->vieta }}
    </div>
    @if($pasakums->apraksts)
        <div class="prose max-w-none mt-4">{!! nl2br(e($pasakums->apraksts)) !!}</div>
    @endif
</article>
@endsection