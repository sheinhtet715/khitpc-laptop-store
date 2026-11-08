<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restock_alerts extends Model
{
    protected $primaryKey = 'alert_id';
    protected $fillable = [
        'user_id',
        'product_id',
        'notified',
        'notification_message',
        'is_read',
    ];
}
