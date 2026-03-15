<!doctype html>
<html lang="lv">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} - @yield('title','Mājaslapa')</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="min-h-screen bg-zinc-50 text-zinc-900">
<header class="border-b bg-white">
    <nav class="mx-auto max-w-6xl px-4 py-4 flex items-center justify-between">
        <a href="{{ route('home') }}" class="font-semibold text-lg">
            <span class="text-yellow-500">Kūzuls</span>
        </a>
        <div class="flex gap-4 items-center">
            <a class="navlink" href="{{ route('public.pasakumi.index') }}">Pasākumi</a>
            <a class="navlink" href="{{ route('public.projekti.index') }}">Projekti</a>
            <a class="navlink" href="{{ route('public.jaunumi.index') }}">Jaunumi</a>
            <a class="navlink" href="{{ route('public.galerijas.index') }}">Galerijas</a>
            <a class="navlink" href="{{ route('contact.create') }}">Kontakti</a>
            <a class="btn-primary" href="{{ route('admin.dashboard') }}">Admin</a>
        </div>
    </nav>
</header>

<main class="mx-auto max-w-6xl px-4 py-8">
    @if(session('status'))
        <div class="mb-6 rounded-lg border border-yellow-200 bg-yellow-50 px-4 py-3 text-sm">
            {{ session('status') }}
        </div>
    @endif
    @yield('content')
</main>

<footer class="border-t bg-white">
    <div class="mx-auto max-w-6xl px-4 py-6 text-sm text-zinc-600">
        © {{ date('Y') }} Kūzuls
    </div>
</footer>
</body>
</html>