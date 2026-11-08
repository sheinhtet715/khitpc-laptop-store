<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentImages extends Model
{
    //
        protected $primaryKey = 'payment_image_id';
    protected $fillable = [
        'receipt_id',
        'payimages',
];
}
