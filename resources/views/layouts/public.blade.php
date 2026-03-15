<!doctype html>
<html lang="lv" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} - @yield('title','Mājaslapa')</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="min-h-screen bg-zinc-50 text-zinc-900 antialiased">
<header class="sticky top-0 z-40 border-b border-zinc-200/80 bg-white/90 backdrop-blur">
    <nav class="mx-auto flex max-w-7xl items-center justify-between gap-6 px-4 py-4 sm:px-6 lg:px-8">
        <a href="{{ route('home') }}" class="flex items-center gap-3 font-semibold text-lg tracking-tight">
            <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-yellow-100 text-yellow-700 font-bold shadow-sm">
                K
            </span>
            <span>Biedrība <span class="text-yellow-500">Kūzuls</span></span>
        </a>

        <div class="hidden md:flex items-center gap-5">
            <a class="navlink" href="{{ route('public.pasakumi.index') }}">Pasākumi</a>
            <a class="navlink" href="{{ route('public.projekti.index') }}">Projekti</a>
            <a class="navlink" href="{{ route('public.jaunumi.index') }}">Jaunumi</a>
            <a class="navlink" href="{{ route('public.galerijas.index') }}">Galerijas</a>
            <a class="navlink" href="{{ route('public.page.show','par-biedribu') }}">Par biedrību</a>
            <a class="navlink" href="{{ route('public.page.show','darbibas-virziens') }}">Darbības virziens</a>
            <a class="navlink" href="{{ route('contact.create') }}">Kontakti</a>
            <a class="btn-primary btn-pill" href="{{ route('admin.dashboard') }}">Admin</a>
        </div>
    </nav>
</header>

<main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8 md:py-10">
    @if(session('status'))
        <div class="mb-6 rounded-2xl border border-yellow-200 bg-yellow-50 px-4 py-3 text-sm text-zinc-800 shadow-sm">
            {{ session('status') }}
        </div>
    @endif

    @yield('content')
</main>

<footer class="mt-16 border-t bg-white">
    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <div class="font-semibold text-zinc-900">Biedrība Kūzuls</div>
                <div class="mt-1 text-sm text-zinc-600">
                    Kopiena, pasākumi, projekti un iniciatīvas cilvēkiem un vietai.
                </div>
            </div>

            <div class="flex flex-wrap gap-4 text-sm text-zinc-600">
                <a class="hover:text-yellow-700 transition" href="{{ route('public.page.show','par-biedribu') }}">Par biedrību</a>
                <a class="hover:text-yellow-700 transition" href="{{ route('public.page.show','darbibas-virziens') }}">Darbības virziens</a>
                <a class="hover:text-yellow-700 transition" href="{{ route('public.pasakumi.index') }}">Pasākumi</a>
                <a class="hover:text-yellow-700 transition" href="{{ route('contact.create') }}">Kontakti</a>
            </div>
        </div>

        <div class="mt-6 text-sm text-zinc-500">
            © {{ date('Y') }} Biedrība Kūzuls
        </div>
    </div>
</footer>
</body>
</html>