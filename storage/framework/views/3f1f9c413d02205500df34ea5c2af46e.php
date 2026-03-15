
<?php $__env->startSection('title', $lapa->virsraksts); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-5xl mx-auto space-y-8">
    <section class="page-hero reveal-up">
        <div class="section-header">
            <div class="section-eyebrow">Informācija</div>
            <h1 class="section-title"><?php echo e($lapa->virsraksts); ?></h1>
            <p class="section-text">
                Iepazīsti Biedrības Kūzuls darbību, vērtības un galvenos virzienus.
            </p>
        </div>
    </section>

    <article class="content-card reveal-up delay-1">
        <div class="prose max-w-none">
            <?php echo nl2br(e($lapa->saturs)); ?>

        </div>

        <div class="mt-8">
            <?php echo $__env->make('public.partials.related-links', ['sourceType' => 'lapas', 'sourceId' => $lapa->id], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    </article>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\imnew\kuzuls-cms\resources\views/public/pages/show.blade.php ENDPATH**/ ?>