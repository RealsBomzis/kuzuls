<?php

namespace App\Services\SaturaSaites;

use App\Enums\LinkKind;
use App\Enums\LinkReviewStatus;
use App\Models\{Jaunums, Lapa, Pasakums, Projekts, SaturaSaite};
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class AutoSuggestionService
{
    public function generate(
        int $maxPerSource = 5,
        int $limitSourcesPerType = 80,
        int $limitTargetsPerType = 300,
        int $minScore = 25
    ): int {
        $created = 0;

        // Config is optional; safe defaults if missing
        $cfg = config('satura_saites', []);
        $cities = array_map(fn($c) => Str::lower($c), $cfg['cities'] ?? [
            'rīga','cesis','cēsis','jelgava','liepāja','daugavpils','ventspils','rezekne','rēzekne',
            'jūrmala','valmiera','ogre','tukums','sigulda','kuldīga','talsi','madona','jēkabpils',
        ]);

        $groups = $cfg['activity_groups'] ?? [
            'kafija_karjera' => ['kafija','kafejnīca','kafe','cv','karjera','linkedin','darbs','vakars','konsultants'],
            'joga_sports'    => ['joga','sports','treniņš','kustība','skriešana','fitness','vingrošana'],
            'tirgus_amatnieki'=> ['tirgus','tirdziņš','amatnieki','roku','darbi','pavasara','ziemas','vasaras'],
        ];

        // Weights
        $W_TEXT_MAX = (int)($cfg['weights']['text_max'] ?? 70);     // text component max
        $W_BIGRAM_MAX = (int)($cfg['weights']['bigram_max'] ?? 14); // phrase bonus max
        $W_CITY = (int)($cfg['weights']['city_exact'] ?? 18);
        $W_CATEGORY = (int)($cfg['weights']['category'] ?? 12);
        $W_GROUP = (int)($cfg['weights']['group_match'] ?? 14);
        $W_TIME_MAX = (int)($cfg['weights']['time_close_max'] ?? 14);

        // Sources (published only)
        $sources = [
            'pasakumi' => Pasakums::query()->where('publicets', 1)->latest('id')->limit($limitSourcesPerType)
                ->get(['id','nosaukums','apraksts','vieta','norises_datums','kategorija_id','created_at']),
            'projekti' => Projekts::query()->where('publicets', 1)->latest('id')->limit($limitSourcesPerType)
                ->get(['id','nosaukums','apraksts','kategorija_id','created_at']),
            'jaunumi'  => Jaunums::query()->where('publicets', 1)->latest('id')->limit($limitSourcesPerType)
                ->get(['id','virsraksts','saturs','kategorija_id','created_at']),
            'lapas'    => Lapa::query()->where('publicets', 1)->latest('id')->limit($limitSourcesPerType)
                ->get(['id','virsraksts','saturs','kategorija_id','created_at']),
        ];

        // Targets (published only) — include body text too (for better relevance)
        $targets = [
            'pasakumi' => Pasakums::query()->where('publicets', 1)->latest('id')->limit($limitTargetsPerType)
                ->get(['id','nosaukums','apraksts','vieta','norises_datums','kategorija_id']),
            'projekti' => Projekts::query()->where('publicets', 1)->latest('id')->limit($limitTargetsPerType)
                ->get(['id','nosaukums','apraksts','kategorija_id']),
            'jaunumi'  => Jaunums::query()->where('publicets', 1)->latest('id')->limit($limitTargetsPerType)
                ->get(['id','virsraksts','saturs','kategorija_id','created_at']),
            'lapas'    => Lapa::query()->where('publicets', 1)->latest('id')->limit($limitTargetsPerType)
                ->get(['id','virsraksts','saturs','kategorija_id','created_at']),
        ];

        // Precompute target documents + DF for IDF-lite weighting
        $targetDocs = [];
        $df = [];
        $docCount = 0;

        foreach ($targets as $type => $items) {
            foreach ($items as $t) {
                $docCount++;

                $text = $this->fullText($type, $t);
                $tokens = $this->tokenSet($text);
                $bigrams = $this->bigramsFromText($text);

                $key = "{$type}:{$t->id}";
                $targetDocs[$key] = [
                    'type' => $type,
                    'id' => (int)$t->id,
                    'tokens' => $tokens,
                    'bigrams' => $bigrams,
                    'cat' => (int)($t->kategorija_id ?? 0),
                    'city' => $this->extractCity($type, $t, $cities, $text),
                    'date' => $this->extractDate($type, $t),
                    'groups' => $this->hitGroups($groups, $tokens),
                ];

                foreach ($tokens as $tok => $_) {
                    $df[$tok] = ($df[$tok] ?? 0) + 1;
                }
            }
        }

        // IDF-lite weights
        $idf = [];
        foreach ($df as $tok => $count) {
            $idf[$tok] = log(($docCount + 1) / ($count + 1)) + 1.0;
        }

        foreach ($sources as $sourceType => $items) {
            foreach ($items as $src) {
                $srcText = $this->fullText($sourceType, $src);
                $srcTokens = $this->tokenSet($srcText);

                if (count($srcTokens) < 3) continue;

                $srcBigrams = $this->bigramsFromText($srcText);
                $srcCat = (int)($src->kategorija_id ?? 0);
                $srcCity = $this->extractCity($sourceType, $src, $cities, $srcText);
                $srcDate = $this->extractDate($sourceType, $src);
                $srcGroups = $this->hitGroups($groups, $srcTokens);

                $candidates = [];

                foreach ($targetDocs as $doc) {
                    $tType = $doc['type'];
                    $tId   = $doc['id'];

                    // avoid self-links
                    if ($sourceType === $tType && (int)$src->id === $tId) continue;

                    // Weighted token overlap (raw)
                    $raw = 0.0;
                    $hits = 0;
                    foreach ($srcTokens as $tok => $_) {
                        if (isset($doc['tokens'][$tok])) {
                            $raw += $idf[$tok] ?? 1.0;
                            $hits++;
                        }
                    }

                    // Need at least 2 shared meaningful tokens
                    if ($hits < 2) continue;

                    // TEXT SCORE with SMOOTH scaling into 0..W_TEXT_MAX (prevents “everything = 100”)
                    // raw grows with rarity-weighted overlap; exp() curve spreads values nicely
                    $textScore = (int) round($W_TEXT_MAX * (1 - exp(-$raw / 6)));

                    // Bigram/phrase bonus (helps distinguish “kafija karjera” vs “kafija joga”)
                    $bigramHits = 0;
                    foreach ($srcBigrams as $bg => $_) {
                        if (isset($doc['bigrams'][$bg])) $bigramHits++;
                    }
                    $bigramBonus = min($W_BIGRAM_MAX, $bigramHits * 5);

                    // City bonus (strong)
                    $cityBonus = 0;
                    if ($srcCity && $doc['city'] && $srcCity === $doc['city']) {
                        $cityBonus = $W_CITY;
                    }

                    // Category bonus
                    $catBonus = 0;
                    if ($srcCat && $doc['cat'] && $srcCat === $doc['cat']) {
                        $catBonus = $W_CATEGORY;
                    }

                    // Activity-group bonus (strong)
                    $groupBonus = 0;
                    foreach ($srcGroups as $g => $_) {
                        if (isset($doc['groups'][$g])) {
                            $groupBonus = $W_GROUP;
                            break;
                        }
                    }

                    // Time proximity bonus (news/pages/projects -> events)
                    $timeBonus = 0;
                    if ($tType === 'pasakumi' && $doc['date'] && $srcDate) {
                        $days = abs($srcDate->diffInDays($doc['date']));
                        if ($days <= 14) {
                            $timeBonus = (int) round($W_TIME_MAX * (1 - ($days / 14)));
                        }
                    }

                    // Mild penalty for linking to Lapas from non-Lapas
                    $typePenalty = ($tType === 'lapas' && $sourceType !== 'lapas') ? 0.88 : 1.0;

                    $score = (int) round(($textScore + $bigramBonus + $cityBonus + $catBonus + $groupBonus + $timeBonus) * $typePenalty);
                    $score = min(100, $score); // keep UI-friendly

                    if ($score >= $minScore) {
                        $candidates[] = [$tType, $tId, $score];
                    }
                }

                if (!$candidates) continue;

                usort($candidates, fn($a,$b) => $b[2] <=> $a[2]);
                $candidates = array_slice($candidates, 0, $maxPerSource);

                foreach ($candidates as [$tType, $tId, $score]) {
                    $link = SaturaSaite::updateOrCreate(
                        [
                            'avots_tips'  => $sourceType,
                            'avots_id'    => (int)$src->id,
                            'merkis_tips' => $tType,
                            'merkis_id'   => (int)$tId,
                            'tips'        => LinkKind::Automatiskas->value,
                        ],
                        [
                            'review_status'      => LinkReviewStatus::Pending->value,
                            'atbilstibas_punkti' => (int)$score,
                            'izveidoja_user_id'  => null,
                        ]
                    );

                    if ($link->wasRecentlyCreated) $created++;
                }
            }
        }

        return $created;
    }

    private function fullText(string $type, $model): string
    {
        return match ($type) {
            'pasakumi' => trim(($model->nosaukums ?? '').' '.($model->apraksts ?? '').' '.($model->vieta ?? '')),
            'projekti' => trim(($model->nosaukums ?? '').' '.($model->apraksts ?? '')),
            'jaunumi'  => trim(($model->virsraksts ?? '').' '.strip_tags($model->saturs ?? '')),
            'lapas'    => trim(($model->virsraksts ?? '').' '.strip_tags($model->saturs ?? '')),
            default    => '',
        };
    }

    private function tokenSet(string $text): array
    {
        $text = Str::lower($text);
        $text = preg_replace('/[^a-z0-9āčēģīķļņōŗšūž\s-]/ui', ' ', $text) ?? '';
        $parts = preg_split('/\s+/', $text, -1, PREG_SPLIT_NO_EMPTY) ?: [];

        $stop = [
            'un','vai','kas','kā','par','ar','uz','no','ir','tā','tas','tie','šis','šī','pie','bet',
            'lai','mēs','jūs','viņi','viņas','tikai','arī','bez','pēc','pirms','kuru','kura','kurš',
            'pasākums','pasakums','projekts','jaunums','lapa','lapas','galerija','notikums',
        ];

        $set = [];
        foreach ($parts as $w) {
            $w = trim($w, '-');
            if ($w === '') continue;
            if (mb_strlen($w) < 4) continue;
            if (in_array($w, $stop, true)) continue;
            $set[$w] = true;
        }
        return $set;
    }

    private function bigramsFromText(string $text): array
    {
        // Bigram over adjacent words (not sorted) — better phrase signal
        $t = Str::lower($text);
        $t = preg_replace('/[^a-z0-9āčēģīķļņōŗšūž\s-]/ui', ' ', $t) ?? '';
        $words = preg_split('/\s+/', $t, -1, PREG_SPLIT_NO_EMPTY) ?: [];

        $stop = ['un','vai','kas','kā','par','ar','uz','no','ir','tā','tas','tie','šis','šī','pie','bet','lai','mēs','jūs'];

        $clean = [];
        foreach ($words as $w) {
            $w = trim($w, '-');
            if ($w === '' || mb_strlen($w) < 3) continue;
            if (in_array($w, $stop, true)) continue;
            $clean[] = $w;
        }

        $b = [];
        for ($i = 0; $i < count($clean) - 1; $i++) {
            $b[$clean[$i].'_'.$clean[$i+1]] = true;
        }
        return $b;
    }

    private function extractCity(string $type, $model, array $cities, string $text): ?string
    {
        if ($type === 'pasakumi' && !empty($model->vieta)) {
            $v = Str::lower((string)$model->vieta);
            foreach ($cities as $c) {
                if (Str::contains($v, $c)) return $c;
            }
        }

        $t = Str::lower($text);
        foreach ($cities as $c) {
            if (Str::contains($t, $c)) return $c;
        }

        return null;
    }

    private function extractDate(string $type, $model): ?Carbon
    {
        return match ($type) {
            'pasakumi' => !empty($model->norises_datums) ? Carbon::parse($model->norises_datums) : null,
            default    => !empty($model->created_at) ? Carbon::parse($model->created_at) : null,
        };
    }

    private function hitGroups(array $groups, array $tokenSet): array
    {
        $hits = [];
        foreach ($groups as $name => $words) {
            foreach ($words as $w) {
                $w = Str::lower($w);
                if (isset($tokenSet[$w])) {
                    $hits[$name] = true;
                    break;
                }
            }
        }
        return $hits;
    }
}