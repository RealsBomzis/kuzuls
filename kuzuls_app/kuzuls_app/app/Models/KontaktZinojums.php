<?php

namespace App\Models;

use App\Enums\ContactStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KontaktZinojums extends Model
{
    use HasFactory;

    protected $table = 'kontakt_zinojumi';

    // ✅ allow Laravel to manage created_at/updated_at
    public $timestamps = true;

    protected $fillable = [
        'vards','epasts','tema','zinojums','statuss',
    ];

    protected $casts = [
        'statuss' => ContactStatus::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}