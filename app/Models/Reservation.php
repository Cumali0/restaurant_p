<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'table_id',
        'name',
        'surname',
        'email',
        'datetime',
        'end_datetime',
        'people',
        'message',
        'status',
        'total_price',
        'preorder_token'
    ];

    protected $casts = [
        'datetime' => 'datetime',
        'end_datetime' => 'datetime',
    ];
    public function tables()
    {
        return $this->belongsToMany(Table::class, 'reservation_table');
    }

    public const STATUS_PENDING = 'pending';
    public const STATUS_RESERVED = 'reserved';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';


    public function orders() {
        return $this->hasMany(Order::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function cart(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Cart::class);
    }



}



