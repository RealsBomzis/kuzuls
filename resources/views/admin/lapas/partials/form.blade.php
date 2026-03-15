@php $l = $lapa; @endphp

<div>
    <label class="block text-sm font-medium">Slug</label>
    <input name="slug" value="{{ old('slug', $l->slug ?? '') }}"
           placeholder="piemeram: par-biedribu"
           class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
    @error('slug')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
    <p class="mt-1 text-xs text-zinc-500">Atļauts: mazie burti, cipari, “-”.</p>
</div>

<div>
    <label class="block text-sm font-medium">Virsraksts</label>
    <input name="virsraksts" value="{{ old('virsraksts', $l->virsraksts ?? '') }}"
           class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
    @error('virsraksts')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
</div>

<div>
    <label class="block text-sm font-medium">Saturs</label>
    <textarea name="saturs" rows="10"
              class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">{{ old('saturs', $l->saturs ?? '') }}</textarea>
    @error('saturs')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
</div>

<div class="grid md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium">Kategorija</label>
        <select name="kategorija_id" class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
            <option value="">—</option>
            @foreach($kategorijas as $k)
                <option value="{{ $k->id }}" @selected((string)old('kategorija_id', $l->kategorija_id ?? '') === (string)$k->id)>{{ $k->nosaukums }}</option>
            @endforeach
        </select>
        @error('kategorija_id')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
    </div>

    <div class="flex items-center gap-2 mt-6">
        <input id="publicets" type="checkbox" name="publicets" value="1"
               class="rounded border-zinc-300 text-yellow-500 focus:ring-yellow-400"
               @checked(old('publicets', $l->publicets ?? true))>
        <label for="publicets" class="text-sm">Publicēts</label>
    </div>
</div>