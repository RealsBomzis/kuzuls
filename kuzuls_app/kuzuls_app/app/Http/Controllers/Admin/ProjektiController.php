<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjektsRequest;
use App\Http\Requests\UpdateProjektsRequest;
use App\Models\Kategorija;
use App\Models\Projekts;
use App\Services\AuditLogger;

class ProjektiController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Projekts::class, 'projekti');
    }

    public function index()
    {
        $projekti = Projekts::query()
            ->with('kategorija')
            ->latest('id')
            ->paginate(20);

        return view('admin.projekti.index', compact('projekti'));
    }

    public function create()
    {
        return view('admin.projekti.create', [
            'kategorijas' => Kategorija::orderBy('nosaukums')->get(),
        ]);
    }

    public function store(StoreProjektsRequest $request, AuditLogger $audit)
    {
        $p = Projekts::create([
            ...$request->validated(),
            'publicets' => (bool) $request->boolean('publicets'),
            'izveidoja_user_id' => $request->user()->id,
        ]);

        $audit->log('admin_projekti_store', $p);

        return redirect()->route('admin.projekti.index')->with('status', 'Projekts izveidots.');
    }

    public function edit(Projekts $projekti)
    {
        return view('admin.projekti.edit', [
            'projekts' => $projekti,
            'kategorijas' => Kategorija::orderBy('nosaukums')->get(),
        ]);
    }

    public function update(UpdateProjektsRequest $request, Projekts $projekti, AuditLogger $audit)
    {
        $projekti->update([
            ...$request->validated(),
            'publicets' => (bool) $request->boolean('publicets'),
        ]);

        $audit->log('admin_projekti_update', $projekti);

        return redirect()->route('admin.projekti.index')->with('status', 'Projekts atjaunināts.');
    }

    public function destroy(Projekts $projekti, AuditLogger $audit)
    {
        $projekti->delete();
        $audit->log('admin_projekti_delete', $projekti);

        return redirect()->route('admin.projekti.index')->with('status', 'Projekts dzēsts.');
    }
}