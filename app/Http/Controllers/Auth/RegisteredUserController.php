<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\OtpVerificationMail; // Add this!

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('authentication.register');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email:rfc,dns', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);


        $otp = rand(100000, 999999);
        Cache::put('registration_' . $request->email, [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'otp' => $otp
        ], now()->addMinutes(15));

        Mail::to($request->email)->send(new OtpVerificationMail($otp));
        session(['pending_registration_email' => $request->email]);

        return redirect()->route('otp.show');
    }


    public function showOtpForm()
    {
        if (!session('pending_registration_email')) {
            return redirect()->route('register');
        }
        return view('authentication.verify-otp');
    }


    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|numeric|digits:6']);

        $email = session('pending_registration_email');
        $cachedData = Cache::get('registration_' . $email);

        if (!$cachedData || $cachedData['otp'] != $request->otp) {
            return back()->withErrors(['otp' => 'Invalid or expired verification code.']);
        }

        $user = User::create([
            'name' => $cachedData['name'],
            'email' => $cachedData['email'],
            'password' => $cachedData['password'],
            'email_verified_at' => now(), 
        ]);

        Cache::forget('registration_' . $email);
        session()->forget('pending_registration_email');

        Auth::login($user);
        return redirect()->route('home'); 
    }
}
