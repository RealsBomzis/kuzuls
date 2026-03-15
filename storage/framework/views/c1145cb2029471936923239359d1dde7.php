<!doctype html>
<html lang="lv">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - <?php echo e(config('app.name')); ?></title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css','resources/js/app.js']); ?>
</head>
<body class="min-h-screen bg-zinc-50 text-zinc-900">
<header class="border-b bg-white">
    <div class="mx-auto max-w-7xl px-4 py-4 flex items-center justify-between">
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="font-semibold">
            Admin <span class="text-yellow-500">Kūzuls</span>
        </a>
        <div class="flex items-center gap-3">
            <a class="navlink" href="<?php echo e(route('home')); ?>">Publiski</a>
            <form method="post" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button class="btn-primary" type="submit">Iziet</button>
            </form>
        </div>
    </div>
</header>

<div class="mx-auto max-w-7xl px-4 py-6 grid md:grid-cols-[240px_1fr] gap-6">
    <aside class="rounded-2xl bg-white border p-4">
        <nav class="space-y-2 text-sm">
            <a class="block navlink" href="<?php echo e(route('admin.pasakumi.index')); ?>">Pasākumi</a>
            <a class="block navlink" href="<?php echo e(route('admin.projekti.index')); ?>">Projekti</a>
            <a class="block navlink" href="<?php echo e(route('admin.jaunumi.index')); ?>">Jaunumi</a>
            <a class="block navlink" href="<?php echo e(route('admin.galerijas.index')); ?>">Galerijas</a>
            <a class="block navlink" href="<?php echo e(route('admin.lapas.index')); ?>">Lapas</a>
            <a class="block navlink" href="<?php echo e(route('admin.kategorijas.index')); ?>">Kategorijas</a>
            <a class="block navlink" href="<?php echo e(route('admin.kontakt.index')); ?>">Kontaktziņojumi</a>
            <a class="block navlink" href="<?php echo e(route('admin.saites.index')); ?>">Satura saites</a>
            <a class="block navlink" href="<?php echo e(route('admin.audit.index')); ?>">Audit logs</a>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('viewAny', \App\Models\User::class)): ?>
                <a class="block navlink" href="<?php echo e(route('admin.users.index')); ?>">Lietotāji</a>
            <?php endif; ?>
        </nav>
    </aside>

    <main>
        <?php if(session('status')): ?>
            <div class="mb-6 rounded-lg border border-yellow-200 bg-yellow-50 px-4 py-3 text-sm">
                <?php echo e(session('status')); ?>

            </div>
        <?php endif; ?>
        <?php echo $__env->yieldContent('content'); ?>
    </main>
</div>
</body>
</html><?php /**PATH C:\Users\imnew\kuzuls-cms\resources\views/layouts/admin.blade.php ENDPATH**/ ?>