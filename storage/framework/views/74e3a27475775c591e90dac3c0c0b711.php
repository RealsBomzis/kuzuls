

<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-semibold">Audit logs</h1>

<div class="mt-6 rounded-2xl bg-white border overflow-hidden">
<table class="w-full text-sm">
    <thead class="bg-zinc-50 text-zinc-600">
        <tr>
            <th class="text-left p-3">Laiks</th>
            <th class="text-left p-3">User</th>
            <th class="text-left p-3">Darbība</th>
            <th class="text-left p-3">Objekts</th>
            <th class="text-left p-3">IP</th>
        </tr>
    </thead>
    <tbody>
<?php $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr class="border-t">
    <td class="p-3"><?php echo e(optional($l->created_at)->format('d.m.Y H:i')); ?></td>

    <td class="p-3">
        <?php if($l->user): ?>
            <div class="font-medium"><?php echo e($l->user->name); ?></div>
            <div class="text-xs text-zinc-500"><?php echo e($l->user->email); ?></div>
        <?php else: ?>
            <span class="text-zinc-500">—</span>
        <?php endif; ?>
    </td>

    <td class="p-3"><?php echo e($l->darbiba); ?></td>
    <td class="p-3"><?php echo e($l->objekta_tips); ?> #<?php echo e($l->objekta_id); ?></td>
    <td class="p-3"><?php echo e($l->ip_adrese); ?></td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
</div>

<div class="mt-6"><?php echo e($logs->links()); ?></div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\imnew\kuzuls-cms\resources\views/admin/audit/index.blade.php ENDPATH**/ ?>