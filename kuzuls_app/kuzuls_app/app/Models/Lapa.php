<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lapa extends Model
{
    use HasFactory;

    protected $table = 'lapas';

    protected $fillable = [
        'slug','virsraksts','saturs','kategorija_id','publicets',
    ];

    protected $casts = [
        'publicets' => 'boolean',
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