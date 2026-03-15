
<?php $__env->startSection('title','Projekti'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-10">
    <section class="page-hero reveal-up">
        <div class="section-header">
            <div class="section-eyebrow">Projekti</div>
            <h1 class="section-title">Darbi un ieceres, kas veido nozīmīgu kopienas virzību</h1>
            <p class="section-text">
                Apskati projektus, kuros Biedrība Kūzuls iesaistās, sadarbojas un rada paliekošu vērtību.
            </p>
        </div>
    </section>

    <form class="reveal-up delay-1 rounded-[1.5rem] bg-white border p-4 flex flex-wrap gap-3 items-end shadow-sm" method="get">
        <div class="flex-1 min-w-[240px]">
            <label class="block text-sm font-medium" for="q">Meklēt</label>
            <input id="q" name="q" value="<?php echo e(request('q')); ?>"
                   class="mt-1 w-full rounded-xl border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400" />
        </div>

        <div>
            <label class="block text-sm font-medium" for="statuss">Statuss</label>
            <select id="statuss" name="statuss"
                    class="mt-1 rounded-xl border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
                <option value="">Visi</option>
                <option value="planots" <?php echo e(request('statuss') === 'planots' ? 'selected' : ''); ?>>Plānots</option>
                <option value="aktivs" <?php echo e(request('statuss') === 'aktivs' ? 'selected' : ''); ?>>Aktīvs</option>
                <option value="pabeigts" <?php echo e(request('statuss') === 'pabeigts' ? 'selected' : ''); ?>>Pabeigts</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium" for="sort">Kārtot</label>
            <select id="sort" name="sort"
                    class="mt-1 rounded-xl border-zinc-200 focus:border-yellow-400 focus:ring-yellow-400">
                <option value="start_desc" <?php echo e(request('sort','start_desc') === 'start_desc' ? 'selected' : ''); ?>>Sākums ↓</option>
                <option value="start_asc" <?php echo e(request('sort') === 'start_asc' ? 'selected' : ''); ?>>Sākums ↑</option>
                <option value="end_desc" <?php echo e(request('sort') === 'end_desc' ? 'selected' : ''); ?>>Beigas ↓</option>
                <option value="end_asc" <?php echo e(request('sort') === 'end_asc' ? 'selected' : ''); ?>>Beigas ↑</option>
            </select>
        </div>

        <button class="btn-primary btn-pill" type="submit">Filtrēt</button>

        <?php if(request()->hasAny(['q','statuss','sort','kategorija_id'])): ?>
            <a class="btn-secondary btn-pill" href="<?php echo e(route('public.projekti.index')); ?>">Notīrīt</a>
        <?php endif; ?>
    </form>

    <?php if($projekti->count() === 0): ?>
        <div class="content-card text-zinc-600">
            Nav atrastu projektu.
        </div>
    <?php else: ?>
        <div class="page-grid">
            <?php $__currentLoopData = $projekti; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a class="reveal-up home-card group"
                   style="transition-delay: <?php echo e($index * 70); ?>ms;"
                   href="<?php echo e(route('public.projekti.show',$p)); ?>">
                    <div class="flex items-center justify-between gap-3">
                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs bg-yellow-50 border border-yellow-200 text-yellow-800">
                            <?php echo e(ucfirst($p->statuss?->value ?? 'planots')); ?>

                        </span>
                    </div>

                    <div class="mt-4 text-xl font-semibold text-zinc-950 group-hover:text-yellow-800">
                        <?php echo e($p->nosaukums); ?>

                    </div>

                    <div class="mt-2 text-sm text-zinc-500">
                        Sākums: <?php echo e(optional($p->sakuma_datums)->format('d.m.Y')); ?>

                        <?php if($p->beigu_datums): ?>
                            · Beigas: <?php echo e(optional($p->beigu_datums)->format('d.m.Y')); ?>

                        <?php endif; ?>
                    </div>

                    <div class="mt-3 text-sm leading-7 text-zinc-600 line-clamp-4">
                        <?php echo e($p->apraksts); ?>

                    </div>

                    <div class="mt-5 text-sm font-medium text-yellow-700">Skatīt projektu →</div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="mt-6">
            <?php echo e($projekti->links()); ?>

        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\imnew\kuzuls-cms\resources\views/public/projekti/index.blade.php ENDPATH**/ ?>