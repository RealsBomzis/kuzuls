<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jaunums extends Model
{
    use HasFactory;

    protected $table = 'jaunumi';

    protected $fillable = [
        'virsraksts','ievads','saturs','kategorija_id','publicets','publicesanas_datums','izveidoja_user_id',
    ];

    protected $casts = [
        'publicets' => 'boolean',
        'publicesanas_datums' => 'date',
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