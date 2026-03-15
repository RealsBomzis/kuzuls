

<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-semibold">Labot pasākumu</h1>

<?php if(session('status')): ?>
  <div class="mt-4 rounded-xl border border-green-200 bg-green-50 p-4 text-green-800">
    <?php echo e(session('status')); ?>

  </div>
<?php endif; ?>

<?php if($errors->any()): ?>
  <div class="mt-4 rounded-xl border border-red-200 bg-red-50 p-4 text-red-800">
    <div class="font-semibold mb-2">Kļūdas:</div>
    <ul class="list-disc pl-5">
      <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li><?php echo e($error); ?></li>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
  </div>
<?php endif; ?>

<form class="mt-6 rounded-2xl bg-white border p-6 space-y-4"
    method="POST"
    action="<?php echo e(route('admin.pasakumi.update', $pasakums)); ?>"
    enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

    
    <?php echo $__env->make('admin.pasakumi.partials.form', ['pasakums' => $pasakums, 'kategorijas' => $kategorijas], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="flex gap-2">
      <button class="btn-primary" type="submit">Saglabāt</button>
      <a class="btn-secondary" href="<?php echo e(route('admin.pasakumi.index')); ?>">Atpakaļ</a>
    </div>
</form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\imnew\kuzuls-cms\resources\views/admin/pasakumi/edit.blade.php ENDPATH**/ ?>