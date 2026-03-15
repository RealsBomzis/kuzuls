
<?php $__env->startSection('title', $jaunums->virsraksts); ?>

<?php $__env->startSection('content'); ?>
<?php
    use Illuminate\Support\Facades\Storage;
?>

<div class="space-y-8">
    <article class="content-card reveal-up">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <div class="section-eyebrow">Jaunums</div>
                <h1 class="mt-2 text-3xl font-semibold tracking-tight"><?php echo e($jaunums->virsraksts); ?></h1>
                <div class="mt-3 text-sm text-zinc-600">
                    <?php echo e($jaunums->publicesanas_datums?->format('d.m.Y') ?? '—'); ?>

                </div>

                <?php if($jaunums->ievads): ?>
                    <p class="mt-4 text-zinc-700 leading-7"><?php echo e($jaunums->ievads); ?></p>
                <?php endif; ?>
            </div>

            <a class="btn-secondary btn-pill" href="<?php echo e(route('public.jaunumi.index')); ?>">← Atpakaļ</a>
        </div>

        <div class="prose max-w-none mt-6">
            <?php echo nl2br(e($jaunums->saturs)); ?>

        </div>

        <div class="mt-8">
            <?php echo $__env->make('public.partials.related-links', ['sourceType' => 'jaunumi', 'sourceId' => $jaunums->id], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    </article>

    <?php if(isset($galerija) && $galerija && $galerija->atteli->count()): ?>
        <section class="content-card reveal-up delay-1">
            <div class="flex items-center justify-between gap-3">
                <h2 class="text-xl font-semibold">Saistītā galerija</h2>
                <a href="<?php echo e(route('public.galerijas.show', $galerija)); ?>" class="text-yellow-700 text-sm hover:underline">
                    Skatīt visu galeriju →
                </a>
            </div>

            <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-3">
                <?php $__currentLoopData = $galerija->atteli->take(8); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $url = Storage::disk('public')->exists($a->fails_cels)
                            ? Storage::url($a->fails_cels)
                            : asset('storage/'.$a->fails_cels);
                    ?>

                    <a href="<?php echo e($url); ?>" target="_blank" rel="noopener"
                       class="block rounded-xl overflow-hidden border hover:border-yellow-300">
                        <img src="<?php echo e($url); ?>"
                             alt="<?php echo e($a->alt_teksts ?? $galerija->nosaukums); ?>"
                             class="h-32 w-full object-cover">
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </section>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\imnew\kuzuls-cms\resources\views/public/jaunumi/show.blade.php ENDPATH**/ ?>