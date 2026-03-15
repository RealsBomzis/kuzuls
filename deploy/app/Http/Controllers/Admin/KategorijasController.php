<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategorija;
use App\Services\AuditLogger;
use Illuminate\Http\Request;

class KategorijasController extends Controller
{
    public function __construct()
    {
        // ✅ MUST match route param name: {kategorija}
        $this->authorizeResource(Kategorija::class, 'kategorija');
    }

    public function index()
    {
        $kategorijas = Kategorija::query()
            ->orderBy('tips')
            ->orderBy('nosaukums')
            ->paginate(30);

        return view('admin.kategorijas.index', compact('kategorijas'));
    }

    public function create()
    {
        return view('admin.kategorijas.create');
    }

    public function store(Request $request, AuditLogger $audit)
    {
        $data = $request->validate([
            'nosaukums' => ['required','string','min:2','max:120','unique:kategorijas,nosaukums'],
            'tips' => ['required','in:pasakumi,projekti,jaunumi,galerijas,lapas,visiem'],
        ]);

        $kategorija = Kategorija::create($data);
        $audit->log('admin_kategorijas_store', $kategorija);

        return redirect()->route('admin.kategorijas.index')->with('status', 'Kategorija izveidota.');
    }

    public function edit(Kategorija $kategorija)
    {
        return view('admin.kategorijas.edit', compact('kategorija'));
    }

    public function update(Request $request, Kategorija $kategorija, AuditLogger $audit)
    {
        $data = $request->validate([
            'nosaukums' => ['required','string','min:2','max:120','unique:kategorijas,nosaukums,'.$kategorija->id],
            'tips' => ['required','in:pasakumi,projekti,jaunumi,galerijas,lapas,visiem'],
        ]);

        $kategorija->update($data);
        $audit->log('admin_kategorijas_update', $kategorija);

        return redirect()->route('admin.kategorijas.index')->with('status', 'Kategorija atjaunināta.');
    }

    public function destroy(Kategorija $kategorija, AuditLogger $audit)
    {
        $kategorija->delete();
        $audit->log('admin_kategorijas_delete', $kategorija);

        return redirect()->route('admin.kategorijas.index')->with('status', 'Kategorija dzēsta.');
    }
}