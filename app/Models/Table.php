<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
use HasFactory;

protected $fillable = ['name', 'capacity', 'status', 'floor'];

// Bir masa birden fazla rezervasyona sahip olabilir
public function reservations()
{
return $this->belongsToMany(Reservation::class, 'reservation_table');
}
}
