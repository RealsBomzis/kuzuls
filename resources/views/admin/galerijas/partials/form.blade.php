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
                <option value="{{ $k->id }}" @selected((string)old('kategorija_id', $g->kategorija_id ?? '') === (string)$k->id)>
                    {{ $k->nosaukums }}
                </option>
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
        @php $t = old('saistita_tips', $g->saistita_tips ?? 'nav'); @endphp
        <select id="saistita_tips" name="saistita_tips"
                class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
            <option value="nav" @selected($t==='nav')>Nav</option>
            <option value="pasakumi" @selected($t==='pasakumi')>Pasākumi</option>
            <option value="projekti" @selected($t==='projekti')>Projekti</option>
            <option value="jaunumi" @selected($t==='jaunumi')>Jaunumi</option>
        </select>
        @error('saistita_tips')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
    </div>

    <div>
        <label class="block text-sm font-medium">Saistītais ieraksts</label>

        {{-- hidden final value --}}
        <input type="hidden" id="saistita_id" name="saistita_id" value="{{ old('saistita_id', $g->saistita_id ?? '') }}">

        {{-- Pasākumi --}}
        <select data-linked="pasakumi"
                class="linked-select mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400 hidden">
            <option value="">— izvēlies pasākumu —</option>
            @foreach(($pasakumi ?? []) as $p)
                <option value="{{ $p->id }}">{{ $p->id }} — {{ $p->nosaukums }}</option>
            @endforeach
        </select>

        {{-- Projekti --}}
        <select data-linked="projekti"
                class="linked-select mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400 hidden">
            <option value="">— izvēlies projektu —</option>
            @foreach(($projekti ?? []) as $p)
                <option value="{{ $p->id }}">{{ $p->id }} — {{ $p->nosaukums }}</option>
            @endforeach
        </select>

        {{-- Jaunumi --}}
        <select data-linked="jaunumi"
                class="linked-select mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400 hidden">
            <option value="">— izvēlies jaunumu —</option>
            @foreach(($jaunumi ?? []) as $j)
                <option value="{{ $j->id }}">{{ $j->id }} — {{ $j->virsraksts }}</option>
            @endforeach
        </select>

        {{-- Nav --}}
        <div id="linked-none" class="mt-1 text-sm text-zinc-500">Nav piesaistes.</div>

        @error('saistita_id')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
        <p class="mt-1 text-xs text-zinc-500">Ja izvēlas pasākumu, galerija tiks rādīta šī pasākuma lapā.</p>
    </div>
</div>

<script>
    (function () {
        const typeSelect = document.getElementById('saistita_tips');
        const hiddenInput = document.getElementById('saistita_id');
        const allSelects = Array.from(document.querySelectorAll('.linked-select'));
        const noneBlock = document.getElementById('linked-none');

        function syncVisibleSelect() {
            const type = typeSelect.value;

            allSelects.forEach(el => el.classList.add('hidden'));
            noneBlock.classList.add('hidden');

            if (type === 'nav') {
                hiddenInput.value = '';
                noneBlock.classList.remove('hidden');
                return;
            }

            const active = document.querySelector(`.linked-select[data-linked="${type}"]`);
            if (!active) {
                noneBlock.classList.remove('hidden');
                return;
            }

            active.classList.remove('hidden');

            if (hiddenInput.value) {
                active.value = hiddenInput.value;
            }

            hiddenInput.value = active.value || '';
        }

        allSelects.forEach(el => {
            el.addEventListener('change', function () {
                if (!this.classList.contains('hidden')) {
                    hiddenInput.value = this.value || '';
                }
            });
        });

        typeSelect.addEventListener('change', function () {
            hiddenInput.value = '';
            allSelects.forEach(el => el.value = '');
            syncVisibleSelect();
        });

        syncVisibleSelect();
    })();
</script>