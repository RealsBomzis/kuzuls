<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Pasakums, Projekts, Jaunums, Galerija, KontaktZinojums, SaturaSaite};
use App\Enums\LinkReviewStatus;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'counts' => [
                'pasakumi' => Pasakums::count(),
                'projekti' => Projekts::count(),
                'jaunumi' => Jaunums::count(),
                'galerijas' => Galerija::count(),
                'kontakt_jauni' => KontaktZinojums::where('statuss','jauns')->count(),
                'saites_pending' => SaturaSaite::where('review_status', LinkReviewStatus::Pending->value)->count(),
            ]
        ]);
    }
}