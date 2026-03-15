@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-semibold">Labot galeriju</h1>

<div class="grid lg:grid-cols-2 gap-6 mt-6">
    <form class="rounded-2xl bg-white border p-6 space-y-4" method="post" action="{{ route('admin.galerijas.update',$galerija) }}">
        @csrf @method('PUT')
        @include('admin.galerijas.partials.form', ['galerija' => $galerija])
        <div class="flex gap-2">
            <button class="btn-primary" type="submit">Saglabāt</button>
            <a class="btn-secondary" href="{{ route('admin.galerijas.index') }}">Atpakaļ</a>
        </div>
    </form>

    <div class="rounded-2xl bg-white border p-6">
        <h2 class="font-semibold">Attēli</h2>

        <form class="mt-4 space-y-3" method="post" action="{{ route('admin.galerijas.atteli.store',$galerija) }}" enctype="multipart/form-data">
            @csrf
            <div>
                <label class="block text-sm font-medium">Attēls</label>
                <input type="file" name="image" accept="image/*"
                       class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
                @error('image')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium">Alt teksts</label>
                    <input name="alt_teksts" value="{{ old('alt_teksts') }}"
                           class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
                    @error('alt_teksts')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium">Secība</label>
                    <input type="number" min="0" name="seciba" value="{{ old('seciba', 0) }}"
                           class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
                    @error('seciba')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
                </div>
            </div>
            <button class="btn-primary" type="submit">Augšupielādēt</button>
        </form>

        <div class="mt-6 grid sm:grid-cols-2 gap-4">
            @foreach($galerija->atteli as $a)
                <div class="rounded-2xl border overflow-hidden bg-zinc-50">
                    <img class="h-36 w-full object-cover" src="{{ asset('storage/'.$a->fails_cels) }}" alt="{{ $a->alt_teksts ?? '' }}">
                    <div class="p-3 text-sm">
                        <div class="text-zinc-700">{{ $a->alt_teksts ?? '—' }}</div>
                        <div class="text-zinc-500">Secība: {{ $a->seciba }}</div>
                        <form class="mt-2" method="post" action="{{ route('admin.galerijas.atteli.destroy', [$galerija, $a]) }}" onsubmit="return confirm('Dzēst attēlu?')">
                            @csrf @method('DELETE')
                            <button class="btn-secondary" type="submit">Dzēst</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection