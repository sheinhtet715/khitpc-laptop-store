<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileController extends Controller
{
    //
  public function changePasswordPage()
    {
        return view('admin.profile.changePassword');
    }
    //edit profile page
    public function editProfile()
    {
        return view('admin.profile.edit');
    }

  public function updateProfile(Request $request)
{
    $this->checkProfileValidation($request);

    $data = $this->getProfileData($request); // name, email, phone, address

    if ($request->hasFile('profile_img')) {
        // delete old file if exists
        if (Auth::user()->profile_img) {
            $old = public_path('profile/' . Auth::user()->profile_img);
            if (file_exists($old)) {
                @unlink($old);
            }
        }

        $fileName = uniqid() . '_' . $request->file('profile_img')->getClientOriginalName();
        $request->file('profile_img')->move(public_path('profile'), $fileName);
        $data['profile_img'] = $fileName;
    } else {
        $data['profile_img'] = Auth::user()->profile_img;
    }

    $user = Auth::user();
    $user->update($data);

    Alert::success('Success', 'Profile updated.');
    return back();
}


    //change password
public function changePassword(Request $request)
{

    $this->validatePassword($request);

    $user = Auth::user();

    if (!Hash::check($request->oldPassword, $user->password)) {
        Alert::error('Process Fail', 'Old Password does not match our records. Try again!');
        return back();
    }
    $user->password = Hash::make($request->newPassword);
    $user->save();

    Alert::success('Process Success', 'Password changed successfully!');
    return back();
}


//validation check

private function validatePassword($request)
{
    $request->validate([
        'oldPassword'     => 'required',
        'newPassword'     => 'required|min:6|max:12',
        'confirmPassword' => 'required|min:6|max:12|same:newPassword',
    ], [
        'oldPassword.required' => 'အဟောင်းစကားဝှက်ကို ဖြည့်ရန်လိုအပ်သည်။',
        'newPassword.required' => 'စကားဝှက်အသစ်ကို ဖြည့်ရန်လိုအပ်သည်။',
        'newPassword.min'      => 'စကားဝှက်အသစ်သည် အနည်းဆုံး ၆ လုံး ရှိရမည်။',
        'confirmPassword.min'  => 'အတည်ပြုစကားဝှက်သည် အနည်းဆုံး ၆ လုံး ရှိရမည်။',
        'confirmPassword.same' => 'အတည်ပြုစကားဝှက်သည် စကားဝှက်အသစ်နှင့် တူညီရပါမည်။',
    ]);
}

    //get profile data
private function getProfileData($request)
{
    return [
        'name'    => $request->name,
        'email'   => $request->email,
        'phone'   => $request->phone,
        'address' => $request->address,
    ];
}

    private function checkProfileValidation($request)
    {
        $request->validate([
            'name'    => 'required|min:2|max:30',
            'email'   => 'required|email|unique:users,email,' . Auth::id() . ',user_id',
            'profile_img'   => 'file|mimes:jpg,jpeg,png,gif,webp,svg',
        ]);
    }

}
