@extends('layouts.public')
@section('title', $lapa->virsraksts)

@section('content')
<div class="max-w-5xl mx-auto space-y-8">
    <section class="page-hero reveal-up">
        <div class="section-header">
            <div class="section-eyebrow">Informācija</div>
            <h1 class="section-title">{{ $lapa->virsraksts }}</h1>
            <p class="section-text">
                Iepazīsti Biedrības Kūzuls darbību, vērtības un galvenos virzienus.
            </p>
        </div>
    </section>

    <article class="content-card reveal-up delay-1">
        <div class="prose max-w-none">
            {!! nl2br(e($lapa->saturs)) !!}
        </div>

        <div class="mt-8">
            @include('public.partials.related-links', ['sourceType' => 'lapas', 'sourceId' => $lapa->id])
        </div>
    </article>
</div>
@endsection