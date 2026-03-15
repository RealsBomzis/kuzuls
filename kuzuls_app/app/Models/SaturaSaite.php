<?php

namespace App\Models;

use App\Enums\LinkKind;
use App\Enums\LinkReviewStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaturaSaite extends Model
{
    use HasFactory;

    protected $table = 'satura_saites';

    protected $fillable = [
        'avots_tips','avots_id','merkis_tips','merkis_id',
        'tips','atbilstibas_punkti','izveidoja_user_id',
        'review_status',
    ];

    protected $casts = [
        'tips' => LinkKind::class,
        'review_status' => LinkReviewStatus::class,
    ];

    public function scopeApprovedAuto($q)
    {
        return $q->where('tips', LinkKind::Automatiskas->value)
                 ->where('review_status', LinkReviewStatus::Approved->value);
    }
}