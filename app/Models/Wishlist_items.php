<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist_items extends Model
{
   protected $primaryKey = 'wishlist_id';
    protected $fillable = [
        'user_id',
        'product_id',
    ];
}
