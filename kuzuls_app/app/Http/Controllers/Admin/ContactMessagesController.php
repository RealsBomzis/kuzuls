<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KontaktZinojums;
use App\Services\AuditLogger;

class ContactMessagesController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', KontaktZinojums::class);

        $zinojumi = KontaktZinojums::query()
            ->orderByRaw("FIELD(statuss,'jauns','apstradats')")
            ->orderByDesc('created_at')
            ->paginate(30);

        return view('admin.kontakt.index', compact('zinojumi'));
    }

    public function markProcessed(KontaktZinojums $zinojums, AuditLogger $audit)
    {
        $this->authorize('update', KontaktZinojums::class);

        $zinojums->update(['statuss' => 'apstradats']);

        $audit->log('admin_kontakt_mark_processed', $zinojums);

        return back()->with('status', 'Ziņojums atzīmēts kā apstrādāts.');
    }
}