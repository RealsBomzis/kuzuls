@extends('layouts.public')
@section('title', $projekts->nosaukums)

@section('content')
<article class="rounded-2xl bg-white border p-6">
    <div class="flex flex-wrap items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold">{{ $projekts->nosaukums }}</h1>
            <div class="mt-2 text-sm text-zinc-600">
                Statuss:
                <span class="inline-flex items-center rounded-full px-2 py-1 text-xs bg-yellow-50 border border-yellow-200 text-yellow-800">
                    {{ ucfirst($projekts->statuss?->value ?? 'planots') }}
                </span>
            </div>
            <div class="mt-2 text-sm text-zinc-600">
                Sākums: {{ optional($projekts->sakuma_datums)->format('d.m.Y') }}
                @if($projekts->beigu_datums)
                    · Beigas: {{ optional($projekts->beigu_datums)->format('d.m.Y') }}
                @endif
            </div>
        </div>
        <a class="btn-secondary" href="{{ route('public.projekti.index') }}">← Atpakaļ</a>
    </div>

    <div class="prose max-w-none mt-6">
        {!! nl2br(e($projekts->apraksts)) !!}
    </div>

    @include('public.partials.related-links', ['sourceType' => 'projekti', 'sourceId' => $projekts->id])
</article>
@endsection