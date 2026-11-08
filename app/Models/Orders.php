<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{

    protected $primaryKey = 'order_id';
    protected $fillable = [
        'user_id',
        'discount_code_id',
        'total_amount',
        'payment_status',
    ];

    public function orderItems()
    {

        return $this->hasMany(Order_items::class, 'order_id', 'order_id');
    }

    public function receipt()
    {
        return $this->hasOne(Receipts::class, 'order_id', 'order_id');
    }

public function user()
{

    return $this->belongsTo(\App\Models\User::class, 'user_id', 'user_id');
}

}
