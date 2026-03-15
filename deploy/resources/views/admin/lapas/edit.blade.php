@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-semibold">Labot lapu</h1>

<form class="mt-6 rounded-2xl bg-white border p-6 space-y-4" method="post" action="{{ route('admin.lapas.update',$lapa) }}">
    @csrf @method('PUT')
    @include('admin.lapas.partials.form', ['lapa' => $lapa])
    <div class="flex gap-2">
        <button class="btn-primary" type="submit">Saglabāt</button>
        <a class="btn-secondary" href="{{ route('admin.lapas.index') }}">Atpakaļ</a>
    </div>
</form>
@endsection