<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order_items extends Model
{
    //
    protected $primaryKey = 'order_item_id';
    protected $fillable = [
        'order_id',
        'product_id',
        'boughtquantity',
    ];


    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id', 'product_id');
    }
}
