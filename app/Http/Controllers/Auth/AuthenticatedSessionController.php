<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{

    public function create(): View
    {
        return view('authentication.login');
    }


public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate();
    $request->session()->regenerate();

    $role = $request->user()->role;

    if ($role === 'admin' || $role === 'superadmin') {
        return to_route('admin#home');
    }

    if ($role === 'user') {
        return to_route('home');
    }


    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return to_route('login')->withErrors([
        'email' => 'Your account does not have a valid access role.'
    ]);
}


    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
