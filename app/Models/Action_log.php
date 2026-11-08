<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Action_log extends Model
{
  protected $table = 'action_logs';

    protected $primaryKey = 'action_log_id';
    public $incrementing = true; 
    protected $keyType = 'int';

    protected $fillable = [
        'user_id',
        'product_id',
        'action',
    ];

  
    public $timestamps = true;
}
