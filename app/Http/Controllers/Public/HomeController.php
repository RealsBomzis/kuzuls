<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\{Jaunums, Pasakums, Projekts, Galerija};
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $data = Cache::remember('home:blocks', 60, function () {
            return [
                'jaunumi' => Jaunums::query()
                    ->published()
                    ->orderByDesc('publicesanas_datums')
                    ->limit(3)
                    ->get(),

                'pasakumi' => Pasakums::query()
                    ->published()
                    ->whereDate('norises_datums', '>=', Carbon::today())
                    ->orderBy('norises_datums')
                    ->orderBy('sakuma_laiks')
                    ->limit(6)
                    ->get(),

                'projekti' => Projekts::query()
                    ->published()
                    ->orderByDesc('sakuma_datums')
                    ->limit(3)
                    ->get(),

                'galerijas' => Galerija::query()
                    ->published()
                    ->latest('id')
                    ->limit(3)
                    ->get(),
            ];
        });

        return view('public.home', $data);
    }
}