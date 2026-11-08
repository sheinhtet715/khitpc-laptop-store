<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment_methods extends Model
{
    //
    protected $primaryKey = 'payment_method_id';
    protected $fillable = [
        'account_number',
        'account_name',
        'account_type',
    ];
    protected $table = 'payment_methods';
}
