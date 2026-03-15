

<?php $__env->startSection('content'); ?>
<div class="flex items-center justify-between">
    <h1 class="text-2xl font-semibold">Lietotāji</h1>
    <a class="btn-primary" href="<?php echo e(route('admin.users.create')); ?>">+ Jauns</a>
</div>

<div class="mt-6 rounded-2xl bg-white border overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-zinc-50 text-zinc-600">
            <tr>
                <th class="text-left p-3">Vārds</th>
                <th class="text-left p-3">E-pasts</th>
                <th class="text-left p-3">Lomas</th>
                <th class="text-left p-3">Aktīvs</th>
                <th class="p-3"></th>
            </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr class="border-t">
                <td class="p-3 font-medium"><?php echo e($u->name); ?></td>
                <td class="p-3"><?php echo e($u->email); ?></td>
                <td class="p-3">
                    <?php $__currentLoopData = $u->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <span class="inline-flex rounded-full px-2 py-1 text-xs bg-yellow-50 border border-yellow-200 text-yellow-800"><?php echo e($r->nosaukums); ?></span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </td>
                <td class="p-3"><?php echo e($u->is_active ? 'Jā' : 'Nē'); ?></td>
                <td class="p-3 text-right">
                    <a class="navlink" href="<?php echo e(route('admin.users.edit',$u)); ?>">Labot</a>
                    <form class="inline" method="post" action="<?php echo e(route('admin.users.destroy',$u)); ?>" onsubmit="return confirm('Dzēst?')">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button class="navlink text-red-600" type="submit">Dzēst</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>

<div class="mt-6"><?php echo e($users->links()); ?></div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\imnew\kuzuls-cms\resources\views/admin/users/index.blade.php ENDPATH**/ ?>