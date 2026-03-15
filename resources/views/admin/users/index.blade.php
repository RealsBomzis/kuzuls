@extends('layouts.admin')

@section('content')
<div class="flex items-center justify-between">
    <h1 class="text-2xl font-semibold">Lietotāji</h1>
    <a class="btn-primary" href="{{ route('admin.users.create') }}">+ Jauns</a>
</div>

<div class="mt-6 rounded-2xl bg-white border overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-zinc-50 text-zinc-600">
            <tr>
                <th class="text-left p-3">Vārds</th>
                <th class="text-left p-3">E-pasts</th>
                <th class="text-left p-3">Lomas</th>
                <th class="text-left p-3">Aktīvs</th>
                <th class="p-3"></th>
            </tr>
        </thead>
        <tbody>
        @foreach($users as $u)
            <tr class="border-t">
                <td class="p-3 font-medium">{{ $u->name }}</td>
                <td class="p-3">{{ $u->email }}</td>
                <td class="p-3">
                    @foreach($u->roles as $r)
                        <span class="inline-flex rounded-full px-2 py-1 text-xs bg-yellow-50 border border-yellow-200 text-yellow-800">{{ $r->nosaukums }}</span>
                    @endforeach
                </td>
                <td class="p-3">{{ $u->is_active ? 'Jā' : 'Nē' }}</td>
                <td class="p-3 text-right">
                    <a class="navlink" href="{{ route('admin.users.edit',$u) }}">Labot</a>
                    <form class="inline" method="post" action="{{ route('admin.users.destroy',$u) }}" onsubmit="return confirm('Dzēst?')">
                        @csrf @method('DELETE')
                        <button class="navlink text-red-600" type="submit">Dzēst</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<div class="mt-6">{{ $users->links() }}</div>
@endsection