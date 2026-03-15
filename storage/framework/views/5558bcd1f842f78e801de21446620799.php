
<?php $__env->startSection('title','Galerijas'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-10">
    <section class="page-hero reveal-up">
        <div class="section-header">
            <div class="section-eyebrow">Galerijas</div>
            <h1 class="section-title">Momenti, notikumi un ieskats mūsu aktivitātēs</h1>
            <p class="section-text">
                Foto galerijas, kas atspoguļo mūsu pasākumus, projektus un kopienas dzīvi.
            </p>
        </div>
    </section>

    <form class="reveal-up delay-1 rounded-[1.5rem] bg-white border p-4 flex flex-wrap gap-3 items-end shadow-sm" method="get">
        <div class="flex-1 min-w-[240px]">
            <label class="block text-sm font-medium" for="q">Meklēt</label>
            <input id="q" name="q" value="<?php echo e(request('q')); ?>"
                   class="mt-1 w-full rounded-xl border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400" />
        </div>

        <div>
            <label class="block text-sm font-medium" for="sort">Kārtot</label>
            <select id="sort" name="sort"
                    class="mt-1 rounded-xl border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
                <option value="newest" <?php echo e(request('sort','newest') === 'newest' ? 'selected' : ''); ?>>Jaunākās</option>
                <option value="oldest" <?php echo e(request('sort') === 'oldest' ? 'selected' : ''); ?>>Vecākās</option>
            </select>
        </div>

        <button class="btn-primary btn-pill" type="submit">Filtrēt</button>

        <?php if(request()->hasAny(['q','sort','kategorija_id'])): ?>
            <a class="btn-secondary btn-pill" href="<?php echo e(route('public.galerijas.index')); ?>">Notīrīt</a>
        <?php endif; ?>
    </form>

    <?php if($galerijas->count() === 0): ?>
        <div class="content-card text-zinc-600">
            Nav atrastu galeriju.
        </div>
    <?php else: ?>
        <div class="page-grid">
            <?php $__currentLoopData = $galerijas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a class="reveal-up home-card group"
                   style="transition-delay: <?php echo e($index * 70); ?>ms;"
                   href="<?php echo e(route('public.galerijas.show',$g)); ?>">
                    <div class="flex items-center justify-between gap-2">
                        <div class="text-xl font-semibold text-zinc-950 group-hover:text-yellow-800">
                            <?php echo e($g->nosaukums); ?>

                        </div>
                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs bg-yellow-50 border border-yellow-200 text-yellow-800">
                            <?php echo e($g->atteli_count); ?> att.
                        </span>
                    </div>

                    <?php if($g->apraksts): ?>
                        <div class="mt-3 text-sm leading-7 text-zinc-600 line-clamp-4">
                            <?php echo e($g->apraksts); ?>

                        </div>
                    <?php endif; ?>

                    <div class="mt-5 text-sm font-medium text-yellow-700">Skatīt galeriju →</div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="mt-6">
            <?php echo e($galerijas->links()); ?>

        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\imnew\kuzuls-cms\resources\views/public/galerijas/index.blade.php ENDPATH**/ ?>