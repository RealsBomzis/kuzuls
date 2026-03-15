<?php
    $j = $jaunums;
?>

<div>
    <label class="block text-sm font-medium">Virsraksts</label>
    <input name="virsraksts" value="<?php echo e(old('virsraksts', $j->virsraksts ?? '')); ?>"
           class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
    <?php $__errorArgs = ['virsraksts'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-sm text-red-600 mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<div>
    <label class="block text-sm font-medium">Ievads</label>
    <input name="ievads" value="<?php echo e(old('ievads', $j->ievads ?? '')); ?>"
           class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
    <?php $__errorArgs = ['ievads'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-sm text-red-600 mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<div>
    <label class="block text-sm font-medium">Saturs</label>
    <textarea name="saturs" rows="10"
              class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400"><?php echo e(old('saturs', $j->saturs ?? '')); ?></textarea>
    <?php $__errorArgs = ['saturs'];
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
        <label class="block text-sm font-medium">Publicēšanas datums</label>
        <input type="date" name="publicesanas_datums"
               value="<?php echo e(old('publicesanas_datums', optional($j->publicesanas_datums ?? null)->toDateString())); ?>"
               class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
        <?php $__errorArgs = ['publicesanas_datums'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-sm text-red-600 mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-medium">Kategorija</label>
        <select name="kategorija_id" class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
            <option value="">—</option>
            <?php $__currentLoopData = $kategorijas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($k->id); ?>" <?php if((string)old('kategorija_id', $j->kategorija_id ?? '') === (string)$k->id): echo 'selected'; endif; ?>>
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
</div>

<div class="flex items-center gap-2">
    <input id="publicets" type="checkbox" name="publicets" value="1"
           class="rounded border-zinc-300 text-yellow-500 focus:ring-yellow-400"
           <?php if(old('publicets', $j->publicets ?? false)): echo 'checked'; endif; ?>>
    <label for="publicets" class="text-sm">Publicēts</label>
</div><?php /**PATH C:\Users\imnew\kuzuls-cms\resources\views/admin/jaunumi/partials/form.blade.php ENDPATH**/ ?>