<?php

namespace App\Providers;

use App\Models\Restock_alerts;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
public function boot()
{
   View::composer('*', function ($view) {

        $user = Auth::user();
        $avatar = asset('default/default_image.webp');

        if ($user && $user->profile_img) {
            if (filter_var($user->profile_img, FILTER_VALIDATE_URL)) {
                $avatar = $user->profile_img;
            } elseif (file_exists(public_path('profile/' . $user->profile_img))) {
                $avatar = asset('profile/' . $user->profile_img);
            }
        }

        if ($user) {
            $userId = $user->user_id;

            $unreadCount = Restock_alerts::where('user_id', $userId)
                ->where('notified', true)
                ->whereIn('is_read', [false, 0])
                ->count();

            $alerts = Restock_alerts::where('user_id', $userId)
                ->where('notified', true)
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();

            $view->with([
                'unreadCount'    => (int) $unreadCount,
                'hasUnread'      => $unreadCount > 0,
                'alerts'         => $alerts,
                'authUserAvatar' => $avatar, 
            ]);
        } else {
            $view->with([
                'unreadCount'    => 0,
                'hasUnread'      => false,
                'alerts'         => collect(),
                'authUserAvatar' => $avatar, 
            ]);
        }
    });

    Paginator::useBootstrapFive();
}

}
