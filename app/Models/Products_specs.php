<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products_specs extends Model
{
    protected $primaryKey = 'spec_id';
    protected $fillable = [
        'Processor',
        'Model',
        'Display',
        'Battery',
        'Warranty',
        'Ram',
        'Graphics_Card',
        'System_type',
        'Pen_and_touch',
        'Storage'
    ];
}
