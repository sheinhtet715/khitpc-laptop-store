<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminInvitationController extends Controller
{
    //  form
    public function showAcceptForm($token)
    {
        // invitation token in the URL
        $invitation = Invitation::where('invitation_token', $token)->firstOrFail();
        return view('auth.accept-invite', compact('invitation'));
    }

    public function processAcceptForm(Request $request, $token)
    {
        $invitation = Invitation::where('invitation_token', $token)->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required|min:8|confirmed'
        ]);

        // Create admin 
        $admin = User::create([
            'name' => $request->name,
            'email' => $invitation->email,
            'password' => Hash::make($request->password),
            'role' => $invitation->role, // Assign role
            'email_verified_at' => now(), 
        ]);

        // not to be used again
        $invitation->delete();
        Auth::login($admin);

        return redirect()->route('admin#home')->with('success', 'Welcome to the Khit PC Admin Panel!');
    }
}
