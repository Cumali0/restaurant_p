<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    // Veritabanında hangi alanlara toplu veri eklenebilir (mass assignment)
    protected $fillable = [
        'name',      // müşteri adı
        'surname',   // müşteri soyadı
        'datetime',  // rezervasyon tarihi ve saati (datetime)
        'people',    // kişi sayısı
        'message',   // ekstra not veya mesaj
        'status',    // rezervasyon durumu (pending, approved, rejected vb.)
    ];
}

