

<?php $__env->startSection('title','Kontakti'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto space-y-8">
    <section class="page-hero reveal-up">
        <div class="section-header">
            <div class="section-eyebrow">Kontakti</div>
            <h1 class="section-title">Sazinies ar mums</h1>
            <p class="section-text">
                Ja vēlies uzdot jautājumu, iesaistīties vai uzzināt vairāk par Biedrības Kūzuls darbību, raksti mums.
            </p>
        </div>
    </section>

    <form class="reveal-up delay-1 rounded-[2rem] border bg-white p-6 md:p-8 shadow-sm"
          method="post"
          action="<?php echo e(route('contact.store')); ?>">
        <?php echo csrf_field(); ?>

        <div class="grid gap-5 md:grid-cols-2">
            <div>
                <label class="block text-sm font-medium" for="vards">Vārds</label>
                <input id="vards" name="vards" value="<?php echo e(old('vards')); ?>"
                       class="mt-1 w-full rounded-xl border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
                <?php $__errorArgs = ['vards'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="mt-1 text-sm text-red-600"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label class="block text-sm font-medium" for="epasts">E-pasts</label>
                <input id="epasts" type="email" name="epasts" value="<?php echo e(old('epasts')); ?>"
                       class="mt-1 w-full rounded-xl border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
                <?php $__errorArgs = ['epasts'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="mt-1 text-sm text-red-600"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>

        <div class="mt-5">
            <label class="block text-sm font-medium" for="tema">Tēma</label>
            <input id="tema" name="tema" value="<?php echo e(old('tema')); ?>"
                   class="mt-1 w-full rounded-xl border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
            <?php $__errorArgs = ['tema'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="mt-1 text-sm text-red-600"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="mt-5">
            <label class="block text-sm font-medium" for="zinojums">Ziņojums</label>
            <textarea id="zinojums" name="zinojums" rows="7"
                      class="mt-1 w-full rounded-xl border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400"><?php echo e(old('zinojums')); ?></textarea>
            <?php $__errorArgs = ['zinojums'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="mt-1 text-sm text-red-600"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="mt-6">
            <button class="btn-primary btn-pill" type="submit">Nosūtīt ziņojumu</button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\imnew\kuzuls-cms\resources\views/public/contact.blade.php ENDPATH**/ ?>