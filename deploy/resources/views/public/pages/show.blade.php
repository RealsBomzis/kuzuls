@extends('layouts.public')
@section('title', $lapa->virsraksts)

@section('content')
<article class="rounded-2xl bg-white border p-6">
    <h1 class="text-2xl font-semibold">{{ $lapa->virsraksts }}</h1>

    <div class="prose max-w-none mt-6">
        {!! nl2br(e($lapa->saturs)) !!}
    </div>

    @include('public.partials.related-links', ['sourceType' => 'lapas', 'sourceId' => $lapa->id])
</article>
@endsection