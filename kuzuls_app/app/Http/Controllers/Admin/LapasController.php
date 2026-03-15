<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLapaRequest;
use App\Http\Requests\UpdateLapaRequest;
use App\Models\Kategorija;
use App\Models\Lapa;
use App\Services\AuditLogger;

class LapasController extends Controller
{
    public function __construct()
    {
        // ✅ MUST match route parameter name: {lapa}
        $this->authorizeResource(Lapa::class, 'lapa');
    }

    public function index()
    {
        $lapas = Lapa::query()
            ->with('kategorija')
            ->latest('id')
            ->paginate(20);

        return view('admin.lapas.index', compact('lapas'));
    }

    public function create()
    {
        return view('admin.lapas.create', [
            'kategorijas' => Kategorija::orderBy('nosaukums')->get(),
        ]);
    }

    public function store(StoreLapaRequest $request, AuditLogger $audit)
    {
        $lapa = Lapa::create([
            ...$request->validated(),
            'publicets' => (bool) $request->boolean('publicets'),
        ]);

        $audit->log('admin_lapas_store', $lapa);

        // ✅ better UX: redirect to edit so you can continue editing immediately
        return redirect()
            ->route('admin.lapas.edit', $lapa)
            ->with('status', 'Lapa izveidota.');
    }

    public function edit(Lapa $lapa)
    {
        return view('admin.lapas.edit', [
            'lapa' => $lapa,
            'kategorijas' => Kategorija::orderBy('nosaukums')->get(),
        ]);
    }

    public function update(UpdateLapaRequest $request, Lapa $lapa, AuditLogger $audit)
    {
        $lapa->update([
            ...$request->validated(),
            'publicets' => (bool) $request->boolean('publicets'),
        ]);

        $audit->log('admin_lapas_update', $lapa);

        return redirect()
            ->route('admin.lapas.index')
            ->with('status', 'Lapa atjaunināta.');
    }

    public function destroy(Lapa $lapa, AuditLogger $audit)
    {
        $lapa->delete();
        $audit->log('admin_lapas_delete', $lapa);

        return redirect()
            ->route('admin.lapas.index')
            ->with('status', 'Lapa dzēsta.');
    }
}