@php $k = $kategorija; @endphp

<div>
    <label class="block text-sm font-medium">Nosaukums</label>
    <input name="nosaukums" value="{{ old('nosaukums', $k->nosaukums ?? '') }}"
           class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
    @error('nosaukums')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
</div>

<div>
    <label class="block text-sm font-medium">Tips</label>
    <select name="tips" class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
        @php $t = old('tips', $k->tips ?? 'visiem'); @endphp
        @foreach(['visiem','pasakumi','projekti','jaunumi','galerijas','lapas'] as $opt)
            <option value="{{ $opt }}" @selected($t===$opt)>{{ $opt }}</option>
        @endforeach
    </select>
    @error('tips')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
</div>