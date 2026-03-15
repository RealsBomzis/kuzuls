<?php

namespace App\Observers;

use App\Services\{AuditLogger, SaturaSaisuDzinis};
use Illuminate\Database\Eloquent\Model;

class ContentObserver
{
    public function __construct(
        private AuditLogger $audit,
        private SaturaSaisuDzinis $links,
    ) {}

    public function created(Model $model): void
    {
        $this->audit->log('created', $model);
        $this->maybeSuggestLinks($model);
    }

    public function updated(Model $model): void
    {
        $this->audit->log('updated', $model);
        $this->maybeSuggestLinks($model);
    }

    public function deleted(Model $model): void
    {
        $this->audit->log('deleted', $model);
    }

    private function maybeSuggestLinks(Model $model): void
    {
        // Only generate on published content to avoid junk suggestions
        if (property_exists($model, 'publicets') && (bool)$model->publicets === true) {
            $this->links->generateSuggestionsFor($model);
        }
    }
}