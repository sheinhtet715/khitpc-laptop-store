<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
   protected $primaryKey = 'comment_id';
    protected $fillable = [
        'user_id',
        'product_id',
        'message',
    ];
}
