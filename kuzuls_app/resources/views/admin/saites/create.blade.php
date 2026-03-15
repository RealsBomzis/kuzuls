@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-semibold">Jauna manuālā saite</h1>

@if ($errors->any())
  <div class="mt-4 rounded-xl border border-red-200 bg-red-50 p-4 text-red-800">
    <div class="font-semibold mb-2">Kļūdas:</div>
    <ul class="list-disc pl-5">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

<form class="mt-6 rounded-2xl bg-white border p-6 space-y-5" method="post" action="{{ route('admin.saites.store') }}">
  @csrf

  {{-- SOURCE --}}
  <div class="rounded-xl border border-zinc-200 bg-zinc-50 p-4 space-y-3">
    <div class="font-medium">Avots</div>

    <div class="grid md:grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium" for="avots_tips">Avots tips</label>
        <select id="avots_tips" name="avots_tips"
                class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
          @foreach(['pasakumi','projekti','jaunumi','lapas'] as $t)
            <option value="{{ $t }}" @selected(old('avots_tips', 'jaunumi') === $t)>{{ $t }}</option>
          @endforeach
        </select>
      </div>

      <div>
        <label class="block text-sm font-medium" for="avots_id">Avots ieraksts</label>

        {{-- We submit one hidden integer avots_id --}}
        <input type="hidden" id="avots_id" name="avots_id" value="{{ old('avots_id') }}">

        {{-- One select per type, we show only the active one --}}
        <select data-avots="pasakumi"
                class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
          <option value="">— izvēlies pasākumu —</option>
          @foreach($pasakumi as $x)
            <option value="{{ $x->id }}">{{ $x->id }} — {{ $x->nosaukums }}</option>
          @endforeach
        </select>

        <select data-avots="projekti"
                class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400 hidden">
          <option value="">— izvēlies projektu —</option>
          @foreach($projekti as $x)
            <option value="{{ $x->id }}">{{ $x->id }} — {{ $x->nosaukums }}</option>
          @endforeach
        </select>

        <select data-avots="jaunumi"
                class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400 hidden">
          <option value="">— izvēlies jaunumu —</option>
          @foreach($jaunumi as $x)
            <option value="{{ $x->id }}">{{ $x->id }} — {{ $x->virsraksts }}</option>
          @endforeach
        </select>

        <select data-avots="lapas"
                class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400 hidden">
          <option value="">— izvēlies lapu —</option>
          @foreach($lapas as $x)
            <option value="{{ $x->id }}">{{ $x->id }} — {{ $x->virsraksts }} ({{ $x->slug }})</option>
          @endforeach
        </select>

        @error('avots_id')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
      </div>
    </div>
  </div>

  {{-- TARGET --}}
  <div class="rounded-xl border border-zinc-200 bg-zinc-50 p-4 space-y-3">
    <div class="font-medium">Mērķis</div>

    <div class="grid md:grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium" for="merkis_tips">Mērķis tips</label>
        <select id="merkis_tips" name="merkis_tips"
                class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
          @foreach(['pasakumi','projekti','jaunumi','lapas'] as $t)
            <option value="{{ $t }}" @selected(old('merkis_tips', 'pasakumi') === $t)>{{ $t }}</option>
          @endforeach
        </select>
      </div>

      <div>
        <label class="block text-sm font-medium" for="merkis_id">Mērķis ieraksts</label>

        <input type="hidden" id="merkis_id" name="merkis_id" value="{{ old('merkis_id') }}">

        <select data-merkis="pasakumi"
                class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
          <option value="">— izvēlies pasākumu —</option>
          @foreach($pasakumi as $x)
            <option value="{{ $x->id }}">{{ $x->id }} — {{ $x->nosaukums }}</option>
          @endforeach
        </select>

        <select data-merkis="projekti"
                class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400 hidden">
          <option value="">— izvēlies projektu —</option>
          @foreach($projekti as $x)
            <option value="{{ $x->id }}">{{ $x->id }} — {{ $x->nosaukums }}</option>
          @endforeach
        </select>

        <select data-merkis="jaunumi"
                class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400 hidden">
          <option value="">— izvēlies jaunumu —</option>
          @foreach($jaunumi as $x)
            <option value="{{ $x->id }}">{{ $x->id }} — {{ $x->virsraksts }}</option>
          @endforeach
        </select>

        <select data-merkis="lapas"
                class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400 hidden">
          <option value="">— izvēlies lapu —</option>
          @foreach($lapas as $x)
            <option value="{{ $x->id }}">{{ $x->id }} — {{ $x->virsraksts }} ({{ $x->slug }})</option>
          @endforeach
        </select>

        @error('merkis_id')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
      </div>
    </div>
  </div>

  <div class="flex gap-2">
    <button class="btn-primary" type="submit">Saglabāt</button>
    <a class="btn-secondary" href="{{ route('admin.saites.index') }}">Atpakaļ</a>
  </div>
</form>

<script>
  function setupLinkedSelect(kind) {
    const typeSelect = document.getElementById(kind + '_tips');
    const hiddenId   = document.getElementById(kind + '_id');
    const selects    = Array.from(document.querySelectorAll('select[data-' + kind + ']'));

    function showForType(type) {
      selects.forEach(s => {
        const match = s.getAttribute('data-' + kind) === type;
        s.classList.toggle('hidden', !match);
      });

      const active = selects.find(s => s.getAttribute('data-' + kind) === type);

      // restore previous value if any
      if (hiddenId.value) active.value = hiddenId.value;

      // set hidden id from active select
      hiddenId.value = active.value || '';
    }

    // when type changes, swap dropdown
    typeSelect.addEventListener('change', () => {
      hiddenId.value = '';
      showForType(typeSelect.value);
    });

    // when active dropdown changes, write into hidden id
    selects.forEach(s => {
      s.addEventListener('change', () => {
        if (s.classList.contains('hidden')) return;
        hiddenId.value = s.value || '';
      });
    });

    // initial
    showForType(typeSelect.value);
  }

  setupLinkedSelect('avots');
  setupLinkedSelect('merkis');
</script>
@endsection