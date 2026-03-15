@extends('layouts.public')
@section('title', $galerija->nosaukums)

@section('content')
@php
    use Illuminate\Support\Facades\Storage;
@endphp

<div class="space-y-8">
    <article class="content-card reveal-up">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <div class="section-eyebrow">Galerija</div>
                <h1 class="mt-2 text-3xl font-semibold tracking-tight">{{ $galerija->nosaukums }}</h1>
                @if($galerija->apraksts)
                    <p class="mt-4 text-zinc-700 leading-7">{{ $galerija->apraksts }}</p>
                @endif
            </div>

            <a class="btn-secondary btn-pill" href="{{ route('public.galerijas.index') }}">← Atpakaļ</a>
        </div>
    </article>

    @if($galerija->atteli->count() === 0)
        <div class="content-card text-zinc-600">
            Šajā galerijā vēl nav attēlu.
        </div>
    @else
        <div class="reveal-up delay-1 grid sm:grid-cols-2 md:grid-cols-3 gap-4">
            @foreach($galerija->atteli as $a)
                @php
                    $url = Storage::disk('public')->exists($a->fails_cels)
                        ? Storage::url($a->fails_cels)
                        : asset('storage/'.$a->fails_cels);
                @endphp

                <a href="{{ $url }}" target="_blank" rel="noopener"
                   class="group block overflow-hidden rounded-[1.5rem] border bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    <img src="{{ $url }}"
                         alt="{{ $a->alt_teksts ?? $galerija->nosaukums }}"
                         class="h-52 w-full object-cover transition-transform duration-300 group-hover:scale-[1.03]" />
                    @if($a->alt_teksts)
                        <div class="p-4 text-sm text-zinc-700">{{ $a->alt_teksts }}</div>
                    @endif
                </a>
            @endforeach
        </div>
    @endif

    <div class="content-card">
        @include('public.partials.related-links', ['sourceType' => 'galerijas', 'sourceId' => $galerija->id])
    </div>
</div>
@endsection