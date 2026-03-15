<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasakums extends Model
{
    use HasFactory;

    protected $table = 'pasakumi';

protected $fillable = [
    'nosaukums',
    'apraksts',
    'norises_datums',
    'sakuma_laiks',
    'beigu_laiks',
    'vieta',
    'kategorija_id',
    'publicets',
    'izveidoja_user_id',
    'attels',
    'talrunis',
    'epasts',
];
    protected $casts = [
        'publicets' => 'boolean',
        'norises_datums' => 'date',
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