
<?php $__env->startSection('title', $galerija->nosaukums); ?>

<?php $__env->startSection('content'); ?>
<?php
    use Illuminate\Support\Facades\Storage;
?>

<div class="space-y-8">
    <article class="content-card reveal-up">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <div class="section-eyebrow">Galerija</div>
                <h1 class="mt-2 text-3xl font-semibold tracking-tight"><?php echo e($galerija->nosaukums); ?></h1>
                <?php if($galerija->apraksts): ?>
                    <p class="mt-4 text-zinc-700 leading-7"><?php echo e($galerija->apraksts); ?></p>
                <?php endif; ?>
            </div>

            <a class="btn-secondary btn-pill" href="<?php echo e(route('public.galerijas.index')); ?>">← Atpakaļ</a>
        </div>
    </article>

    <?php if($galerija->atteli->count() === 0): ?>
        <div class="content-card text-zinc-600">
            Šajā galerijā vēl nav attēlu.
        </div>
    <?php else: ?>
        <div class="reveal-up delay-1 grid sm:grid-cols-2 md:grid-cols-3 gap-4">
            <?php $__currentLoopData = $galerija->atteli; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $url = Storage::disk('public')->exists($a->fails_cels)
                        ? Storage::url($a->fails_cels)
                        : asset('storage/'.$a->fails_cels);
                ?>

                <a href="<?php echo e($url); ?>" target="_blank" rel="noopener"
                   class="group block overflow-hidden rounded-[1.5rem] border bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    <img src="<?php echo e($url); ?>"
                         alt="<?php echo e($a->alt_teksts ?? $galerija->nosaukums); ?>"
                         class="h-52 w-full object-cover transition-transform duration-300 group-hover:scale-[1.03]" />
                    <?php if($a->alt_teksts): ?>
                        <div class="p-4 text-sm text-zinc-700"><?php echo e($a->alt_teksts); ?></div>
                    <?php endif; ?>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>

    <div class="content-card">
        <?php echo $__env->make('public.partials.related-links', ['sourceType' => 'galerijas', 'sourceId' => $galerija->id], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\imnew\kuzuls-cms\resources\views/public/galerijas/show.blade.php ENDPATH**/ ?>