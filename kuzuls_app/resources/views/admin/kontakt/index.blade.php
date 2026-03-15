@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-semibold">Kontaktziņojumi</h1>

<div class="mt-6 rounded-2xl bg-white border overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-zinc-50 text-zinc-600">
            <tr>
                <th class="text-left p-3">Vārds</th>
                <th class="text-left p-3">E-pasts</th>
                <th class="text-left p-3">Tēma</th>
                <th class="text-left p-3">Statuss</th>
                <th class="text-left p-3">Datums</th>
                <th class="text-right p-3 whitespace-nowrap">Rīcības</th>
            </tr>
        </thead>

        <tbody>
        @foreach($zinojumi as $z)
            @php
                $statusVal = ($z->statuss?->value ?? $z->statuss);
            @endphp

            <tr class="border-t align-top">
                <td class="p-3 font-medium">{{ $z->vards }}</td>
                <td class="p-3">{{ $z->epasts }}</td>
                <td class="p-3">{{ $z->tema ?? '—' }}</td>

                <td class="p-3">
                    <span class="inline-flex items-center rounded-full px-2 py-1 text-xs {{ $statusVal === 'jauns' ? 'bg-yellow-100 text-yellow-800' : 'bg-zinc-100 text-zinc-700' }}">
                        {{ $statusVal }}
                    </span>
                </td>

                <td class="p-3">
                    {{ optional($z->created_at)->format('d.m.Y H:i') }}
                </td>

                <td class="p-3 text-right whitespace-nowrap space-x-2">
                    <button type="button"
                            class="btn-secondary toggle-msg-btn"
                            data-msg-id="{{ $z->id }}">
                    Skatīt
                    </button>

                    @if($statusVal === 'jauns')
                        <form class="inline" method="post" action="{{ route('admin.kontakt.process',$z) }}">
                            @csrf
                            @method('PATCH')
                            <button class="btn-secondary" type="submit">Atzīmēt kā apstrādātu</button>
                        </form>
                    @endif
                </td>
            </tr>

            {{-- Ziņojums (paslēpts pēc noklusējuma, parādās nospiežot "Skatīt") --}}
            <tr id="msg-{{ $z->id }}" class="border-t hidden">
                <td colspan="6" class="p-3 bg-zinc-50 text-zinc-700">
                    <div class="text-xs text-zinc-500 mb-1">Ziņojums</div>
                    <div class="whitespace-pre-wrap">{{ $z->zinojums }}</div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<div class="mt-6">{{ $zinojumi->links() }}</div>

<script>
  document.addEventListener('click', (e) => {
    const btn = e.target.closest('.toggle-msg-btn');
    if (!btn) return;

    const id = btn.dataset.msgId;
    const el = document.getElementById('msg-' + id);
    if (!el) return;

    el.classList.toggle('hidden');
  });
</script>
@endsection