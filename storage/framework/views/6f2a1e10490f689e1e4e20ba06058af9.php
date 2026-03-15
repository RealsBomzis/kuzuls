<?php
    $p = $projekts;
?>

<div>
    <label class="block text-sm font-medium">Nosaukums</label>
    <input name="nosaukums" value="<?php echo e(old('nosaukums', $p->nosaukums ?? '')); ?>"
           class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
    <?php $__errorArgs = ['nosaukums'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-sm text-red-600 mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<div>
    <label class="block text-sm font-medium">Apraksts</label>
    <textarea name="apraksts" rows="6"
              class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400"><?php echo e(old('apraksts', $p->apraksts ?? '')); ?></textarea>
    <?php $__errorArgs = ['apraksts'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-sm text-red-600 mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<div class="grid md:grid-cols-3 gap-4">
    <div>
        <label class="block text-sm font-medium">Statuss</label>
        <select name="statuss" class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
            <?php $val = old('statuss', $p->statuss?->value ?? 'planots'); ?>
            <option value="planots" <?php if($val==='planots'): echo 'selected'; endif; ?>>Plānots</option>
            <option value="aktivs" <?php if($val==='aktivs'): echo 'selected'; endif; ?>>Aktīvs</option>
            <option value="pabeigts" <?php if($val==='pabeigts'): echo 'selected'; endif; ?>>Pabeigts</option>
        </select>
        <?php $__errorArgs = ['statuss'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-sm text-red-600 mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
    <div>
        <label class="block text-sm font-medium">Sākuma datums</label>
        <input type="date" name="sakuma_datums" value="<?php echo e(old('sakuma_datums', optional($p->sakuma_datums ?? null)->toDateString())); ?>"
               class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
        <?php $__errorArgs = ['sakuma_datums'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-sm text-red-600 mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
    <div>
        <label class="block text-sm font-medium">Beigu datums</label>
        <input type="date" name="beigu_datums" value="<?php echo e(old('beigu_datums', optional($p->beigu_datums ?? null)->toDateString())); ?>"
               class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
        <?php $__errorArgs = ['beigu_datums'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-sm text-red-600 mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
</div>

<div>
    <label class="block text-sm font-medium">Kategorija</label>
    <select name="kategorija_id" class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
        <option value="">—</option>
        <?php $__currentLoopData = $kategorijas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($k->id); ?>" <?php if((string)old('kategorija_id', $p->kategorija_id ?? '') === (string)$k->id): echo 'selected'; endif; ?>>
                <?php echo e($k->nosaukums); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
    <?php $__errorArgs = ['kategorija_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-sm text-red-600 mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<div class="flex items-center gap-2">
    <input id="publicets" type="checkbox" name="publicets" value="1"
           class="rounded border-zinc-300 text-yellow-500 focus:ring-yellow-400"
           <?php if(old('publicets', $p->publicets ?? false)): echo 'checked'; endif; ?>>
    <label for="publicets" class="text-sm">Publicēts</label>
</div><?php /**PATH C:\Users\imnew\kuzuls-cms\resources\views/admin/projekti/partials/form.blade.php ENDPATH**/ ?>