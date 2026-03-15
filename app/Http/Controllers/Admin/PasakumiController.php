<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\{StorePasakumsRequest, UpdatePasakumsRequest};
use App\Models\{Kategorija, Pasakums};
use App\Services\AuditLogger;
use Illuminate\Support\Facades\Storage;

class PasakumiController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Pasakums::class, 'pasakumi');
    }

    public function index()
    {
        $pasakumi = Pasakums::query()->with('kategorija')->latest('id')->paginate(20);
        return view('admin.pasakumi.index', compact('pasakumi'));
    }

    public function create()
    {
        return view('admin.pasakumi.create', [
            'kategorijas' => Kategorija::orderBy('nosaukums')->get(),
        ]);
    }

    public function store(StorePasakumsRequest $request, AuditLogger $audit)
    {
        $data = $request->validated();

        if ($request->hasFile('attels')) {
            $data['attels'] = $request->file('attels')->store('pasakumi', 'public');
        }

        $p = Pasakums::create([
            ...$data,
            'publicets' => (bool)$request->boolean('publicets'),
            'izveidoja_user_id' => $request->user()->id,
        ]);

        $audit->log('admin_pasakumi_store', $p);

        return redirect()->route('admin.pasakumi.index')->with('status', 'Pasākums izveidots.');
    }

    public function edit(Pasakums $pasakumi)
    {
        return view('admin.pasakumi.edit', [
            'pasakums' => $pasakumi,
            'kategorijas' => Kategorija::orderBy('nosaukums')->get(),
        ]);
    }

    public function update(UpdatePasakumsRequest $request, Pasakums $pasakumi, AuditLogger $audit)
    {
        $data = $request->validated();

        if ($request->hasFile('attels')) {
            // delete old file if exists
            if (!empty($pasakumi->attels) && Storage::disk('public')->exists($pasakumi->attels)) {
                Storage::disk('public')->delete($pasakumi->attels);
            }

            $data['attels'] = $request->file('attels')->store('pasakumi', 'public');
        }

        $pasakumi->update([
            ...$data,
            'publicets' => (bool)$request->boolean('publicets'),
        ]);

        $audit->log('admin_pasakumi_update', $pasakumi);

        return redirect()->route('admin.pasakumi.index')->with('status', 'Pasākums atjaunināts.');
    }

    public function destroy(Pasakums $pasakumi, AuditLogger $audit)
    {
        if (!empty($pasakumi->attels) && Storage::disk('public')->exists($pasakumi->attels)) {
            Storage::disk('public')->delete($pasakumi->attels);
        }

        $pasakumi->delete();
        $audit->log('admin_pasakumi_delete', $pasakumi);

        return redirect()->route('admin.pasakumi.index')->with('status', 'Pasākums dzēsts.');
    }
}