{{-- resources/views/public/contact.blade.php --}}
@extends('layouts.public')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-10">
    <h1 class="text-3xl font-semibold">Kontakti</h1>
    <p class="mt-2 text-zinc-600">
        Sazinies ar mums, aizpildot formu zemāk.
    </p>

    @if(session('status'))
        <div class="mt-6 rounded-xl border border-yellow-200 bg-yellow-50 px-4 py-3 text-yellow-900">
            {{ session('status') }}
        </div>
    @endif

    <form class="mt-6 space-y-4 rounded-2xl border bg-white p-6"
          method="post"
          action="{{ route('contact.store') }}">
        @csrf

        <div>
            <label class="block text-sm font-medium" for="vards">Vārds</label>
            <input id="vards" name="vards" value="{{ old('vards') }}"
                   class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
            @error('vards')<div class="mt-1 text-sm text-red-600">{{ $message }}</div>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium" for="epasts">E-pasts</label>
            <input id="epasts" type="email" name="epasts" value="{{ old('epasts') }}"
                   class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
            @error('epasts')<div class="mt-1 text-sm text-red-600">{{ $message }}</div>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium" for="tema">Tēma</label>
            <input id="tema" name="tema" value="{{ old('tema') }}"
                   class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
            @error('tema')<div class="mt-1 text-sm text-red-600">{{ $message }}</div>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium" for="zinojums">Ziņojums</label>
            <textarea id="zinojums" name="zinojums" rows="6"
                      class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">{{ old('zinojums') }}</textarea>
            @error('zinojums')<div class="mt-1 text-sm text-red-600">{{ $message }}</div>@enderror
        </div>

        <button class="btn-primary" type="submit">Nosūtīt</button>
    </form>
</div>
@endsection