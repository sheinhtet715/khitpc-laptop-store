<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    protected $primaryKey = 'notification_id';
    protected $fillable = [
        'user_id',
        'alert_id',
        'message',
    ];
}
