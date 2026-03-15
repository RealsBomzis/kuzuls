@extends('layouts.admin')

@section('content')
<div class="flex flex-wrap items-center justify-between gap-3">
    <h1 class="text-2xl font-semibold">Satura saites</h1>

    <div class="flex gap-2">
        <a class="btn-primary" href="{{ route('admin.saites.create') }}">+ Manuālā saite</a>

        <form method="post" action="{{ route('admin.saites.generate') }}">
            @csrf
            <input type="hidden" name="max_per_source" value="5">
            <input type="hidden" name="limit_sources" value="200">
            <button class="btn-secondary" type="submit">Ģenerēt ieteikumus</button>
        </form>
    </div>
</div>

{{-- Filters --}}
<form class="mt-6 rounded-2xl bg-white border p-4 flex flex-wrap gap-3 items-end" method="get">
    <div class="min-w-[220px] flex-1">
        <label class="block text-sm font-medium">Meklēt</label>
        <input name="q" value="{{ request('q') }}"
               class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400"
               placeholder="piem: pasakumi, 12, projekti">
    </div>

    <div>
        <label class="block text-sm font-medium">Statuss</label>
        <select name="status" class="mt-1 rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
            <option value="">Visi</option>
            <option value="pending" @selected(request('status')==='pending')>pending</option>
            <option value="approved" @selected(request('status')==='approved')>approved</option>
            <option value="rejected" @selected(request('status')==='rejected')>rejected</option>
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium">Tips</label>
        <select name="tips" class="mt-1 rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
            <option value="">Visi</option>
            <option value="automatiskas" @selected(request('tips')==='automatiskas')>automatiskas</option>
            <option value="manualas" @selected(request('tips')==='manualas')>manualas</option>
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium">Avots tips</label>
        <select name="avots_tips" class="mt-1 rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
            <option value="">Visi</option>
            @foreach(['pasakumi','projekti','jaunumi','lapas'] as $t)
                <option value="{{ $t }}" @selected(request('avots_tips')===$t)>{{ $t }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium">Mērķis tips</label>
        <select name="merkis_tips" class="mt-1 rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
            <option value="">Visi</option>
            @foreach(['pasakumi','projekti','jaunumi','lapas'] as $t)
                <option value="{{ $t }}" @selected(request('merkis_tips')===$t)>{{ $t }}</option>
            @endforeach
        </select>
    </div>

    <button class="btn-primary" type="submit">Filtrēt</button>

    @if(request()->hasAny(['q','status','tips','avots_tips','merkis_tips']))
        <a class="btn-secondary" href="{{ route('admin.saites.index') }}">Notīrīt</a>
    @endif
</form>

{{-- Bulk actions + TABLE inside the same form --}}
<form id="bulkForm" class="mt-6" method="post" action="{{ route('admin.saites.bulk') }}">
    @csrf

    <div class="rounded-2xl bg-white border p-4 flex flex-wrap items-center gap-3">
        <input type="hidden" name="apply_to_filtered" id="apply_to_filtered" value="0">

        {{-- Pass current filters so "apply to filtered" works --}}
        <input type="hidden" name="filters[status]" value="{{ request('status') }}">
        <input type="hidden" name="filters[tips]" value="{{ request('tips') }}">
        <input type="hidden" name="filters[avots_tips]" value="{{ request('avots_tips') }}">
        <input type="hidden" name="filters[merkis_tips]" value="{{ request('merkis_tips') }}">
        <input type="hidden" name="filters[q]" value="{{ request('q') }}">

        <div class="flex items-center gap-2">
            <input id="select_all_page" type="checkbox" class="rounded border-zinc-300 text-yellow-500 focus:ring-yellow-400">
            <label for="select_all_page" class="text-sm">Select all on page</label>
        </div>

        <button type="button" id="select_all_filtered" class="btn-secondary">
            Select all matching filters
        </button>

        <div class="h-6 w-px bg-zinc-200"></div>

        <select name="action" class="rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
            <option value="approve">Approve</option>
            <option value="reject">Reject</option>
            <option value="delete">Delete</option>
        </select>

        <button class="btn-primary" type="submit" onclick="return confirmBulkAction();">
            Apply
        </button>

        <span class="text-sm text-zinc-500" id="selected_count">0 selected</span>
    </div>

    <div class="mt-6 rounded-2xl bg-white border overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-zinc-50 text-zinc-600">
                <tr>
                    <th class="p-3 w-10"></th>
                    <th class="text-left p-3">Avots</th>
                    <th class="text-left p-3">Mērķis</th>
                    <th class="text-left p-3">Tips</th>
                    <th class="text-left p-3">Punkti</th>
                    <th class="text-left p-3">Statuss</th>
                    <th class="p-3 text-right">Rīcības</th>
                </tr>
            </thead>

            <tbody>
            @foreach($saites as $s)
                @php
                    $avKey = $s->avots_tips . ':' . $s->avots_id;
                    $mkKey = $s->merkis_tips . ':' . $s->merkis_id;

                    $avTitle = $avotsTitles[$avKey] ?? null;
                    $mkTitle = $merkisTitles[$mkKey] ?? null;

                    $publicUrl = match ($s->merkis_tips) {
                        'pasakumi' => route('public.pasakumi.show', $s->merkis_id),
                        'projekti' => route('public.projekti.show', $s->merkis_id),
                        'jaunumi'  => route('public.jaunumi.show', $s->merkis_id),
                        'lapas'    => isset($lapaSlugs[$s->merkis_id]) ? route('public.page.show', $lapaSlugs[$s->merkis_id]) : null,
                        default    => null,
                    };

                    $statusVal = ($s->review_status instanceof \BackedEnum) ? $s->review_status->value : $s->review_status;
                @endphp

                <tr class="border-t">
                    <td class="p-3 align-top">
                        <input type="checkbox"
                               class="row_cb rounded border-zinc-300 text-yellow-500 focus:ring-yellow-400"
                               name="ids[]"
                               value="{{ $s->id }}">
                    </td>

                    <td class="p-3 align-top">
                        <div class="font-medium">{{ $s->avots_tips }} #{{ $s->avots_id }}</div>
                        <div class="text-xs text-zinc-500">{{ $avTitle ?? '—' }}</div>
                    </td>

                    <td class="p-3 align-top">
                        <div class="font-medium flex items-center gap-2">
                            <span>{{ $s->merkis_tips }} #{{ $s->merkis_id }}</span>
                            @if($publicUrl)
                                <a class="text-xs text-yellow-700 hover:underline" href="{{ $publicUrl }}" target="_blank" rel="noopener">
                                    Atvērt
                                </a>
                            @endif
                        </div>
                        <div class="text-xs text-zinc-500">{{ $mkTitle ?? '—' }}</div>
                    </td>

                    <td class="p-3 align-top">{{ $s->tips }}</td>
                    <td class="p-3 align-top">{{ $s->atbilstibas_punkti }}</td>

                    <td class="p-3 align-top">
                        <span class="inline-flex rounded-full px-2 py-1 text-xs bg-yellow-50 border border-yellow-200">
                            {{ $statusVal }}
                        </span>
                    </td>

                    <td class="p-3 align-top text-right whitespace-nowrap">
                        @if($statusVal === 'pending')
                            <button type="button"
                                    class="btn-secondary"
                                    data-action-url="{{ route('admin.saites.approve', ['saite' => $s->id]) }}"
                                    data-action-method="PATCH"
                                    onclick="submitRowAction(this)">
                                Approve
                            </button>

                            <button type="button"
                                    class="btn-secondary"
                                    data-action-url="{{ route('admin.saites.reject', ['saite' => $s->id]) }}"
                                    data-action-method="PATCH"
                                    onclick="submitRowAction(this)">
                                Reject
                            </button>
                        @endif

                        <button type="button"
                                class="btn-secondary"
                                data-action-url="{{ route('admin.saites.destroy', ['saite' => $s->id]) }}"
                                data-action-method="DELETE"
                                data-confirm="1"
                                onclick="submitRowAction(this)">
                            Dzēst
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</form>

{{-- One hidden form for row actions (avoids nested forms) --}}
<form id="rowActionForm" method="post" style="display:none;">
    @csrf
    <input type="hidden" name="_method" id="rowActionMethod" value="POST">
</form>

<script>
  // ---- Row actions (approve/reject/delete) without nested forms ----
  function submitRowAction(btn) {
    const url = btn.dataset.actionUrl;
    const method = btn.dataset.actionMethod || 'POST';
    const confirmDelete = btn.dataset.confirm === '1';

    if (confirmDelete && !confirm('Dzēst?')) return;

    const f = document.getElementById('rowActionForm');
    document.getElementById('rowActionMethod').value = method;
    f.action = url;
    f.submit();
  }

  // ---- Bulk selection ----
  const selectAllPage = document.getElementById('select_all_page');
  const selectAllFilteredBtn = document.getElementById('select_all_filtered');
  const applyToFiltered = document.getElementById('apply_to_filtered');
  const countEl = document.getElementById('selected_count');
  const rowCbs = () => Array.from(document.querySelectorAll('.row_cb'));

  function updateCount() {
    const count = rowCbs().filter(cb => cb.checked).length;
    countEl.textContent = `${count} selected`;
  }

  selectAllPage?.addEventListener('change', () => {
    applyToFiltered.value = '0';
    rowCbs().forEach(cb => cb.checked = selectAllPage.checked);
    updateCount();
  });

  rowCbs().forEach(cb => cb.addEventListener('change', () => {
    applyToFiltered.value = '0';
    updateCount();
  }));

  selectAllFilteredBtn?.addEventListener('click', () => {
    applyToFiltered.value = '1';
    rowCbs().forEach(cb => cb.checked = true);
    selectAllPage.checked = true;
    updateCount();
    alert('Bulk action will be applied to ALL results matching the current filters (across all pages).');
  });

  function confirmBulkAction() {
    const action = document.querySelector('select[name="action"]')?.value;
    const allFiltered = applyToFiltered.value === '1';
    const count = rowCbs().filter(cb => cb.checked).length;

    if (allFiltered) {
      return confirm(`Apply "${action}" to ALL results matching current filters (across pages)?`);
    }
    if (count === 0) {
      alert('Select at least one item.');
      return false;
    }
    return confirm(`Apply "${action}" to ${count} selected item(s)?`);
  }

  updateCount();
</script>

<div class="mt-6">{{ $saites->links() }}</div>
@endsection