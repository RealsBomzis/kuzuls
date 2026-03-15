<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\{Jaunums, Pasakums, Projekts, Galerija};
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        $data = Cache::remember('home:blocks', 60, function () {
            return [
                'jaunumi' => Jaunums::query()->published()->orderByDesc('publicesanas_datums')->limit(3)->get(),
                'pasakumi' => Pasakums::query()->published()->orderBy('norises_datums')->limit(3)->get(),
                'projekti' => Projekts::query()->published()->orderByDesc('sakuma_datums')->limit(3)->get(),
                'galerijas' => Galerija::query()->published()->latest('id')->limit(3)->get(),
            ];
        });

        return view('public.home', $data);
    }
}