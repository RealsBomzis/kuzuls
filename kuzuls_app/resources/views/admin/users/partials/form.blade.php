@php $u = $user; @endphp

<div>
    <label class="block text-sm font-medium">Vārds</label>
    <input name="name" value="{{ old('name', $u->name ?? '') }}"
           class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
    @error('name')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
</div>

<div>
    <label class="block text-sm font-medium">E-pasts</label>
    <input name="email" value="{{ old('email', $u->email ?? '') }}"
           class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
    @error('email')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
</div>

<div>
    <label class="block text-sm font-medium">Parole {{ $u ? '(atstāt tukšu, ja nemaina)' : '' }}</label>
    <input type="password" name="password"
           class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
    @error('password')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
</div>

<div class="flex items-center gap-2">
    <input id="is_active" type="checkbox" name="is_active" value="1"
           class="rounded border-zinc-300 text-yellow-500 focus:ring-yellow-400"
           @checked(old('is_active', $u->is_active ?? true))>
    <label for="is_active" class="text-sm">Aktīvs</label>
</div>

<div>
    <label class="block text-sm font-medium">Lomas</label>
    <div class="mt-2 grid sm:grid-cols-2 gap-2">
        @php
            $selected = collect(old('role_ids', $u?->roles?->pluck('id')->all() ?? []))->map(fn($x)=>(string)$x)->all();
        @endphp
        @foreach($roles as $r)
            <label class="flex items-center gap-2 rounded-lg border p-2">
                <input type="checkbox" name="role_ids[]" value="{{ $r->id }}"
                       class="rounded border-zinc-300 text-yellow-500 focus:ring-yellow-400"
                       @checked(in_array((string)$r->id, $selected, true))>
                <span class="text-sm">{{ $r->nosaukums }}</span>
            </label>
        @endforeach
    </div>
    @error('role_ids')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
</div>