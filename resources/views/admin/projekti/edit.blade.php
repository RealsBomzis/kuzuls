@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-semibold">Labot projektu</h1>

<form class="mt-6 rounded-2xl bg-white border p-6 space-y-4" method="post" action="{{ route('admin.projekti.update',$projekts) }}">
    @csrf @method('PUT')
    @include('admin.projekti.partials.form', ['projekts' => $projekts])
    <div class="flex gap-2">
        <button class="btn-primary" type="submit">Saglabāt</button>
        <a class="btn-secondary" href="{{ route('admin.projekti.index') }}">Atpakaļ</a>
    </div>
</form>
@endsection