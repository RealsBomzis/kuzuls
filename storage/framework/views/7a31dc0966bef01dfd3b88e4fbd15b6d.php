<?php $g = $galerija; ?>

<div>
    <label class="block text-sm font-medium">Nosaukums</label>
    <input name="nosaukums" value="<?php echo e(old('nosaukums', $g->nosaukums ?? '')); ?>"
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
    <textarea name="apraksts" rows="4"
              class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400"><?php echo e(old('apraksts', $g->apraksts ?? '')); ?></textarea>
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
        <label class="block text-sm font-medium">Kategorija</label>
        <select name="kategorija_id" class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
            <option value="">—</option>
            <?php $__currentLoopData = $kategorijas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($k->id); ?>" <?php if((string)old('kategorija_id', $g->kategorija_id ?? '') === (string)$k->id): echo 'selected'; endif; ?>>
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

    <div>
        <label class="block text-sm font-medium">Publicēts</label>
        <div class="mt-2 flex items-center gap-2">
            <input id="publicets" type="checkbox" name="publicets" value="1"
                   class="rounded border-zinc-300 text-yellow-500 focus:ring-yellow-400"
                   <?php if(old('publicets', $g->publicets ?? false)): echo 'checked'; endif; ?>>
            <label for="publicets" class="text-sm">Redzams publiski</label>
        </div>
    </div>
</div>

<div class="grid md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium">Saistīta tips</label>
        <?php $t = old('saistita_tips', $g->saistita_tips ?? 'nav'); ?>
        <select id="saistita_tips" name="saistita_tips"
                class="mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
            <option value="nav" <?php if($t==='nav'): echo 'selected'; endif; ?>>Nav</option>
            <option value="pasakumi" <?php if($t==='pasakumi'): echo 'selected'; endif; ?>>Pasākumi</option>
            <option value="projekti" <?php if($t==='projekti'): echo 'selected'; endif; ?>>Projekti</option>
            <option value="jaunumi" <?php if($t==='jaunumi'): echo 'selected'; endif; ?>>Jaunumi</option>
        </select>
        <?php $__errorArgs = ['saistita_tips'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-sm text-red-600 mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div>
        <label class="block text-sm font-medium">Saistītais ieraksts</label>

        
        <input type="hidden" id="saistita_id" name="saistita_id" value="<?php echo e(old('saistita_id', $g->saistita_id ?? '')); ?>">

        
        <select data-linked="pasakumi"
                class="linked-select mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400 hidden">
            <option value="">— izvēlies pasākumu —</option>
            <?php $__currentLoopData = ($pasakumi ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($p->id); ?>"><?php echo e($p->id); ?> — <?php echo e($p->nosaukums); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>

        
        <select data-linked="projekti"
                class="linked-select mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400 hidden">
            <option value="">— izvēlies projektu —</option>
            <?php $__currentLoopData = ($projekti ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($p->id); ?>"><?php echo e($p->id); ?> — <?php echo e($p->nosaukums); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>

        
        <select data-linked="jaunumi"
                class="linked-select mt-1 w-full rounded-lg border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400 hidden">
            <option value="">— izvēlies jaunumu —</option>
            <?php $__currentLoopData = ($jaunumi ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $j): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($j->id); ?>"><?php echo e($j->id); ?> — <?php echo e($j->virsraksts); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>

        
        <div id="linked-none" class="mt-1 text-sm text-zinc-500">Nav piesaistes.</div>

        <?php $__errorArgs = ['saistita_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-sm text-red-600 mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        <p class="mt-1 text-xs text-zinc-500">Ja izvēlas pasākumu, galerija tiks rādīta šī pasākuma lapā.</p>
    </div>
</div>

<script>
    (function () {
        const typeSelect = document.getElementById('saistita_tips');
        const hiddenInput = document.getElementById('saistita_id');
        const allSelects = Array.from(document.querySelectorAll('.linked-select'));
        const noneBlock = document.getElementById('linked-none');

        function syncVisibleSelect() {
            const type = typeSelect.value;

            allSelects.forEach(el => el.classList.add('hidden'));
            noneBlock.classList.add('hidden');

            if (type === 'nav') {
                hiddenInput.value = '';
                noneBlock.classList.remove('hidden');
                return;
            }

            const active = document.querySelector(`.linked-select[data-linked="${type}"]`);
            if (!active) {
                noneBlock.classList.remove('hidden');
                return;
            }

            active.classList.remove('hidden');

            if (hiddenInput.value) {
                active.value = hiddenInput.value;
            }

            hiddenInput.value = active.value || '';
        }

        allSelects.forEach(el => {
            el.addEventListener('change', function () {
                if (!this.classList.contains('hidden')) {
                    hiddenInput.value = this.value || '';
                }
            });
        });

        typeSelect.addEventListener('change', function () {
            hiddenInput.value = '';
            allSelects.forEach(el => el.value = '');
            syncVisibleSelect();
        });

        syncVisibleSelect();
    })();
</script><?php /**PATH C:\Users\imnew\kuzuls-cms\resources\views/admin/galerijas/partials/form.blade.php ENDPATH**/ ?>