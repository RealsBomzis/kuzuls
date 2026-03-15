@extends('layouts.public')
@section('title',$pasakums->nosaukums)

@section('content')
@php
    use Illuminate\Support\Facades\Storage;

    $pasakumaImg = null;
    if (!empty($pasakums->attels)) {
        $pasakumaImg = Storage::disk('public')->exists($pasakums->attels)
            ? Storage::url($pasakums->attels)
            : asset('storage/'.$pasakums->attels);
    }
@endphp

<article class="rounded-2xl bg-white border p-6">
    <h1 class="text-2xl font-semibold">{{ $pasakums->nosaukums }}</h1>

    <div class="mt-2 text-sm text-zinc-600">
        {{ $pasakums->norises_datums?->format('d.m.Y') }}
        · {{ $pasakums->sakuma_laiks }}@if($pasakums->beigu_laiks)–{{ $pasakums->beigu_laiks }}@endif
        · {{ $pasakums->vieta }}
    </div>

    @if($pasakumaImg)
        <div class="mt-5">
            <img src="{{ $pasakumaImg }}"
                 alt="{{ $pasakums->nosaukums }}"
                 class="w-full max-h-[420px] object-cover rounded-2xl border">
        </div>
    @endif

    @if($pasakums->apraksts)
        <div class="prose max-w-none mt-4">{!! nl2br(e($pasakums->apraksts)) !!}</div>
    @endif
</article>

@if($galerija && $galerija->atteli->count())
    <section class="mt-8 rounded-2xl bg-white border p-6">
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
@endsection


