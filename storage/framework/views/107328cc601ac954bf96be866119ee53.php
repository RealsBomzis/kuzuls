

<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-semibold">Kontaktziņojumi</h1>

<div class="mt-6 rounded-2xl bg-white border overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-zinc-50 text-zinc-600">
            <tr>
                <th class="text-left p-3">Vārds</th>
                <th class="text-left p-3">E-pasts</th>
                <th class="text-left p-3">Tēma</th>
                <th class="text-left p-3">Statuss</th>
                <th class="text-left p-3">Datums</th>
                <th class="text-right p-3 whitespace-nowrap">Rīcības</th>
            </tr>
        </thead>

        <tbody>
        <?php $__currentLoopData = $zinojumi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $z): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $statusVal = ($z->statuss?->value ?? $z->statuss);
            ?>

            <tr class="border-t align-top">
                <td class="p-3 font-medium"><?php echo e($z->vards); ?></td>
                <td class="p-3"><?php echo e($z->epasts); ?></td>
                <td class="p-3"><?php echo e($z->tema ?? '—'); ?></td>

                <td class="p-3">
                    <span class="inline-flex items-center rounded-full px-2 py-1 text-xs <?php echo e($statusVal === 'jauns' ? 'bg-yellow-100 text-yellow-800' : 'bg-zinc-100 text-zinc-700'); ?>">
                        <?php echo e($statusVal); ?>

                    </span>
                </td>

                <td class="p-3">
                    <?php echo e(optional($z->created_at)->format('d.m.Y H:i')); ?>

                </td>

                <td class="p-3 text-right whitespace-nowrap space-x-2">
                    <button type="button"
                            class="btn-secondary toggle-msg-btn"
                            data-msg-id="<?php echo e($z->id); ?>">
                    Skatīt
                    </button>

                    <?php if($statusVal === 'jauns'): ?>
                        <form class="inline" method="post" action="<?php echo e(route('admin.kontakt.process',$z)); ?>">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>
                            <button class="btn-secondary" type="submit">Atzīmēt kā apstrādātu</button>
                        </form>
                    <?php endif; ?>
                </td>
            </tr>

            
            <tr id="msg-<?php echo e($z->id); ?>" class="border-t hidden">
                <td colspan="6" class="p-3 bg-zinc-50 text-zinc-700">
                    <div class="text-xs text-zinc-500 mb-1">Ziņojums</div>
                    <div class="whitespace-pre-wrap"><?php echo e($z->zinojums); ?></div>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>

<div class="mt-6"><?php echo e($zinojumi->links()); ?></div>

<script>
  document.addEventListener('click', (e) => {
    const btn = e.target.closest('.toggle-msg-btn');
    if (!btn) return;

    const id = btn.dataset.msgId;
    const el = document.getElementById('msg-' + id);
    if (!el) return;

    el.classList.toggle('hidden');
  });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\imnew\kuzuls-cms\resources\views/admin/kontakt/index.blade.php ENDPATH**/ ?>