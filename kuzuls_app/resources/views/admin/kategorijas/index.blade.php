@extends('layouts.admin')

@section('content')
<div class="flex items-center justify-between">
    <h1 class="text-2xl font-semibold">Kategorijas</h1>
    <a class="btn-primary" href="{{ route('admin.kategorijas.create') }}">+ Jauna</a>
</div>

<div class="mt-6 rounded-2xl bg-white border overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-zinc-50 text-zinc-600">
            <tr>
                <th class="text-left p-3">Nosaukums</th>
                <th class="text-left p-3">Tips</th>
                <th class="p-3"></th>
            </tr>
        </thead>
        <tbody>
        @foreach($kategorijas as $k)
            <tr class="border-t">
                <td class="p-3 font-medium">{{ $k->nosaukums }}</td>
                <td class="p-3">{{ $k->tips }}</td>
                <td class="p-3 text-right">
                    <a class="navlink" href="{{ route('admin.kategorijas.edit',$k) }}">Labot</a>
                    @can('delete',$k)
                    <form class="inline" method="post" action="{{ route('admin.kategorijas.destroy',$k) }}" onsubmit="return confirm('Dzēst?')">
                        @csrf @method('DELETE')
                        <button class="navlink text-red-600" type="submit">Dzēst</button>
                    </form>
                    @endcan
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<div class="mt-6">{{ $kategorijas->links() }}</div>
@endsection