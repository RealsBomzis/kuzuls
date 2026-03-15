

<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-semibold">Panelis</h1>

<div class="mt-6 grid md:grid-cols-3 gap-4">
<?php $__currentLoopData = $counts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="rounded-2xl bg-white border p-5">
        <div class="text-sm text-zinc-600"><?php echo e(str_replace('_',' ', $k)); ?></div>
        <div class="mt-1 text-3xl font-semibold text-yellow-600"><?php echo e($v); ?></div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\imnew\kuzuls-cms\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>