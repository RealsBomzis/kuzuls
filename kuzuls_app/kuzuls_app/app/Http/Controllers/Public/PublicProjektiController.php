<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Projekts;
use Illuminate\Http\Request;

class PublicProjektiController extends Controller
{
    public function index(Request $request)
    {
        $q = Projekts::query()
            ->published()
            ->with('kategorija');

        if ($s = trim((string) $request->get('q'))) {
            $q->where(function ($w) use ($s) {
                $w->where('nosaukums', 'like', "%{$s}%")
                  ->orWhere('apraksts', 'like', "%{$s}%");
            });
        }

        if ($cat = $request->integer('kategorija_id')) {
            $q->where('kategorija_id', $cat);
        }

        if ($status = $request->get('statuss')) {
            if (in_array($status, ['planots', 'aktivs', 'pabeigts'], true)) {
                $q->where('statuss', $status);
            }
        }

        $sort = $request->get('sort', 'start_desc');
        match ($sort) {
            'start_asc' => $q->orderBy('sakuma_datums'),
            'end_asc' => $q->orderByRaw('beigu_datums IS NULL, beigu_datums ASC'),
            'end_desc' => $q->orderByRaw('beigu_datums IS NULL, beigu_datums DESC'),
            default => $q->orderByDesc('sakuma_datums'),
        };

        $projekti = $q->paginate(12)->withQueryString();

        return view('public.projekti.index', compact('projekti'));
    }

    public function show(Projekts $projekts)
    {
        abort_unless($projekts->publicets, 404);

        return view('public.projekti.show', [
            'projekts' => $projekts->load('kategorija'),
        ]);
    }
}