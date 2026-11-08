<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart_items extends Model
{
   protected $primaryKey = 'cart_item_id';
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
    ];
}
