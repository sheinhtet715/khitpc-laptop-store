<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discount_codes extends Model
{
    //
    protected $primaryKey = 'discount_code_id';
    protected $fillable = [
        'code',
        'discount_percent',
        'usage_limit',
    ];
}
