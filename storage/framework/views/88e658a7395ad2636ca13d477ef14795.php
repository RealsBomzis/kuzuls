

<?php $__env->startSection('content'); ?>
<div class="flex items-center justify-between">
    <h1 class="text-2xl font-semibold">Galerijas</h1>
    <div class="flex gap-2">
        <a class="btn-secondary" href="<?php echo e(route('admin.export.csv','galerijas')); ?>">CSV</a>
        <a class="btn-secondary" href="<?php echo e(route('admin.export.pdf','galerijas')); ?>">PDF</a>
        <a class="btn-primary" href="<?php echo e(route('admin.galerijas.create')); ?>">+ Jauna</a>
    </div>
</div>

<div class="mt-6 rounded-2xl bg-white border overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-zinc-50 text-zinc-600">
            <tr>
                <th class="text-left p-3">Nosaukums</th>
                <th class="text-left p-3">Attēli</th>
                <th class="text-left p-3">Publicēts</th>
                <th class="p-3"></th>
            </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $galerijas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr class="border-t">
                <td class="p-3 font-medium"><?php echo e($g->nosaukums); ?></td>
                <td class="p-3"><?php echo e($g->atteli_count); ?></td>
                <td class="p-3">
                    <span class="inline-flex items-center rounded-full px-2 py-1 text-xs <?php echo e($g->publicets ? 'bg-yellow-100 text-yellow-800' : 'bg-zinc-100 text-zinc-700'); ?>">
                        <?php echo e($g->publicets ? 'Jā' : 'Nē'); ?>

                    </span>
                </td>
                <td class="p-3 text-right">
                    <a class="navlink" href="<?php echo e(route('admin.galerijas.edit',$g)); ?>">Labot</a>
                    <form class="inline" method="post" action="<?php echo e(route('admin.galerijas.destroy',$g)); ?>" onsubmit="return confirm('Dzēst?')">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button class="navlink text-red-600" type="submit">Dzēst</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>

<div class="mt-6"><?php echo e($galerijas->links()); ?></div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\imnew\kuzuls-cms\resources\views/admin/galerijas/index.blade.php ENDPATH**/ ?>