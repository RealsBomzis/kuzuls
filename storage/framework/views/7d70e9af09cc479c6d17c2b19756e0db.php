
<?php $__env->startSection('title','Jaunumi'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-10">
    <section class="page-hero reveal-up">
        <div class="section-header">
            <div class="section-eyebrow">Jaunumi</div>
            <h1 class="section-title">Aktuālais par mūsu darbību un notikumiem</h1>
            <p class="section-text">
                Iepazīsti jaunākās ziņas, paziņojumus un stāstus par Biedrības Kūzuls aktivitātēm.
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
                <option value="newest" <?php if(request('sort','newest')==='newest'): echo 'selected'; endif; ?>>Jaunākie</option>
                <option value="oldest" <?php if(request('sort')==='oldest'): echo 'selected'; endif; ?>>Vecākie</option>
            </select>
        </div>

        <button class="btn-primary btn-pill" type="submit">Filtrēt</button>

        <?php if(request()->hasAny(['q','sort','kategorija_id'])): ?>
            <a class="btn-secondary btn-pill" href="<?php echo e(route('public.jaunumi.index')); ?>">Notīrīt</a>
        <?php endif; ?>
    </form>

    <?php if($jaunumi->count() === 0): ?>
        <div class="content-card text-zinc-600">Nav atrastu jaunumu.</div>
    <?php else: ?>
        <div class="grid gap-5 lg:grid-cols-3">
            <?php $__currentLoopData = $jaunumi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $j): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a class="reveal-up home-card group <?php echo e($index === 0 ? 'lg:col-span-2' : ''); ?>"
                   style="transition-delay: <?php echo e($index * 70); ?>ms;"
                   href="<?php echo e(route('public.jaunumi.show',$j)); ?>">
                    <div class="text-sm text-zinc-500">
                        <?php echo e($j->publicesanas_datums?->format('d.m.Y') ?? '—'); ?>

                    </div>
                    <div class="mt-3 text-xl font-semibold text-zinc-950 group-hover:text-yellow-800">
                        <?php echo e($j->virsraksts); ?>

                    </div>
                    <?php if($j->ievads): ?>
                        <div class="mt-3 text-sm leading-7 text-zinc-600 line-clamp-4"><?php echo e($j->ievads); ?></div>
                    <?php else: ?>
                        <div class="mt-3 text-sm leading-7 text-zinc-600 line-clamp-4">
                            <?php echo e(\Illuminate\Support\Str::limit(strip_tags($j->saturs), 220)); ?>

                        </div>
                    <?php endif; ?>
                    <div class="mt-5 text-sm font-medium text-yellow-700">Lasīt vairāk →</div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="mt-6">
            <?php echo e($jaunumi->links()); ?>

        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\imnew\kuzuls-cms\resources\views/public/jaunumi/index.blade.php ENDPATH**/ ?>