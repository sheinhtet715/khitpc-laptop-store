<?php

namespace App\Models;

use App\Models\User;
use App\Models\Products;
use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    protected $primaryKey = 'review_id';

    protected $fillable = [
        'user_id',
        'product_id',
        'rating',
        'review_text',
        'is_featured'
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }


    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id', 'product_id');
    }
}
