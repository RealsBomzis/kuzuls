<?php

namespace App\Services;

use App\Enums\LinkKind;
use App\Enums\LinkReviewStatus;
use App\Models\{Jaunums, Lapa, Pasakums, Projekts, SaturaSaite};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SaturaSaisuDzinis
{
    public function generateSuggestionsFor(Model $source, int $limit = 8): void
    {
        $sourceType = $source->getTable(); // pasakumi/projekti/jaunumi/lapas
        if (!in_array($sourceType, ['pasakumi','projekti','jaunumi','lapas'], true)) {
            return;
        }

        $tokens = $this->tokenize($this->sourceText($source));
        if (count($tokens) < 3) return;

        // Candidate pool: published items only (publicets=1)
        $candidates = collect()
            ->merge(Pasakums::query()->published()->select('id','nosaukums','apraksts','kategorija_id')->get()->map(fn($x)=>['t'=>'pasakumi','m'=>$x]))
            ->merge(Projekts::query()->published()->select('id','nosaukums','apraksts','kategorija_id')->get()->map(fn($x)=>['t'=>'projekti','m'=>$x]))
            ->merge(Jaunums::query()->published()->select('id','virsraksts as nosaukums','saturs as apraksts','kategorija_id')->get()->map(fn($x)=>['t'=>'jaunumi','m'=>$x]))
            ->merge(Lapa::query()->published()->select('id','virsraksts as nosaukums','saturs as apraksts','kategorija_id')->get()->map(fn($x)=>['t'=>'lapas','m'=>$x]));

        $scored = $candidates
            ->reject(fn($c) => $c['t'] === $sourceType && (int)$c['m']->id === (int)$source->id)
            ->map(function ($c) use ($tokens, $source) {
                $text = $c['m']->nosaukums . ' ' . (string)($c['m']->apraksts ?? '');
                $candTokens = $this->tokenize($text);

                $overlap = count(array_intersect($tokens, $candTokens));
                $score = $overlap * 10;

                if (!empty($source->kategorija_id) && !empty($c['m']->kategorija_id) && (int)$source->kategorija_id === (int)$c['m']->kategorija_id) {
                    $score += 15;
                }

                return [
                    't' => $c['t'],
                    'id' => (int)$c['m']->id,
                    'score' => $score,
                ];
            })
            ->filter(fn($x) => $x['score'] >= 25)
            ->sortByDesc('score')
            ->take($limit)
            ->values();

        DB::transaction(function () use ($sourceType, $source, $scored) {
            foreach ($scored as $cand) {
                SaturaSaite::updateOrCreate(
                    [
                        'avots_tips' => $sourceType,
                        'avots_id' => (int)$source->id,
                        'merkis_tips' => $cand['t'],
                        'merkis_id' => $cand['id'],
                        'tips' => LinkKind::Automatiskas->value,
                    ],
                    [
                        'atbilstibas_punkti' => $cand['score'],
                        'review_status' => LinkReviewStatus::Pending->value,
                    ]
                );
            }
        });
    }

    private function sourceText(Model $m): string
    {
        return match ($m->getTable()) {
            'pasakumi' => $m->nosaukums . ' ' . (string)($m->apraksts ?? ''),
            'projekti' => $m->nosaukums . ' ' . (string)($m->apraksts ?? ''),
            'jaunumi'  => $m->virsraksts . ' ' . (string)($m->saturs ?? ''),
            'lapas'    => $m->virsraksts . ' ' . (string)($m->saturs ?? ''),
            default => '',
        };
    }

    private function tokenize(string $text): array
    {
        $text = mb_strtolower($text);
        $text = preg_replace('/[^\p{L}\p{N}\s]+/u', ' ', $text);
        $parts = preg_split('/\s+/u', trim($text)) ?: [];
        $parts = array_filter($parts, fn($w) => mb_strlen($w) >= 4);
        // crude Latvian stopwords (safe minimal)
        $stop = ['tikai','kā','kas','būs','bija','biedrība','biedrības','šis','šī','tā','tās','tur','arī','kuri','kura'];
        return array_values(array_unique(array_diff($parts, $stop)));
    }
}