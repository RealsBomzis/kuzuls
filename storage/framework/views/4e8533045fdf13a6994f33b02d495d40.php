<?php
    use App\Enums\ContentType;
    use App\Models\{Jaunums, Lapa, Pasakums, Projekts, SaturaSaite};

    $links = SaturaSaite::query()
        ->approvedAuto()
        ->where('avots_tips', $sourceType)
        ->where('avots_id', $sourceId)
        ->orderByDesc('atbilstibas_punkti')
        ->limit(8)
        ->get();

    $byType = $links->groupBy('merkis_tips');

    $targets = collect();

    foreach ($byType as $type => $rows) {
        $ids = $rows->pluck('merkis_id')->map(fn($x)=>(int)$x)->unique()->values();

        $items = match ($type) {
            'pasakumi' => Pasakums::whereIn('id', $ids)->where('publicets',1)->get(['id','nosaukums']),
            'projekti' => Projekts::whereIn('id', $ids)->where('publicets',1)->get(['id','nosaukums']),
            'jaunumi'  => Jaunums::whereIn('id', $ids)->where('publicets',1)->get(['id','virsraksts']),
            'lapas'    => Lapa::whereIn('id', $ids)->where('publicets',1)->get(['id','virsraksts','slug']),
            default    => collect(),
        };

        foreach ($items as $it) {
            $title = property_exists($it, 'nosaukums') ? $it->nosaukums : $it->virsraksts;
            $url = match ($type) {
                'pasakumi' => route('public.pasakumi.show', $it->id),
                'projekti' => route('public.projekti.show', $it->id),
                'jaunumi'  => route('public.jaunumi.show', $it->id),
                'lapas'    => route('public.page.show', $it->slug),
                default    => '#',
            };

            $targets["{$type}:{$it->id}"] = ['title' => $title, 'url' => $url];
        }
    }
?>

<?php if($links->count()): ?>
<div class="mt-6 rounded-2xl bg-white border p-5">
    <h2 class="font-semibold">Saistītais saturs</h2>
    <ul class="mt-3 space-y-2 text-sm">
        <?php $__currentLoopData = $links; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $t = $targets["{$l->merkis_tips}:{$l->merkis_id}"] ?? null; ?>
            <?php if($t): ?>
                <li class="flex items-center justify-between gap-4">
                    <a class="text-zinc-800 hover:underline"
                       href="<?php echo e($t['url']); ?>">
                       <?php echo e($t['title']); ?>

                    </a>
                    <span class="text-yellow-700 shrink-0">+<?php echo e($l->atbilstibas_punkti); ?></span>
                </li>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
</div>
<?php endif; ?><?php /**PATH C:\Users\imnew\kuzuls-cms\resources\views/public/partials/related-links.blade.php ENDPATH**/ ?>