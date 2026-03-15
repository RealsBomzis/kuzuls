<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;

class AuditLogsController extends Controller
{
    public function index()
    {
        $logs = AuditLog::query()
            ->with('user:id,name,email') // ✅ eager load, select only needed columns
            ->latest('id')
            ->paginate(50);

        return view('admin.audit.index', compact('logs'));
    }
}