<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Galerija;
use App\Models\Jaunums;
use Illuminate\Http\Request;

class PublicJaunumiController extends Controller
{
    public function index(Request $request)
    {
        $q = Jaunums::query()
            ->published()
            ->with('kategorija');

        if ($s = trim((string) $request->get('q'))) {
            $q->where(function ($w) use ($s) {
                $w->where('virsraksts', 'like', "%{$s}%")
                  ->orWhere('ievads', 'like', "%{$s}%")
                  ->orWhere('saturs', 'like', "%{$s}%");
            });
        }

        if ($cat = $request->integer('kategorija_id')) {
            $q->where('kategorija_id', $cat);
        }

        $sort = $request->get('sort', 'newest');

        if ($sort === 'oldest') {
            $q->orderByRaw('publicesanas_datums IS NULL, publicesanas_datums ASC')
              ->orderBy('id');
        } else {
            $q->orderByRaw('publicesanas_datums IS NULL, publicesanas_datums DESC')
              ->orderByDesc('id');
        }

        $jaunumi = $q->paginate(12)->withQueryString();

        return view('public.jaunumi.index', compact('jaunumi'));
    }

    public function show(Jaunums $jaunums)
    {
        abort_unless($jaunums->publicets, 404);

        $galerija = Galerija::query()
            ->published()
            ->with('atteli')
            ->where('saistita_tips', 'jaunumi')
            ->where('saistita_id', $jaunums->id)
            ->first();

        return view('public.jaunumi.show', [
            'jaunums' => $jaunums->load('kategorija'),
            'galerija' => $galerija,
        ]);
    }
}