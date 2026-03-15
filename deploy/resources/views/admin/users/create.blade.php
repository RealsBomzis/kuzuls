@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-semibold">Jauns lietotājs</h1>

<form class="mt-6 rounded-2xl bg-white border p-6 space-y-4" method="post" action="{{ route('admin.users.store') }}">
    @csrf
    @include('admin.users.partials.form', ['user' => null])
    <div class="flex gap-2">
        <button class="btn-primary" type="submit">Saglabāt</button>
        <a class="btn-secondary" href="{{ route('admin.users.index') }}">Atcelt</a>
    </div>
</form>
@endsection