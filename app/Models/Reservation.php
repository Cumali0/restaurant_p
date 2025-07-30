<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    // Veritabanında hangi alanlara toplu veri eklenebilir
    protected $fillable = [
        'name',
        'surname',
        'datetime',
        'people',
        'message'
    ];

}
