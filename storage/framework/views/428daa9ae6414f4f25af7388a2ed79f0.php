<?php
    $p = $pasakums;
?>

<div>
    <label class="block text-sm font-medium" for="nosaukums">Nosaukums</label>
    <input id="nosaukums" name="nosaukums"
           value="<?php echo e(old('nosaukums', $p->nosaukums ?? '')); ?>"
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
    <label class="block text-sm font-medium" for="apraksts">Apraksts</label>
    <textarea id="apraksts" name="apraksts" rows="6"
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

<div class="grid md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium" for="norises_datums">Datums</label>
        <input id="norises_datums" type="date" name="norises_datums"
               value="<?php echo e(old('norises_datums', optional($p->norises_datums ?? null)->format('Y-m-d') ?? '')); ?>"
               class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
        <?php $__errorArgs = ['norises_datums'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-sm text-red-600 mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div>
        <label class="block text-sm font-medium" for="sakuma_laiks">Laiks</label>
        <input id="sakuma_laiks" type="time" name="sakuma_laiks"
               value="<?php echo e(old('sakuma_laiks', !empty($p->sakuma_laiks) ? \Illuminate\Support\Str::of($p->sakuma_laiks)->substr(0,5) : '')); ?>"
               class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
        <?php $__errorArgs = ['sakuma_laiks'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-sm text-red-600 mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
</div>


<div class="grid md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium" for="beigu_laiks">Beigu laiks</label>
        <input id="beigu_laiks" type="time" name="beigu_laiks"
               value="<?php echo e(old('beigu_laiks', !empty($p->beigu_laiks) ? \Illuminate\Support\Str::of($p->beigu_laiks)->substr(0,5) : '')); ?>"
               class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
        <?php $__errorArgs = ['beigu_laiks'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-sm text-red-600 mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
    <div></div>
</div>

<div class="grid md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium" for="vieta">Vieta</label>
        <input id="vieta" name="vieta"
               value="<?php echo e(old('vieta', $p->vieta ?? '')); ?>"
               class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
        <?php $__errorArgs = ['vieta'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-sm text-red-600 mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div>
        <label class="block text-sm font-medium" for="kategorija_id">Kategorija</label>
        <select id="kategorija_id" name="kategorija_id"
                class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
            <option value="">—</option>
            <?php $__currentLoopData = $kategorijas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($k->id); ?>"
                        <?php if((string)old('kategorija_id', $p->kategorija_id ?? '') === (string)$k->id): echo 'selected'; endif; ?>>
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

<div class="grid md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium" for="talrunis">Tālrunis</label>
        <input id="talrunis" name="talrunis"
               value="<?php echo e(old('talrunis', $p->talrunis ?? '')); ?>"
               class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
        <?php $__errorArgs = ['talrunis'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-sm text-red-600 mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div>
        <label class="block text-sm font-medium" for="epasts">E-pasts</label>
        <input id="epasts" type="email" name="epasts"
               value="<?php echo e(old('epasts', $p->epasts ?? '')); ?>"
               class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
        <?php $__errorArgs = ['epasts'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-sm text-red-600 mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
</div>

<div class="rounded-xl border border-zinc-200 bg-zinc-50 p-4">
    <div class="font-medium">Attēls</div>
    <p class="text-xs text-zinc-500 mt-1">Droša augšupielāde (attēla fails). Ja neatjauno — atstāj tukšu.</p>

    <?php if(!empty($p?->attels)): ?>
        <div class="mt-3 flex items-start gap-4">
            <img src="<?php echo e(asset('storage/'.$p->attels)); ?>" alt="" class="h-24 w-36 object-cover rounded-lg border">
            <div class="text-sm text-zinc-700">
                <div class="text-xs text-zinc-500">Pašreizējais fails</div>
                <div class="font-mono text-xs"><?php echo e($p->attels); ?></div>
            </div>
        </div>
    <?php endif; ?>

    <div class="mt-3">
        <label class="block text-sm font-medium" for="attels">Jauns attēls</label>
        <input id="attels" type="file" name="attels" accept="image/*"
               class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
        <?php $__errorArgs = ['attels'];
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
           <?php if(old('publicets', (bool)($p->publicets ?? false))): echo 'checked'; endif; ?>>
    <label for="publicets" class="text-sm">Publicēts (redzams publiski)</label>
</div><?php /**PATH C:\Users\imnew\kuzuls-cms\resources\views/admin/pasakumi/partials/form.blade.php ENDPATH**/ ?>