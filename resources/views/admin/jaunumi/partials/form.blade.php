@php
    $j = $jaunums;
@endphp

<div>
    <label class="block text-sm font-medium">Virsraksts</label>
    <input name="virsraksts" value="{{ old('virsraksts', $j->virsraksts ?? '') }}"
           class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
    @error('virsraksts')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
</div>

<div>
    <label class="block text-sm font-medium">Ievads</label>
    <input name="ievads" value="{{ old('ievads', $j->ievads ?? '') }}"
           class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
    @error('ievads')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
</div>

<div>
    <label class="block text-sm font-medium">Saturs</label>
    <textarea name="saturs" rows="10"
              class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">{{ old('saturs', $j->saturs ?? '') }}</textarea>
    @error('saturs')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
</div>

<div class="grid md:grid-cols-3 gap-4">
    <div>
        <label class="block text-sm font-medium">Publicēšanas datums</label>
        <input type="date" name="publicesanas_datums"
               value="{{ old('publicesanas_datums', optional($j->publicesanas_datums ?? null)->toDateString()) }}"
               class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
        @error('publicesanas_datums')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-medium">Kategorija</label>
        <select name="kategorija_id" class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
            <option value="">—</option>
            @foreach($kategorijas as $k)
                <option value="{{ $k->id }}" @selected((string)old('kategorija_id', $j->kategorija_id ?? '') === (string)$k->id)>
                    {{ $k->nosaukums }}
                </option>
            @endforeach
        </select>
        @error('kategorija_id')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
    </div>
</div>

<div class="flex items-center gap-2">
    <input id="publicets" type="checkbox" name="publicets" value="1"
           class="rounded border-zinc-300 text-yellow-500 focus:ring-yellow-400"
           @checked(old('publicets', $j->publicets ?? false))>
    <label for="publicets" class="text-sm">Publicēts</label>
</div>