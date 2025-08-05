<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Table;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'table_id',
        'name',
        'surname',
        'datetime',
        'people',
        'message',
        'status',
    ];

    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    public const STATUS_PENDING = 'pending';
    public const STATUS_RESERVED = 'reserved';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';
}
