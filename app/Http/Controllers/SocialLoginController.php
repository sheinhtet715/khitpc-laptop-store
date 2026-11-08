<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;


class SocialLoginController extends Controller
{
    //
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

   public function callback($provider)
{
    $social = Socialite::driver($provider)->user();


    $email = $social->getEmail();
    $providerId = $social->getId();

    $user = User::where('provider', $provider)
                ->where('provider_id', $providerId)
                ->first();

    if (! $user && $email) {
        $user = User::where('email', $email)->first();
    }

    if (! $user) {
        $user = User::create([
            'name'            => $social->getName() ?? $social->getNickname() ?? 'No name',
            'email'           => $email,
            'nickname'        => $social->getNickname(),
            'profile_img'     => $social->getAvatar(),
            'provider'        => $provider,
            'provider_id'     => $providerId,
            'provider_token'  => $social->token ?? null,
            'role'            => 'user',
            'password'        => null, 
        ]);
    } else {
       
        $user->update([
            'name'           => $user->name ?: ($social->getName() ?? $social->getNickname()),
            'nickname'       => $user->nickname ?: $social->getNickname(),
            'profile_img'    => $social->getAvatar() ?? $user->profile_img,
            'provider'       => $provider,
            'provider_id'    => $providerId,
            'provider_token' => $social->token ?? $user->provider_token,
        ]);
    }

    Auth::login($user, true);

    return to_route('home');
}

}


