@php
    $p = $projekts;
@endphp

<div>
    <label class="block text-sm font-medium">Nosaukums</label>
    <input name="nosaukums" value="{{ old('nosaukums', $p->nosaukums ?? '') }}"
           class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
    @error('nosaukums')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
</div>

<div>
    <label class="block text-sm font-medium">Apraksts</label>
    <textarea name="apraksts" rows="6"
              class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">{{ old('apraksts', $p->apraksts ?? '') }}</textarea>
    @error('apraksts')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
</div>

<div class="grid md:grid-cols-3 gap-4">
    <div>
        <label class="block text-sm font-medium">Statuss</label>
        <select name="statuss" class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
            @php $val = old('statuss', $p->statuss?->value ?? 'planots'); @endphp
            <option value="planots" @selected($val==='planots')>Plānots</option>
            <option value="aktivs" @selected($val==='aktivs')>Aktīvs</option>
            <option value="pabeigts" @selected($val==='pabeigts')>Pabeigts</option>
        </select>
        @error('statuss')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
    </div>
    <div>
        <label class="block text-sm font-medium">Sākuma datums</label>
        <input type="date" name="sakuma_datums" value="{{ old('sakuma_datums', optional($p->sakuma_datums ?? null)->toDateString()) }}"
               class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
        @error('sakuma_datums')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
    </div>
    <div>
        <label class="block text-sm font-medium">Beigu datums</label>
        <input type="date" name="beigu_datums" value="{{ old('beigu_datums', optional($p->beigu_datums ?? null)->toDateString()) }}"
               class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
        @error('beigu_datums')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
    </div>
</div>

<div>
    <label class="block text-sm font-medium">Kategorija</label>
    <select name="kategorija_id" class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
        <option value="">—</option>
        @foreach($kategorijas as $k)
            <option value="{{ $k->id }}" @selected((string)old('kategorija_id', $p->kategorija_id ?? '') === (string)$k->id)>
                {{ $k->nosaukums }}
            </option>
        @endforeach
    </select>
    @error('kategorija_id')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
</div>

<div class="flex items-center gap-2">
    <input id="publicets" type="checkbox" name="publicets" value="1"
           class="rounded border-zinc-300 text-yellow-500 focus:ring-yellow-400"
           @checked(old('publicets', $p->publicets ?? false))>
    <label for="publicets" class="text-sm">Publicēts</label>
</div>