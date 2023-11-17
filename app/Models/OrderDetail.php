<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'total',
        'user_id',
        'payment_details',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
