<?php

namespace App\Support;

use App\Models\{Jaunums, Lapa, Pasakums, Projekts};

class ContentLinkResolver
{
    public static function title(string $type, int $id): ?string
    {
        return match ($type) {
            'pasakumi' => Pasakums::whereKey($id)->value('nosaukums'),
            'projekti' => Projekts::whereKey($id)->value('nosaukums'),
            'jaunumi'  => Jaunums::whereKey($id)->value('virsraksts'),
            'lapas'    => Lapa::whereKey($id)->value('virsraksts'),
            default    => null,
        };
    }

    public static function publicUrl(string $type, int $id): ?string
    {
        // These route names must exist in your public routes
        return match ($type) {
            'pasakumi' => route('public.pasakumi.show', $id),
            'projekti' => route('public.projekti.show', $id),
            'jaunumi'  => route('public.jaunumi.show', $id),
            'lapas'    => optional(Lapa::find($id))->slug
                ? route('public.page.show', Lapa::find($id)->slug)
                : null,
            default    => null,
        };
    }
}