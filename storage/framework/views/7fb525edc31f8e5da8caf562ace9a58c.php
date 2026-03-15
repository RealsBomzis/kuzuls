

<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-semibold">Labot galeriju</h1>

<div class="grid lg:grid-cols-2 gap-6 mt-6">
    <form class="rounded-2xl bg-white border p-6 space-y-4" method="post" action="<?php echo e(route('admin.galerijas.update',$galerija)); ?>">
        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
        <?php echo $__env->make('admin.galerijas.partials.form', ['galerija' => $galerija], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <div class="flex gap-2">
            <button class="btn-primary" type="submit">Saglabāt</button>
            <a class="btn-secondary" href="<?php echo e(route('admin.galerijas.index')); ?>">Atpakaļ</a>
        </div>
    </form>

    <div class="rounded-2xl bg-white border p-6">
        <h2 class="font-semibold">Attēli</h2>

        <form class="mt-4 space-y-3" method="post" action="<?php echo e(route('admin.galerijas.atteli.store',$galerija)); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div>
                <label class="block text-sm font-medium">Attēls</label>
                <input type="file" name="image" accept="image/*"
                       class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
                <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-sm text-red-600 mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium">Alt teksts</label>
                    <input name="alt_teksts" value="<?php echo e(old('alt_teksts')); ?>"
                           class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
                    <?php $__errorArgs = ['alt_teksts'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-sm text-red-600 mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div>
                    <label class="block text-sm font-medium">Secība</label>
                    <input type="number" min="0" name="seciba" value="<?php echo e(old('seciba', 0)); ?>"
                           class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
                    <?php $__errorArgs = ['seciba'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-sm text-red-600 mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
            <button class="btn-primary" type="submit">Augšupielādēt</button>
        </form>

        <div class="mt-6 grid sm:grid-cols-2 gap-4">
            <?php $__currentLoopData = $galerija->atteli; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="rounded-2xl border overflow-hidden bg-zinc-50">
                    <img class="h-36 w-full object-cover" src="<?php echo e(asset('storage/'.$a->fails_cels)); ?>" alt="<?php echo e($a->alt_teksts ?? ''); ?>">
                    <div class="p-3 text-sm">
                        <div class="text-zinc-700"><?php echo e($a->alt_teksts ?? '—'); ?></div>
                        <div class="text-zinc-500">Secība: <?php echo e($a->seciba); ?></div>
                        <form class="mt-2" method="post" action="<?php echo e(route('admin.galerijas.atteli.destroy', [$galerija, $a])); ?>" onsubmit="return confirm('Dzēst attēlu?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button class="btn-secondary" type="submit">Dzēst</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\imnew\kuzuls-cms\resources\views/admin/galerijas/edit.blade.php ENDPATH**/ ?>