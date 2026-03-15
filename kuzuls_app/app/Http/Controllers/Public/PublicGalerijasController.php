<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Galerija;
use Illuminate\Http\Request;

class PublicGalerijasController extends Controller
{
    public function index(Request $request)
    {
        $q = Galerija::query()
            ->published()
            ->withCount('atteli')
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

        // Sorting: newest first is a safe default
        $sort = $request->get('sort', 'newest');
        if ($sort === 'oldest') {
            $q->orderBy('id');
        } else {
            $q->orderByDesc('id');
        }

        $galerijas = $q->paginate(12)->withQueryString();

        return view('public.galerijas.index', compact('galerijas'));
    }

    public function show(Galerija $galerija)
    {
        abort_unless($galerija->publicets, 404);

        return view('public.galerijas.show', [
            'galerija' => $galerija->load(['kategorija', 'atteli']),
        ]);
    }
}