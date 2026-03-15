<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\{Pasakums, Galerija};
use Illuminate\Http\Request;

class PublicPasakumiController extends Controller
{
    public function index(Request $request)
    {
        $q = Pasakums::query()->published()->with('kategorija');

        if ($s = trim((string)$request->get('q'))) {
            $q->where(function ($w) use ($s) {
                $w->where('nosaukums', 'like', "%{$s}%")
                  ->orWhere('apraksts', 'like', "%{$s}%")
                  ->orWhere('vieta', 'like', "%{$s}%");
            });
        }

        if ($cat = $request->integer('kategorija_id')) {
            $q->where('kategorija_id', $cat);
        }

        $sort = $request->get('sort', 'date_asc');
        $q->when($sort === 'date_desc', fn($qq) => $qq->orderByDesc('norises_datums'))
          ->when($sort !== 'date_desc', fn($qq) => $qq->orderBy('norises_datums'));

        $pasakumi = $q->paginate(12)->withQueryString();

        return view('public.pasakumi.index', compact('pasakumi'));
    }

    public function show(Pasakums $pasakums)
    {
        abort_unless($pasakums->publicets, 404);

        $galerija = Galerija::query()
            ->published()
            ->with('atteli')
            ->where('saistita_tips', 'pasakumi')
            ->where('saistita_id', $pasakums->id)
            ->first();

        return view('public.pasakumi.show', [
            'pasakums' => $pasakums->load('kategorija'),
            'galerija' => $galerija,
        ]);
    }
}