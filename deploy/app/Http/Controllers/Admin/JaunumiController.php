<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJaunumsRequest;
use App\Http\Requests\UpdateJaunumsRequest;
use App\Models\Jaunums;
use App\Models\Kategorija;
use App\Services\AuditLogger;

class JaunumiController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Jaunums::class, 'jaunumi');
    }

    public function index()
    {
        $jaunumi = Jaunums::query()
            ->with('kategorija')
            ->orderByRaw('publicesanas_datums IS NULL, publicesanas_datums DESC')
            ->latest('id')
            ->paginate(20);

        return view('admin.jaunumi.index', compact('jaunumi'));
    }

    public function create()
    {
        return view('admin.jaunumi.create', [
            'kategorijas' => Kategorija::orderBy('nosaukums')->get(),
        ]);
    }

    public function store(StoreJaunumsRequest $request, AuditLogger $audit)
    {
        $data = $request->validated();
        $publicets = (bool) $request->boolean('publicets');

        // If publishing and publish date missing -> set now (safe default)
        if ($publicets && empty($data['publicesanas_datums'])) {
            $data['publicesanas_datums'] = now()->toDateString();
        }

        $j = Jaunums::create([
            ...$data,
            'publicets' => $publicets,
            'izveidoja_user_id' => $request->user()->id,
        ]);

        $audit->log('admin_jaunumi_store', $j);

        return redirect()->route('admin.jaunumi.index')->with('status', 'Jaunums izveidots.');
    }

    public function edit(Jaunums $jaunumi)
    {
        return view('admin.jaunumi.edit', [
            'jaunums' => $jaunumi,
            'kategorijas' => Kategorija::orderBy('nosaukums')->get(),
        ]);
    }

    public function update(UpdateJaunumsRequest $request, Jaunums $jaunumi, AuditLogger $audit)
    {
        $data = $request->validated();
        $publicets = (bool) $request->boolean('publicets');

        if ($publicets && empty($data['publicesanas_datums']) && empty($jaunumi->publicesanas_datums)) {
            $data['publicesanas_datums'] = now()->toDateString();
        }

        $jaunumi->update([
            ...$data,
            'publicets' => $publicets,
        ]);

        $audit->log('admin_jaunumi_update', $jaunumi);

        return redirect()->route('admin.jaunumi.index')->with('status', 'Jaunums atjaunināts.');
    }

    public function destroy(Jaunums $jaunumi, AuditLogger $audit)
    {
        $jaunumi->delete();
        $audit->log('admin_jaunumi_delete', $jaunumi);

        return redirect()->route('admin.jaunumi.index')->with('status', 'Jaunums dzēsts.');
    }
}