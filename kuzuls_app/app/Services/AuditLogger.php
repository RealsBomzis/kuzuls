<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuditLogger
{
    public function log(string $action, ?Model $object = null, array $extra = []): void
    {
        $req = app(Request::class);

        AuditLog::create([
            'user_id' => Auth::id(),
            'darbiba' => $action,
            'objekta_tips' => $this->mapType($object),
            'objekta_id' => $object?->getKey(),
            'ip_adrese' => $req->ip(),
            'lietotaja_agents' => substr((string) $req->userAgent(), 0, 255),
            'papildu_dati' => $extra ?: null,
            'created_at' => now(),
        ]);
    }

    private function mapType(?Model $m): string
    {
        return match (true) {
            $m === null => 'cits',
            $m->getTable() === 'pasakumi' => 'pasakumi',
            $m->getTable() === 'projekti' => 'projekti',
            $m->getTable() === 'jaunumi' => 'jaunumi',
            $m->getTable() === 'galerijas' => 'galerijas',
            $m->getTable() === 'lapas' => 'lapas',
            $m->getTable() === 'kontakt_zinojumi' => 'kontakt_zinojumi',
            $m->getTable() === 'users' => 'lietotaji',
            default => 'cits',
        };
    }
}