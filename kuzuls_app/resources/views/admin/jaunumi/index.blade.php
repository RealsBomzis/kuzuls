@extends('layouts.admin')

@section('content')
<div class="flex items-center justify-between">
    <h1 class="text-2xl font-semibold">Jaunumi</h1>
    <div class="flex gap-2">
        <a class="btn-secondary" href="{{ route('admin.export.csv','jaunumi') }}">CSV</a>
        <a class="btn-secondary" href="{{ route('admin.export.pdf','jaunumi') }}">PDF</a>
        <a class="btn-primary" href="{{ route('admin.jaunumi.create') }}">+ Jauns</a>
    </div>
</div>

<div class="mt-6 rounded-2xl bg-white border overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-zinc-50 text-zinc-600">
            <tr>
                <th class="text-left p-3">Virsraksts</th>
                <th class="text-left p-3">Publicēšanas datums</th>
                <th class="text-left p-3">Publicēts</th>
                <th class="p-3"></th>
            </tr>
        </thead>
        <tbody>
        @foreach($jaunumi as $j)
            <tr class="border-t">
                <td class="p-3 font-medium">{{ $j->virsraksts }}</td>
                <td class="p-3">{{ $j->publicesanas_datums?->format('d.m.Y') ?? '—' }}</td>
                <td class="p-3">
                    <span class="inline-flex items-center rounded-full px-2 py-1 text-xs {{ $j->publicets ? 'bg-yellow-100 text-yellow-800' : 'bg-zinc-100 text-zinc-700' }}">
                        {{ $j->publicets ? 'Jā' : 'Nē' }}
                    </span>
                </td>
                <td class="p-3 text-right">
                    <a class="navlink" href="{{ route('admin.jaunumi.edit',$j) }}">Labot</a>
                    <form class="inline" method="post" action="{{ route('admin.jaunumi.destroy',$j) }}" onsubmit="return confirm('Dzēst?')">
                        @csrf @method('DELETE')
                        <button class="navlink text-red-600" type="submit">Dzēst</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<div class="mt-6">{{ $jaunumi->links() }}</div>
@endsection