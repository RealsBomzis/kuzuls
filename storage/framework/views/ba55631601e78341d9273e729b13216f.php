

<?php $__env->startSection('content'); ?>
<div class="flex items-center justify-between">
    <h1 class="text-2xl font-semibold">Projekti</h1>
    <div class="flex gap-2">
        <a class="btn-secondary" href="<?php echo e(route('admin.export.csv','projekti')); ?>">CSV</a>
        <a class="btn-secondary" href="<?php echo e(route('admin.export.pdf','projekti')); ?>">PDF</a>
        <a class="btn-primary" href="<?php echo e(route('admin.projekti.create')); ?>">+ Jauns</a>
    </div>
</div>

<div class="mt-6 rounded-2xl bg-white border overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-zinc-50 text-zinc-600">
            <tr>
                <th class="text-left p-3">Nosaukums</th>
                <th class="text-left p-3">Statuss</th>
                <th class="text-left p-3">Sākums</th>
                <th class="text-left p-3">Beigas</th>
                <th class="text-left p-3">Publicēts</th>
                <th class="p-3"></th>
            </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $projekti; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr class="border-t">
                <td class="p-3 font-medium"><?php echo e($p->nosaukums); ?></td>
                <td class="p-3"><?php echo e($p->statuss?->value); ?></td>
                <td class="p-3"><?php echo e(optional($p->sakuma_datums)->format('d.m.Y')); ?></td>
                <td class="p-3"><?php echo e($p->beigu_datums ? optional($p->beigu_datums)->format('d.m.Y') : '—'); ?></td>
                <td class="p-3">
                    <span class="inline-flex items-center rounded-full px-2 py-1 text-xs <?php echo e($p->publicets ? 'bg-yellow-100 text-yellow-800' : 'bg-zinc-100 text-zinc-700'); ?>">
                        <?php echo e($p->publicets ? 'Jā' : 'Nē'); ?>

                    </span>
                </td>
                <td class="p-3 text-right">
                    <a class="navlink" href="<?php echo e(route('admin.projekti.edit',$p)); ?>">Labot</a>
                    <form class="inline" method="post" action="<?php echo e(route('admin.projekti.destroy',$p)); ?>" onsubmit="return confirm('Dzēst?')">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button class="navlink text-red-600" type="submit">Dzēst</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>

<div class="mt-6"><?php echo e($projekti->links()); ?></div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\imnew\kuzuls-cms\resources\views/admin/projekti/index.blade.php ENDPATH**/ ?>