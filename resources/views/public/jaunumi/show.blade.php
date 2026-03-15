@extends('layouts.public')
@section('title', $jaunums->virsraksts)

@section('content')
@php
    use Illuminate\Support\Facades\Storage;
@endphp

<div class="space-y-8">
    <article class="content-card reveal-up">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <div class="section-eyebrow">Jaunums</div>
                <h1 class="mt-2 text-3xl font-semibold tracking-tight">{{ $jaunums->virsraksts }}</h1>
                <div class="mt-3 text-sm text-zinc-600">
                    {{ $jaunums->publicesanas_datums?->format('d.m.Y') ?? '—' }}
                </div>

                @if($jaunums->ievads)
                    <p class="mt-4 text-zinc-700 leading-7">{{ $jaunums->ievads }}</p>
                @endif
            </div>

            <a class="btn-secondary btn-pill" href="{{ route('public.jaunumi.index') }}">← Atpakaļ</a>
        </div>

        <div class="prose max-w-none mt-6">
            {!! nl2br(e($jaunums->saturs)) !!}
        </div>

        <div class="mt-8">
            @include('public.partials.related-links', ['sourceType' => 'jaunumi', 'sourceId' => $jaunums->id])
        </div>
    </article>

    @if(isset($galerija) && $galerija && $galerija->atteli->count())
        <section class="content-card reveal-up delay-1">
            <div class="flex items-center justify-between gap-3">
                <h2 class="text-xl font-semibold">Saistītā galerija</h2>
                <a href="{{ route('public.galerijas.show', $galerija) }}" class="text-yellow-700 text-sm hover:underline">
                    Skatīt visu galeriju →
                </a>
            </div>

            <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-3">
                @foreach($galerija->atteli->take(8) as $a)
                    @php
                        $url = Storage::disk('public')->exists($a->fails_cels)
                            ? Storage::url($a->fails_cels)
                            : asset('storage/'.$a->fails_cels);
                    @endphp

                    <a href="{{ $url }}" target="_blank" rel="noopener"
                       class="block rounded-xl overflow-hidden border hover:border-yellow-300">
                        <img src="{{ $url }}"
                             alt="{{ $a->alt_teksts ?? $galerija->nosaukums }}"
                             class="h-32 w-full object-cover">
                    </a>
                @endforeach
            </div>
        </section>
    @endif
</div>
@endsection