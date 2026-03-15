<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGalerijaRequest;
use App\Http\Requests\UpdateGalerijaRequest;
use App\Models\Galerija;
use App\Models\Jaunums;
use App\Models\Kategorija;
use App\Models\Pasakums;
use App\Models\Projekts;
use App\Services\AuditLogger;

class GalerijasController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Galerija::class, 'galerija');
    }

    public function index()
    {
        $galerijas = Galerija::query()
            ->with('kategorija')
            ->withCount('atteli')
            ->latest('id')
            ->paginate(20);

        return view('admin.galerijas.index', compact('galerijas'));
    }

    public function create()
    {
        return view('admin.galerijas.create', [
            'kategorijas' => Kategorija::orderBy('nosaukums')->get(),
            'pasakumi' => Pasakums::orderByDesc('norises_datums')->get(['id','nosaukums']),
            'projekti' => Projekts::orderByDesc('id')->get(['id','nosaukums']),
            'jaunumi' => Jaunums::orderByDesc('publicesanas_datums')->get(['id','virsraksts']),
        ]);
    }

    public function store(StoreGalerijaRequest $request, AuditLogger $audit)
    {
        $galerija = Galerija::create([
            ...$request->validated(),
            'publicets' => (bool) $request->boolean('publicets'),
        ]);

        $audit->log('admin_galerijas_store', $galerija);

        return redirect()
            ->route('admin.galerijas.edit', $galerija)
            ->with('status', 'Galerija izveidota. Tagad var pievienot attēlus.');
    }

    public function edit(Galerija $galerija)
    {
        return view('admin.galerijas.edit', [
            'galerija' => $galerija->load('atteli'),
            'kategorijas' => Kategorija::orderBy('nosaukums')->get(),
            'pasakumi' => Pasakums::orderByDesc('norises_datums')->get(['id','nosaukums']),
            'projekti' => Projekts::orderByDesc('id')->get(['id','nosaukums']),
            'jaunumi' => Jaunums::orderByDesc('publicesanas_datums')->get(['id','virsraksts']),
        ]);
    }

    public function update(UpdateGalerijaRequest $request, Galerija $galerija, AuditLogger $audit)
    {
        $galerija->update([
            ...$request->validated(),
            'publicets' => (bool) $request->boolean('publicets'),
        ]);

        $audit->log('admin_galerijas_update', $galerija);

        return back()->with('status', 'Galerija atjaunināta.');
    }

    public function destroy(Galerija $galerija, AuditLogger $audit)
    {
        $galerija->delete();

        $audit->log('admin_galerijas_delete', $galerija);

        return redirect()
            ->route('admin.galerijas.index')
            ->with('status', 'Galerija dzēsta.');
    }
}