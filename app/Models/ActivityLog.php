<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ActivityLog extends Model
{
    protected $fillable = ['user_id', 'action', 'description'];

    public function user()
    {

        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public static function log($action, $description)
    {
        if (Auth::check()) {
            self::create([
                'user_id' => Auth::id(), 
                'action' => $action,
                'description' => $description
            ]);
        }
    }
}
