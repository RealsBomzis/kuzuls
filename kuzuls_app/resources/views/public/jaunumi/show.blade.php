@extends('layouts.public')
@section('title', $jaunums->virsraksts)

@section('content')
<article class="rounded-2xl bg-white border p-6">
    <div class="flex flex-wrap items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold">{{ $jaunums->virsraksts }}</h1>
            <div class="mt-2 text-sm text-zinc-600">
                {{ $jaunums->publicesanas_datums?->format('d.m.Y') ?? '—' }}
            </div>
            @if($jaunums->ievads)
                <p class="mt-4 text-zinc-700">{{ $jaunums->ievads }}</p>
            @endif
        </div>
        <a class="btn-secondary" href="{{ route('public.jaunumi.index') }}">← Atpakaļ</a>
    </div>

    <div class="prose max-w-none mt-6">
        {!! nl2br(e($jaunums->saturs)) !!}
    </div>

    @include('public.partials.related-links', ['sourceType' => 'jaunumi', 'sourceId' => $jaunums->id])
</article>
@endsection