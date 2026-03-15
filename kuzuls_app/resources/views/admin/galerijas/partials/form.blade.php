@php $g = $galerija; @endphp

<div>
    <label class="block text-sm font-medium">Nosaukums</label>
    <input name="nosaukums" value="{{ old('nosaukums', $g->nosaukums ?? '') }}"
           class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
    @error('nosaukums')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
</div>

<div>
    <label class="block text-sm font-medium">Apraksts</label>
    <textarea name="apraksts" rows="4"
              class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">{{ old('apraksts', $g->apraksts ?? '') }}</textarea>
    @error('apraksts')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
</div>

<div class="grid md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium">Kategorija</label>
        <select name="kategorija_id" class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
            <option value="">—</option>
            @foreach($kategorijas as $k)
                <option value="{{ $k->id }}" @selected((string)old('kategorija_id', $g->kategorija_id ?? '') === (string)$k->id)>{{ $k->nosaukums }}</option>
            @endforeach
        </select>
        @error('kategorija_id')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
    </div>

    <div>
        <label class="block text-sm font-medium">Publicēts</label>
        <div class="mt-2 flex items-center gap-2">
            <input id="publicets" type="checkbox" name="publicets" value="1"
                   class="rounded border-zinc-300 text-yellow-500 focus:ring-yellow-400"
                   @checked(old('publicets', $g->publicets ?? false))>
            <label for="publicets" class="text-sm">Redzams publiski</label>
        </div>
    </div>
</div>

<div class="grid md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium">Saistīta tips</label>
        <select name="saistita_tips" class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
            @php $t = old('saistita_tips', $g->saistita_tips ?? 'nav'); @endphp
            <option value="nav" @selected($t==='nav')>Nav</option>
            <option value="pasakumi" @selected($t==='pasakumi')>Pasākumi</option>
            <option value="projekti" @selected($t==='projekti')>Projekti</option>
            <option value="jaunumi" @selected($t==='jaunumi')>Jaunumi</option>
        </select>
        @error('saistita_tips')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
    </div>

    <div>
        <label class="block text-sm font-medium">Saistīta ID</label>
        <input name="saistita_id" value="{{ old('saistita_id', $g->saistita_id ?? '') }}"
               class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
        @error('saistita_id')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
        <p class="mt-1 text-xs text-zinc-500">Obligāts, ja “Saistīta tips” nav “Nav”.</p>
    </div>
</div>