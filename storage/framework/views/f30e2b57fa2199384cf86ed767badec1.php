
<?php $__env->startSection('title','Pasākumi'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-10">
    <section class="page-hero reveal-up">
        <div class="section-header">
            <div class="section-eyebrow">Pasākumi</div>
            <h1 class="section-title">Aktivitātes un notikumi, kuros vari iesaistīties</h1>
            <p class="section-text">
                Apskati tuvākos un aktuālākos pasākumus, kas notiek Biedrības Kūzuls darbības ietvaros.
            </p>
        </div>
    </section>

    <form class="reveal-up delay-1 rounded-[1.5rem] bg-white border p-4 flex flex-wrap gap-3 items-end shadow-sm" method="get">
        <div class="flex-1 min-w-[240px]">
            <label class="block text-sm font-medium">Meklēt</label>
            <input name="q" value="<?php echo e(request('q')); ?>"
                   class="mt-1 w-full rounded-xl border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400" />
        </div>
        <div>
            <label class="block text-sm font-medium">Kārtot</label>
            <select name="sort" class="mt-1 rounded-xl border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
                <option value="date_asc" <?php if(request('sort','date_asc')==='date_asc'): echo 'selected'; endif; ?>>Datums ↑</option>
                <option value="date_desc" <?php if(request('sort')==='date_desc'): echo 'selected'; endif; ?>>Datums ↓</option>
            </select>
        </div>
        <button class="btn-primary btn-pill" type="submit">Filtrēt</button>
    </form>

    <?php if($pasakumi->count()): ?>
        <div class="page-grid">
            <?php $__currentLoopData = $pasakumi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a class="reveal-up home-card group"
                   style="transition-delay: <?php echo e($index * 70); ?>ms;"
                   href="<?php echo e(route('public.pasakumi.show',$p)); ?>">
                    <div class="text-sm text-zinc-500">
                        <?php echo e($p->norises_datums?->format('d.m.Y')); ?> · <?php echo e($p->vieta); ?>

                    </div>
                    <div class="mt-3 text-xl font-semibold text-zinc-950 group-hover:text-yellow-800">
                        <?php echo e($p->nosaukums); ?>

                    </div>
                    <?php if($p->apraksts): ?>
                        <div class="mt-3 text-sm leading-7 text-zinc-600 line-clamp-4"><?php echo e($p->apraksts); ?></div>
                    <?php endif; ?>
                    <div class="mt-5 text-sm font-medium text-yellow-700">Skatīt pasākumu →</div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="mt-6">
            <?php echo e($pasakumi->links()); ?>

        </div>
    <?php else: ?>
        <div class="content-card text-zinc-600">Nav atrastu pasākumu.</div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\imnew\kuzuls-cms\resources\views/public/pasakumi/index.blade.php ENDPATH**/ ?>