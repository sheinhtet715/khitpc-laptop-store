<?php

namespace App\Models;

use App\Models\Products;
use Illuminate\Database\Eloquent\Model;

class Offers extends Model
{
    protected $primaryKey = 'offer_id';
    protected $fillable = [
        'title',
        'discount_percent',
        'product_id',
    ];
    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id', 'product_id');
    }

}
