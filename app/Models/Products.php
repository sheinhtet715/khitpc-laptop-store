<?php

namespace App\Models;

use App\Models\Brands;
use App\Models\Offers;
use App\Models\Reviews;
use App\Models\Action_log;
use App\Models\Categories;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'product_id'; 
    public $incrementing = true; 
    protected $keyType = 'int'; 
    protected $fillable = [
        'sku',
        'product_name',
        'product_description',
        'product_price',
        'product_image',
        'brand_id',
        'category_id',
        'spec_id',
        'offer_id',
        'stock_quantity',
    ];

    public function offers()
{
    return $this->hasMany(Offers::class, 'product_id', 'product_id');
}

public function reviews()
{
    return $this->hasMany(Reviews::class, 'product_id', 'product_id');
}
public function actionLogs()
{
    return $this->hasMany(Action_log::class, 'product_id', 'product_id');
}

}

