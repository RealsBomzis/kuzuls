<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galerija extends Model
{
    use HasFactory;

    protected $table = 'galerijas';

    protected $fillable = [
        'nosaukums','apraksts','kategorija_id','saistita_tips','saistita_id','publicets',
    ];

    protected $casts = [
        'publicets' => 'boolean',
    ];

    public function kategorija()
    {
        return $this->belongsTo(Kategorija::class, 'kategorija_id');
    }

    public function atteli()
    {
        return $this->hasMany(GalerijasAttels::class, 'galerija_id')->orderBy('seciba');
    }

    public function scopePublished($q)
    {
        return $q->where('publicets', 1);
    }
}