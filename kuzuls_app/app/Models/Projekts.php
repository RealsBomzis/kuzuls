<?php

namespace App\Models;

use App\Enums\ProjectStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projekts extends Model
{
    use HasFactory;

    protected $table = 'projekti';

    protected $fillable = [
        'nosaukums','apraksts','statuss','sakuma_datums','beigu_datums',
        'kategorija_id','publicets','izveidoja_user_id',
    ];

    protected $casts = [
        'publicets' => 'boolean',
        'sakuma_datums' => 'date',
        'beigu_datums' => 'date',
        'statuss' => ProjectStatus::class,
    ];

    public function kategorija()
    {
        return $this->belongsTo(Kategorija::class, 'kategorija_id');
    }

    public function scopePublished($q)
    {
        return $q->where('publicets', 1);
    }
}