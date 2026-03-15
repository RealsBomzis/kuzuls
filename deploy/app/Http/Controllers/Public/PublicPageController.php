<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Lapa;

class PublicPageController extends Controller
{
    public function show(string $slug)
    {
        $lapa = Lapa::query()
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        return view('public.pages.show', [
            'lapa' => $lapa->load('kategorija'),
        ]);
    }
}