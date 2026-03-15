

<?php $__env->startSection('content'); ?>
<div class="flex items-center justify-between">
    <h1 class="text-2xl font-semibold">Kategorijas</h1>
    <a class="btn-primary" href="<?php echo e(route('admin.kategorijas.create')); ?>">+ Jauna</a>
</div>

<div class="mt-6 rounded-2xl bg-white border overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-zinc-50 text-zinc-600">
            <tr>
                <th class="text-left p-3">Nosaukums</th>
                <th class="text-left p-3">Tips</th>
                <th class="p-3"></th>
            </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $kategorijas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr class="border-t">
                <td class="p-3 font-medium"><?php echo e($k->nosaukums); ?></td>
                <td class="p-3"><?php echo e($k->tips); ?></td>
                <td class="p-3 text-right">
                    <a class="navlink" href="<?php echo e(route('admin.kategorijas.edit',$k)); ?>">Labot</a>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete',$k)): ?>
                    <form class="inline" method="post" action="<?php echo e(route('admin.kategorijas.destroy',$k)); ?>" onsubmit="return confirm('Dzēst?')">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button class="navlink text-red-600" type="submit">Dzēst</button>
                    </form>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>

<div class="mt-6"><?php echo e($kategorijas->links()); ?></div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\imnew\kuzuls-cms\resources\views/admin/kategorijas/index.blade.php ENDPATH**/ ?>