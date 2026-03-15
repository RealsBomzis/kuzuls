@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-semibold">Panelis</h1>

<div class="mt-6 grid md:grid-cols-3 gap-4">
@foreach($counts as $k=>$v)
    <div class="rounded-2xl bg-white border p-5">
        <div class="text-sm text-zinc-600">{{ str_replace('_',' ', $k) }}</div>
        <div class="mt-1 text-3xl font-semibold text-yellow-600">{{ $v }}</div>
    </div>
@endforeach
</div>
@endsection