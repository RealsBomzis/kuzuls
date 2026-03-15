

<?php $__env->startSection('title','Sākums'); ?>

<?php $__env->startSection('content'); ?>
<?php
    use Illuminate\Support\Facades\Storage;

    $featuredEvent = $pasakumi->first();

    function eventImageUrl($event) {
        if (!$event || empty($event->attels)) return null;

        return Storage::disk('public')->exists($event->attels)
            ? Storage::url($event->attels)
            : asset('storage/'.$event->attels);
    }
?>

<div class="space-y-16 md:space-y-24">
    
    <section class="relative overflow-hidden rounded-[2rem] border border-zinc-200 bg-white hero-shell">
        <div class="absolute inset-0 hero-glow pointer-events-none"></div>

        <div class="relative grid items-center gap-10 px-6 py-12 md:px-10 md:py-16 lg:grid-cols-2 lg:px-14 lg:py-20">
            <div class="reveal-up">
                <div class="inline-flex items-center rounded-full border border-yellow-200 bg-yellow-50 px-4 py-1.5 text-sm font-medium text-yellow-800">
                    Biedrība Kūzuls
                </div>

                <h1 class="mt-6 max-w-3xl text-4xl font-semibold tracking-tight text-zinc-950 md:text-5xl lg:text-6xl">
                    Kopā veidojam aktīvu, radošu un dzīvu kopienu
                </h1>

                <p class="mt-6 max-w-2xl text-base leading-8 text-zinc-600 md:text-lg">
                    Biedrība Kūzuls organizē pasākumus, īsteno projektus un dalās ar jaunumiem,
                    kas stiprina vietējo kopienu un iedvesmo iesaistīties.
                </p>

                <div class="mt-8 flex flex-wrap gap-3">
                    <?php if($featuredEvent): ?>
                        <a href="#tuvakais-pasakums" class="btn-primary btn-pill">
                            Apskati tuvāko pasākumu
                        </a>
                    <?php else: ?>
                        <a href="<?php echo e(route('public.pasakumi.index')); ?>" class="btn-primary btn-pill">
                            Skatīt pasākumus
                        </a>
                    <?php endif; ?>

                    <a href="#projekti" class="btn-secondary btn-pill">
                        Apskatīt projektus
                    </a>
                </div>
            </div>

            <div class="reveal-up delay-1">
                <div class="rounded-[1.75rem] border border-zinc-200 bg-white p-3 shadow-[0_25px_80px_rgba(0,0,0,0.08)]">
                    <?php if($featuredEvent && eventImageUrl($featuredEvent)): ?>
                        <div class="overflow-hidden rounded-[1.4rem] border border-zinc-100 bg-zinc-100">
                            <img
                                src="<?php echo e(eventImageUrl($featuredEvent)); ?>"
                                alt="<?php echo e($featuredEvent->nosaukums); ?>"
                                class="h-[320px] w-full object-cover md:h-[420px]"
                            >
                        </div>
                    <?php else: ?>
                        <div class="flex h-[320px] items-center justify-center rounded-[1.4rem] border border-zinc-100 bg-zinc-100 text-zinc-400 md:h-[420px]">
                            Nav attēla
                        </div>
                    <?php endif; ?>

                    <?php if($featuredEvent): ?>
                        <div class="p-5">
                            <div class="text-sm text-zinc-500">
                                <?php echo e($featuredEvent->norises_datums?->format('d.m.Y') ?? '—'); ?>

                                <?php if($featuredEvent->sakuma_laiks): ?>
                                    · <?php echo e(\Illuminate\Support\Str::of($featuredEvent->sakuma_laiks)->substr(0,5)); ?>

                                <?php endif; ?>
                            </div>

                            <div class="mt-2 text-2xl font-semibold text-zinc-950">
                                <?php echo e($featuredEvent->nosaukums); ?>

                            </div>

                            <div class="mt-2 text-sm text-zinc-600">
                                <?php echo e($featuredEvent->vieta); ?>

                            </div>

                            <a href="<?php echo e(route('public.pasakumi.show',$featuredEvent)); ?>"
                               class="mt-4 inline-flex items-center gap-2 text-sm font-medium text-yellow-700 hover:text-yellow-800">
                                Atvērt pasākumu
                                <span aria-hidden="true">→</span>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    
    <section id="tuvakais-pasakums" class="space-y-8">
        <div class="reveal-up max-w-2xl">
            <div class="text-sm font-medium text-yellow-700">Tuvākie pasākumi</div>
            <h2 class="mt-2 text-3xl font-semibold tracking-tight text-zinc-950 md:text-4xl">
                Notikumi, kuros vari iesaistīties jau tuvākajā laikā
            </h2>
            <p class="mt-3 text-base leading-7 text-zinc-600">
                Svarīgākie pasākumi un aktivitātes, kas šobrīd ir visaktuālākās mūsu kopienai.
            </p>
        </div>

        <?php if($pasakumi->count()): ?>
            <div class="reveal-up delay-1 event-slider rounded-[2rem] border border-zinc-200 bg-white p-4 md:p-6" data-event-slider>
                <div class="flex items-center justify-between gap-3 mb-4">
                    <div class="text-sm text-zinc-500">
                        Izvēlies nākamo pasākumu
                    </div>

                    <div class="flex gap-2">
                        <button type="button" class="slider-arrow" data-event-prev aria-label="Iepriekšējais pasākums">←</button>
                        <button type="button" class="slider-arrow" data-event-next aria-label="Nākamais pasākums">→</button>
                    </div>
                </div>

                <div class="relative overflow-hidden rounded-[1.5rem] border border-zinc-100 bg-zinc-50">
                    <?php $__currentLoopData = $pasakumi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $img = eventImageUrl($p);
                        ?>

                        <a href="<?php echo e(route('public.pasakumi.show',$p)); ?>"
                           class="event-slide <?php echo e($index === 0 ? '' : 'hidden'); ?> block"
                           data-event-slide>
                            <div class="grid lg:grid-cols-[1.15fr_0.85fr]">
                                <div class="bg-zinc-100">
                                    <?php if($img): ?>
                                        <img src="<?php echo e($img); ?>" alt="<?php echo e($p->nosaukums); ?>" class="h-[280px] w-full object-cover md:h-[420px]">
                                    <?php else: ?>
                                        <div class="flex h-[280px] items-center justify-center text-zinc-400 md:h-[420px]">
                                            Nav attēla
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="flex flex-col justify-center p-6 md:p-8 lg:p-10">
                                    <div class="inline-flex w-fit rounded-full border border-yellow-200 bg-yellow-50 px-3 py-1 text-sm text-yellow-800">
                                        <?php echo e($p->norises_datums?->format('d.m.Y') ?? '—'); ?>

                                        <?php if($p->sakuma_laiks): ?>
                                            · <?php echo e(\Illuminate\Support\Str::of($p->sakuma_laiks)->substr(0,5)); ?>

                                        <?php endif; ?>
                                    </div>

                                    <h3 class="mt-5 text-3xl font-semibold tracking-tight text-zinc-950">
                                        <?php echo e($p->nosaukums); ?>

                                    </h3>

                                    <div class="mt-3 text-zinc-600">
                                        <?php echo e($p->vieta); ?>

                                    </div>

                                    <?php if($p->apraksts): ?>
                                        <p class="mt-5 line-clamp-4 leading-7 text-zinc-600">
                                            <?php echo e($p->apraksts); ?>

                                        </p>
                                    <?php endif; ?>

                                    <div class="mt-8 inline-flex items-center gap-2 text-sm font-medium text-yellow-700">
                                        Skatīt pasākumu
                                        <span aria-hidden="true">→</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="mt-4 grid gap-3 md:grid-cols-3">
                    <?php $__currentLoopData = $pasakumi->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $thumbIndex => $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <button type="button"
                                class="event-thumb <?php echo e($thumbIndex === 0 ? 'is-active' : ''); ?>"
                                data-event-thumb="<?php echo e($thumbIndex); ?>">
                            <div class="text-left">
                                <div class="text-xs text-zinc-500"><?php echo e($p->norises_datums?->format('d.m.Y') ?? '—'); ?></div>
                                <div class="mt-1 font-medium text-zinc-900 truncate"><?php echo e($p->nosaukums); ?></div>
                                <div class="mt-1 text-xs text-zinc-500 truncate"><?php echo e($p->vieta); ?></div>
                            </div>
                        </button>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="mt-6">
                    <a href="<?php echo e(route('public.pasakumi.index')); ?>" class="btn-secondary btn-pill">
                        Visi pasākumi
                    </a>
                </div>
            </div>
        <?php else: ?>
            <div class="rounded-[1.5rem] border border-zinc-200 bg-white p-6 text-zinc-600">
                Pašlaik nav publicētu tuvāko pasākumu.
            </div>
        <?php endif; ?>
    </section>

    
    <section id="jaunumi" class="space-y-8">
        <div class="reveal-up max-w-2xl">
            <div class="text-sm font-medium text-yellow-700">Jaunumi</div>
            <h2 class="mt-2 text-3xl font-semibold tracking-tight text-zinc-950 md:text-4xl">
                Aktuālais par mūsu darbību un iniciatīvām
            </h2>
            <p class="mt-3 text-base leading-7 text-zinc-600">
                Uzzini par jaunākajiem notikumiem, idejām un aktivitātēm, kas šobrīd ir mūsu uzmanības centrā.
            </p>
        </div>

        <div class="grid gap-5 lg:grid-cols-3">
            <?php $__currentLoopData = $jaunumi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $j): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('public.jaunumi.show',$j)); ?>"
                   class="reveal-up <?php echo e($index === 0 ? 'lg:col-span-2' : ''); ?> home-card group"
                   style="transition-delay: <?php echo e($index * 80); ?>ms;">
                    <div class="text-sm text-zinc-500"><?php echo e($j->publicesanas_datums?->format('d.m.Y') ?? '—'); ?></div>
                    <h3 class="mt-3 text-xl font-semibold tracking-tight text-zinc-950 group-hover:text-yellow-800">
                        <?php echo e($j->virsraksts); ?>

                    </h3>
                    <p class="mt-3 line-clamp-4 leading-7 text-zinc-600">
                        <?php echo e($j->ievads ?: \Illuminate\Support\Str::limit(strip_tags($j->saturs), 200)); ?>

                    </p>
                    <div class="mt-5 inline-flex items-center gap-2 text-sm font-medium text-yellow-700">
                        Lasīt vairāk
                        <span aria-hidden="true" class="transition group-hover:translate-x-0.5">→</span>
                    </div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="reveal-up">
            <a href="<?php echo e(route('public.jaunumi.index')); ?>" class="btn-secondary btn-pill">
                Visi jaunumi
            </a>
        </div>
    </section>

    
    <section id="projekti" class="space-y-8">
        <div class="reveal-up max-w-2xl">
            <div class="text-sm font-medium text-yellow-700">Projekti</div>
            <h2 class="mt-2 text-3xl font-semibold tracking-tight text-zinc-950 md:text-4xl">
                Darbi un ieceres, kas veido nozīmīgu kopienas virzību
            </h2>
            <p class="mt-3 text-base leading-7 text-zinc-600">
                Apskati projektus, kuros Biedrība Kūzuls iesaistās, sadarbojas un rada paliekošu vērtību.
            </p>
        </div>

        <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
            <?php $__currentLoopData = $projekti; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('public.projekti.show',$p)); ?>"
                   class="reveal-up home-card group"
                   style="transition-delay: <?php echo e($index * 80); ?>ms;">
                    <div class="inline-flex items-center rounded-full border border-zinc-200 bg-zinc-50 px-3 py-1 text-xs font-medium text-zinc-600">
                        Projekts
                    </div>

                    <h3 class="mt-4 text-xl font-semibold tracking-tight text-zinc-950 group-hover:text-yellow-800">
                        <?php echo e($p->nosaukums); ?>

                    </h3>

                    <p class="mt-3 line-clamp-4 leading-7 text-zinc-600">
                        <?php echo e(\Illuminate\Support\Str::limit(strip_tags($p->apraksts), 180)); ?>

                    </p>

                    <div class="mt-5 inline-flex items-center gap-2 text-sm font-medium text-yellow-700">
                        Skatīt projektu
                        <span aria-hidden="true" class="transition group-hover:translate-x-0.5">→</span>
                    </div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>

    
    <section class="reveal-up rounded-[2rem] border border-zinc-200 bg-white px-6 py-10 shadow-sm md:px-10 md:py-14">
        <div class="grid items-center gap-8 lg:grid-cols-[1fr_auto]">
            <div>
                <div class="inline-flex items-center rounded-full border border-yellow-200 bg-yellow-50 px-3 py-1 text-sm font-medium text-yellow-800">
                    Iesaisties
                </div>

                <h2 class="mt-4 text-3xl font-semibold tracking-tight text-zinc-950 md:text-4xl">
                    Vēlies uzzināt vairāk vai iesaistīties mūsu darbībā?
                </h2>

                <p class="mt-4 max-w-2xl leading-7 text-zinc-600">
                    Seko mūsu jaunumiem, apskati tuvākos notikumus vai sazinies ar mums,
                    lai iepazītu Biedrības Kūzuls darbību tuvāk.
                </p>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="<?php echo e(route('contact.create')); ?>" class="btn-primary btn-pill">Sazināties</a>
                <a href="<?php echo e(route('public.jaunumi.index')); ?>" class="btn-secondary btn-pill">Skatīt jaunumus</a>
            </div>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\imnew\kuzuls-cms\resources\views/public/home.blade.php ENDPATH**/ ?>