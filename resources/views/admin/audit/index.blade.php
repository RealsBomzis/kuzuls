@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-semibold">Audit logs</h1>

<div class="mt-6 rounded-2xl bg-white border overflow-hidden">
<table class="w-full text-sm">
    <thead class="bg-zinc-50 text-zinc-600">
        <tr>
            <th class="text-left p-3">Laiks</th>
            <th class="text-left p-3">User</th>
            <th class="text-left p-3">Darbība</th>
            <th class="text-left p-3">Objekts</th>
            <th class="text-left p-3">IP</th>
        </tr>
    </thead>
    <tbody>
@foreach($logs as $l)
<tr class="border-t">
    <td class="p-3">{{ optional($l->created_at)->format('d.m.Y H:i') }}</td>

    <td class="p-3">
        @if($l->user)
            <div class="font-medium">{{ $l->user->name }}</div>
            <div class="text-xs text-zinc-500">{{ $l->user->email }}</div>
        @else
            <span class="text-zinc-500">—</span>
        @endif
    </td>

    <td class="p-3">{{ $l->darbiba }}</td>
    <td class="p-3">{{ $l->objekta_tips }} #{{ $l->objekta_id }}</td>
    <td class="p-3">{{ $l->ip_adrese }}</td>
</tr>
@endforeach
    </tbody>
</table>
</div>

<div class="mt-6">{{ $logs->links() }}</div>
@endsection