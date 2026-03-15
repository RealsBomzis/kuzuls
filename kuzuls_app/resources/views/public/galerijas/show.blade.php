@extends('layouts.public')
@section('title', $galerija->nosaukums)

@section('content')
@php
    use Illuminate\Support\Facades\Storage;
@endphp

<article class="rounded-2xl bg-white border p-6">
    <div class="flex flex-wrap items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold">{{ $galerija->nosaukums }}</h1>
            @if($galerija->apraksts)
                <p class="mt-2 text-zinc-700">{{ $galerija->apraksts }}</p>
            @endif
        </div>
        <a class="btn-secondary" href="{{ route('public.galerijas.index') }}">← Atpakaļ</a>
    </div>

    @if($galerija->atteli->count() === 0)
        <div class="mt-6 rounded-xl border border-zinc-200 bg-zinc-50 p-4 text-sm text-zinc-700">
            Šajā galerijā vēl nav attēlu.
        </div>
    @else
        <div class="mt-6 grid sm:grid-cols-2 md:grid-cols-3 gap-4">
            @foreach($galerija->atteli as $a)
                @php
                    $url = Storage::disk('public')->exists($a->fails_cels)
                        ? Storage::url($a->fails_cels)
                        : asset('storage/'.$a->fails_cels); // works for seeded placeholders
                @endphp
                <a href="{{ $url }}" target="_blank" rel="noopener"
                   class="group block overflow-hidden rounded-2xl border bg-zinc-50 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    <img src="{{ $url }}"
                         alt="{{ $a->alt_teksts ?? $galerija->nosaukums }}"
                         class="h-48 w-full object-cover transition-transform duration-200 group-hover:scale-[1.02]" />
                    @if($a->alt_teksts)
                        <div class="p-3 text-sm text-zinc-700">{{ $a->alt_teksts }}</div>
                    @endif
                </a>
            @endforeach
        </div>
    @endif

    @include('public.partials.related-links', ['sourceType' => 'galerijas', 'sourceId' => $galerija->id])
</article>
@endsection