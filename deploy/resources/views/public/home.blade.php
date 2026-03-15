@extends('layouts.public')

@section('title','Sākums')

@section('content')
<div class="grid gap-8">
    <section class="rounded-2xl bg-white border p-6">
        <h1 class="text-2xl font-semibold">Biedrība <span class="text-yellow-500">Kūzuls</span></h1>
        <p class="mt-2 text-zinc-700">Mājaslapa ar CMS: pasākumi, projekti, jaunumi, galerijas un saziņa.</p>
    </section>

    <section class="grid md:grid-cols-2 gap-6">
        <div class="rounded-2xl bg-white border p-6">
            <h2 class="font-semibold">Jaunumi</h2>
            <div class="mt-3 space-y-3">
                @foreach($jaunumi as $j)
                    <a class="block rounded-lg border p-3 hover:border-yellow-300" href="{{ route('public.jaunumi.show',$j) }}">
                        <div class="font-medium">{{ $j->virsraksts }}</div>
                        <div class="text-sm text-zinc-600">{{ $j->publicesanas_datums?->format('d.m.Y') }}</div>
                    </a>
                @endforeach
            </div>
        </div>

        <div class="rounded-2xl bg-white border p-6">
            <h2 class="font-semibold">Pasākumi</h2>
            <div class="mt-3 space-y-3">
                @foreach($pasakumi as $p)
                    <a class="block rounded-lg border p-3 hover:border-yellow-300" href="{{ route('public.pasakumi.show',$p) }}">
                        <div class="font-medium">{{ $p->nosaukums }}</div>
                        <div class="text-sm text-zinc-600">{{ $p->norises_datums?->format('d.m.Y') }} · {{ $p->vieta }}</div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
</div>
@endsection