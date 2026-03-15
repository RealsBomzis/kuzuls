<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalerijasAttels extends Model
{
    use HasFactory;

    protected $table = 'galerijas_atteli';

    protected $fillable = [
        'galerija_id','fails_cels','alt_teksts','seciba',
    ];

    public $timestamps = false;

    public function galerija()
    {
        return $this->belongsTo(Galerija::class, 'galerija_id');
    }
}