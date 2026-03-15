@php
    $p = $pasakums;
@endphp

<div>
    <label class="block text-sm font-medium" for="nosaukums">Nosaukums</label>
    <input id="nosaukums" name="nosaukums"
           value="{{ old('nosaukums', $p->nosaukums ?? '') }}"
           class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
    @error('nosaukums')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
</div>

<div>
    <label class="block text-sm font-medium" for="apraksts">Apraksts</label>
    <textarea id="apraksts" name="apraksts" rows="6"
              class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">{{ old('apraksts', $p->apraksts ?? '') }}</textarea>
    @error('apraksts')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
</div>

<div class="grid md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium" for="norises_datums">Datums</label>
        <input id="norises_datums" type="date" name="norises_datums"
               value="{{ old('norises_datums', optional($p->norises_datums ?? null)->format('Y-m-d') ?? '') }}"
               class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
        @error('norises_datums')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
    </div>

    <div>
        <label class="block text-sm font-medium" for="sakuma_laiks">Laiks</label>
        <input id="sakuma_laiks" type="time" name="sakuma_laiks"
               value="{{ old('sakuma_laiks', !empty($p->sakuma_laiks) ? \Illuminate\Support\Str::of($p->sakuma_laiks)->substr(0,5) : '') }}"
               class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
        @error('sakuma_laiks')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
    </div>
</div>

{{-- Optional: beigu laiks (if you have column beigu_laiks). If not, delete this block. --}}
<div class="grid md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium" for="beigu_laiks">Beigu laiks</label>
        <input id="beigu_laiks" type="time" name="beigu_laiks"
               value="{{ old('beigu_laiks', !empty($p->beigu_laiks) ? \Illuminate\Support\Str::of($p->beigu_laiks)->substr(0,5) : '') }}"
               class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
        @error('beigu_laiks')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
    </div>
    <div></div>
</div>

<div class="grid md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium" for="vieta">Vieta</label>
        <input id="vieta" name="vieta"
               value="{{ old('vieta', $p->vieta ?? '') }}"
               class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
        @error('vieta')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
    </div>

    <div>
        <label class="block text-sm font-medium" for="kategorija_id">Kategorija</label>
        <select id="kategorija_id" name="kategorija_id"
                class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
            <option value="">—</option>
            @foreach($kategorijas as $k)
                <option value="{{ $k->id }}"
                        @selected((string)old('kategorija_id', $p->kategorija_id ?? '') === (string)$k->id)>
                    {{ $k->nosaukums }}
                </option>
            @endforeach
        </select>
        @error('kategorija_id')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
    </div>
</div>

<div class="grid md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium" for="talrunis">Tālrunis</label>
        <input id="talrunis" name="talrunis"
               value="{{ old('talrunis', $p->talrunis ?? '') }}"
               class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
        @error('talrunis')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
    </div>

    <div>
        <label class="block text-sm font-medium" for="epasts">E-pasts</label>
        <input id="epasts" type="email" name="epasts"
               value="{{ old('epasts', $p->epasts ?? '') }}"
               class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
        @error('epasts')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
    </div>
</div>

<div class="rounded-xl border border-zinc-200 bg-zinc-50 p-4">
    <div class="font-medium">Attēls</div>
    <p class="text-xs text-zinc-500 mt-1">Droša augšupielāde (attēla fails). Ja neatjauno — atstāj tukšu.</p>

    @if(!empty($p?->attels))
        <div class="mt-3 flex items-start gap-4">
            <img src="{{ asset('storage/'.$p->attels) }}" alt="" class="h-24 w-36 object-cover rounded-lg border">
            <div class="text-sm text-zinc-700">
                <div class="text-xs text-zinc-500">Pašreizējais fails</div>
                <div class="font-mono text-xs">{{ $p->attels }}</div>
            </div>
        </div>
    @endif

    <div class="mt-3">
        <label class="block text-sm font-medium" for="attels">Jauns attēls</label>
        <input id="attels" type="file" name="attels" accept="image/*"
               class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
        @error('attels')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
    </div>
</div>

<div class="flex items-center gap-2">
    <input id="publicets" type="checkbox" name="publicets" value="1"
           class="rounded border-zinc-300 text-yellow-500 focus:ring-yellow-400"
           @checked(old('publicets', (bool)($p->publicets ?? false)))>
    <label for="publicets" class="text-sm">Publicēts (redzams publiski)</label>
</div>