@extends('layouts.admin')

@section('content')
<div class="flex items-center justify-between">
    <h1 class="text-2xl font-semibold">Galerijas</h1>
    <div class="flex gap-2">
        <a class="btn-secondary" href="{{ route('admin.export.csv','galerijas') }}">CSV</a>
        <a class="btn-secondary" href="{{ route('admin.export.pdf','galerijas') }}">PDF</a>
        <a class="btn-primary" href="{{ route('admin.galerijas.create') }}">+ Jauna</a>
    </div>
</div>

<div class="mt-6 rounded-2xl bg-white border overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-zinc-50 text-zinc-600">
            <tr>
                <th class="text-left p-3">Nosaukums</th>
                <th class="text-left p-3">Attēli</th>
                <th class="text-left p-3">Publicēts</th>
                <th class="p-3"></th>
            </tr>
        </thead>
        <tbody>
        @foreach($galerijas as $g)
            <tr class="border-t">
                <td class="p-3 font-medium">{{ $g->nosaukums }}</td>
                <td class="p-3">{{ $g->atteli_count }}</td>
                <td class="p-3">
                    <span class="inline-flex items-center rounded-full px-2 py-1 text-xs {{ $g->publicets ? 'bg-yellow-100 text-yellow-800' : 'bg-zinc-100 text-zinc-700' }}">
                        {{ $g->publicets ? 'Jā' : 'Nē' }}
                    </span>
                </td>
                <td class="p-3 text-right">
                    <a class="navlink" href="{{ route('admin.galerijas.edit',$g) }}">Labot</a>
                    <form class="inline" method="post" action="{{ route('admin.galerijas.destroy',$g) }}" onsubmit="return confirm('Dzēst?')">
                        @csrf @method('DELETE')
                        <button class="navlink text-red-600" type="submit">Dzēst</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<div class="mt-6">{{ $galerijas->links() }}</div>
@endsection