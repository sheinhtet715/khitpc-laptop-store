<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brands extends Model
{
    protected $primaryKey = 'brand_id';
    protected $fillable = [
        'brand_name',
        'brand_description',
    ];
}
