@extends('layouts.public')

@section('title','Kontakti')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <section class="page-hero reveal-up">
        <div class="section-header">
            <div class="section-eyebrow">Kontakti</div>
            <h1 class="section-title">Sazinies ar mums</h1>
            <p class="section-text">
                Ja vēlies uzdot jautājumu, iesaistīties vai uzzināt vairāk par Biedrības Kūzuls darbību, raksti mums.
            </p>
        </div>
    </section>

    <form class="reveal-up delay-1 rounded-[2rem] border bg-white p-6 md:p-8 shadow-sm"
          method="post"
          action="{{ route('contact.store') }}">
        @csrf

        <div class="grid gap-5 md:grid-cols-2">
            <div>
                <label class="block text-sm font-medium" for="vards">Vārds</label>
                <input id="vards" name="vards" value="{{ old('vards') }}"
                       class="mt-1 w-full rounded-xl border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
                @error('vards')<div class="mt-1 text-sm text-red-600">{{ $message }}</div>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium" for="epasts">E-pasts</label>
                <input id="epasts" type="email" name="epasts" value="{{ old('epasts') }}"
                       class="mt-1 w-full rounded-xl border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
                @error('epasts')<div class="mt-1 text-sm text-red-600">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="mt-5">
            <label class="block text-sm font-medium" for="tema">Tēma</label>
            <input id="tema" name="tema" value="{{ old('tema') }}"
                   class="mt-1 w-full rounded-xl border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
            @error('tema')<div class="mt-1 text-sm text-red-600">{{ $message }}</div>@enderror
        </div>

        <div class="mt-5">
            <label class="block text-sm font-medium" for="zinojums">Ziņojums</label>
            <textarea id="zinojums" name="zinojums" rows="7"
                      class="mt-1 w-full rounded-xl border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">{{ old('zinojums') }}</textarea>
            @error('zinojums')<div class="mt-1 text-sm text-red-600">{{ $message }}</div>@enderror
        </div>

        <div class="mt-6">
            <button class="btn-primary btn-pill" type="submit">Nosūtīt ziņojumu</button>
        </div>
    </form>
</div>
@endsection