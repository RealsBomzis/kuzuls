@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-semibold">Labot pasākumu</h1>

@if (session('status'))
  <div class="mt-4 rounded-xl border border-green-200 bg-green-50 p-4 text-green-800">
    {{ session('status') }}
  </div>
@endif

@if ($errors->any())
  <div class="mt-4 rounded-xl border border-red-200 bg-red-50 p-4 text-red-800">
    <div class="font-semibold mb-2">Kļūdas:</div>
    <ul class="list-disc pl-5">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

<form class="mt-6 rounded-2xl bg-white border p-6 space-y-4"
    method="POST"
    action="{{ route('admin.pasakumi.update', $pasakums) }}"
    enctype="multipart/form-data">
    @csrf
    @method('PUT')

    {{-- Keep using the shared form partial --}}
    @include('admin.pasakumi.partials.form', ['pasakums' => $pasakums, 'kategorijas' => $kategorijas])

    <div class="flex gap-2">
      <button class="btn-primary" type="submit">Saglabāt</button>
      <a class="btn-secondary" href="{{ route('admin.pasakumi.index') }}">Atpakaļ</a>
    </div>
</form>
@endsection