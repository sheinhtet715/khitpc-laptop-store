<?php

namespace App\Models;

use App\Models\PaymentImages;

use App\Models\Discount_codes;
use App\Models\Payment_methods;
use Illuminate\Database\Eloquent\Model;

class Receipts extends Model
{
    //
    protected $primaryKey = 'receipt_id';
    protected $fillable = [
        'order_id',
        'user_id',
        'amount',
        'payment_method_id',
        'discount_code_id',
];

public function paymentImages()
{

    return $this->hasMany(PaymentImages::class, 'receipt_id', 'receipt_id');
}
 
    public function paymentMethod()
    {
        return $this->belongsTo(Payment_methods::class, 'payment_method_id', 'payment_method_id');
    }

   
    public function discountCode()
    {
        return $this->belongsTo(Discount_codes::class, 'discount_code_id', 'discount_code_id');
    }

    public function order()
    {
        return $this->belongsTo(Orders::class, 'order_id', 'order_id');
    }
}
