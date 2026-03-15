<!doctype html>
<html lang="lv">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="min-h-screen bg-zinc-50 text-zinc-900">
<header class="border-b bg-white">
    <div class="mx-auto max-w-7xl px-4 py-4 flex items-center justify-between">
        <a href="{{ route('admin.dashboard') }}" class="font-semibold">
            Admin <span class="text-yellow-500">Kūzuls</span>
        </a>
        <div class="flex items-center gap-3">
            <a class="navlink" href="{{ route('home') }}">Publiski</a>
            <form method="post" action="{{ route('logout') }}">
                @csrf
                <button class="btn-primary" type="submit">Iziet</button>
            </form>
        </div>
    </div>
</header>

<div class="mx-auto max-w-7xl px-4 py-6 grid md:grid-cols-[240px_1fr] gap-6">
    <aside class="rounded-2xl bg-white border p-4">
        <nav class="space-y-2 text-sm">
            <a class="block navlink" href="{{ route('admin.pasakumi.index') }}">Pasākumi</a>
            <a class="block navlink" href="{{ route('admin.projekti.index') }}">Projekti</a>
            <a class="block navlink" href="{{ route('admin.jaunumi.index') }}">Jaunumi</a>
            <a class="block navlink" href="{{ route('admin.galerijas.index') }}">Galerijas</a>
            <a class="block navlink" href="{{ route('admin.lapas.index') }}">Lapas</a>
            <a class="block navlink" href="{{ route('admin.kategorijas.index') }}">Kategorijas</a>
            <a class="block navlink" href="{{ route('admin.kontakt.index') }}">Kontaktziņojumi</a>
            <a class="block navlink" href="{{ route('admin.saites.index') }}">Satura saites</a>
            <a class="block navlink" href="{{ route('admin.audit.index') }}">Audit logs</a>
            @can('viewAny', \App\Models\User::class)
                <a class="block navlink" href="{{ route('admin.users.index') }}">Lietotāji</a>
            @endcan
        </nav>
    </aside>

    <main>
        @if(session('status'))
            <div class="mb-6 rounded-lg border border-yellow-200 bg-yellow-50 px-4 py-3 text-sm">
                {{ session('status') }}
            </div>
        @endif
        @yield('content')
    </main>
</div>
</body>
</html>