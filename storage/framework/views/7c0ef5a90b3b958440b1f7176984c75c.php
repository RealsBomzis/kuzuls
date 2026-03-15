

<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-semibold">Labot projektu</h1>

<form class="mt-6 rounded-2xl bg-white border p-6 space-y-4" method="post" action="<?php echo e(route('admin.projekti.update',$projekts)); ?>">
    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
    <?php echo $__env->make('admin.projekti.partials.form', ['projekts' => $projekts], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <div class="flex gap-2">
        <button class="btn-primary" type="submit">Saglabāt</button>
        <a class="btn-secondary" href="<?php echo e(route('admin.projekti.index')); ?>">Atpakaļ</a>
    </div>
</form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\imnew\kuzuls-cms\resources\views/admin/projekti/edit.blade.php ENDPATH**/ ?>