
<?php $__env->startSection('title',$pasakums->nosaukums); ?>

<?php $__env->startSection('content'); ?>
<?php
    use Illuminate\Support\Facades\Storage;

    $pasakumaImg = null;
    if (!empty($pasakums->attels)) {
        $pasakumaImg = Storage::disk('public')->exists($pasakums->attels)
            ? Storage::url($pasakums->attels)
            : asset('storage/'.$pasakums->attels);
    }
?>

<article class="rounded-2xl bg-white border p-6">
    <h1 class="text-2xl font-semibold"><?php echo e($pasakums->nosaukums); ?></h1>

    <div class="mt-2 text-sm text-zinc-600">
        <?php echo e($pasakums->norises_datums?->format('d.m.Y')); ?>

        · <?php echo e($pasakums->sakuma_laiks); ?><?php if($pasakums->beigu_laiks): ?>–<?php echo e($pasakums->beigu_laiks); ?><?php endif; ?>
        · <?php echo e($pasakums->vieta); ?>

    </div>

    <?php if($pasakumaImg): ?>
        <div class="mt-5">
            <img src="<?php echo e($pasakumaImg); ?>"
                 alt="<?php echo e($pasakums->nosaukums); ?>"
                 class="w-full max-h-[420px] object-cover rounded-2xl border">
        </div>
    <?php endif; ?>

    <?php if($pasakums->apraksts): ?>
        <div class="prose max-w-none mt-4"><?php echo nl2br(e($pasakums->apraksts)); ?></div>
    <?php endif; ?>
</article>

<?php if($galerija && $galerija->atteli->count()): ?>
    <section class="mt-8 rounded-2xl bg-white border p-6">
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
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\imnew\kuzuls-cms\resources\views/public/pasakumi/show.blade.php ENDPATH**/ ?>