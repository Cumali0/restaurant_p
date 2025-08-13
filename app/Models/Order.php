<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_id',
        'menu_id',
        'quantity',
        'price',
        'total_price',
        'order_status',
    ];

    // Reservation ile ilişki
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    // Menu ile ilişki
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
