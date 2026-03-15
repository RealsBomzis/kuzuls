@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-semibold">Labot kategoriju</h1>

<form class="mt-6 rounded-2xl bg-white border p-6 space-y-4" method="post" action="{{ route('admin.kategorijas.update',$kategorija) }}">
    @csrf @method('PUT')
    @include('admin.kategorijas.partials.form', ['kategorija' => $kategorija])
    <div class="flex gap-2">
        <button class="btn-primary" type="submit">Saglabāt</button>
        <a class="btn-secondary" href="{{ route('admin.kategorijas.index') }}">Atpakaļ</a>
    </div>
</form>
@endsection