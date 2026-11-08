<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Orders;
use App\Models\Reviews;
use App\Models\Products;

use App\Models\Invitation;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Mail\AdminInvitationMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\ActivityLog;

class AdminController extends Controller
{
    //
    public function dashboard()
    {

        $ordersCount = Orders::where('payment_status', 'pending_verification')->count();
        $productsCount = Products::count();
        $customersCount = User::where('role', 'user')->count();

        $recentOrders = Orders::with('user')->orderBy('created_at', 'desc')->take(5)->get();


        $lowStockProducts = Products::where('stock_quantity', '<=', 5)->orderBy('stock_quantity', 'asc')->get();


        return view('admin.dashboard.main', compact(
            'ordersCount',
            'productsCount',
            'customersCount',
            'recentOrders',
            'lowStockProducts'
        ));
    }
    public function createAdminPage()
    {
        return view('admin.account.newAdmin ');
    }

    public function createAdmin(Request $request)
    {
        
        $request->validate([
            'email' => 'required|email|unique:users,email|unique:invitations,email',
            'role' => 'nullable|string' 
        ], [
            'email.required' => 'အီးမေးလ်အကွက် ဖြည့်ရန် လိုအပ်သည်။',
            'email.unique' => 'ဤအီးမေးလ်သည် အသုံးပြုပြီးသား သို့မဟုတ် ဖိတ်ကြားထားပြီးသားဖြစ်သည်။', 
        ]);

        
        $token = Str::random(64);
        $invitation = Invitation::create([
            'email' => $request->email,
            'role' => $request->role ?? 'admin', 
            'invitation_token' => $token
        ]);

        
        Mail::to($request->email)->send(new AdminInvitationMail($invitation));
        Alert::success('Success Title', 'Invitation link sent to ' . $request->email);
        return back();
    }
    public function adminList()
    {
        $admin = User::whereIn('role', ['admin', 'superadmin'])
            ->when(request('searchKey'), function ($query) {
                $query->whereAny(['name', 'email', 'address', 'phone', 'provider', 'role'], 'like', '%' . request('searchKey') . '%');
            })
            ->paginate(4);

        return view('admin.account.adminList', compact('admin'));
    }

    public function changeRole($id)
    {
        $user = User::where('user_id', $id)->firstOrFail();

        if ($user->email === 'superadmin@gmail.com') {
            return back()->with('error', 'Security Alert: The primary Superadmin account cannot be modified.');
        }

        if ($user->email === Auth::user()->email) {
            return back()->with('error', 'Security Alert: You cannot change your own role.');
        }

        $newRole = $user->role === 'admin' ? 'superadmin' : 'admin';

        $user->update([
            'role' => $newRole
        ]);

        ActivityLog::log(
            'Role Changed',
            Auth::user()->name . " changed the role of {$user->name} to " . strtoupper($newRole) . "."
        );

        $action = $newRole === 'superadmin' ? 'promoted to Superadmin' : 'demoted to Admin';
        return back()->with('success', "{$user->name} has been successfully {$action}.");
    }
    public function auditLogs(Request $request) 
    {
      
        $query = ActivityLog::with('user');

        
        if ($request->filled('filter_date')) {
            $query->whereDate('created_at', $request->filter_date);
        }

        
        $logs = $query->orderBy('created_at', 'desc')
            ->paginate(30)
            ->appends($request->query());

        return view('admin.audit.logs', compact('logs'));
    }
    public function adminDelete($id)
    {
        
        $user = User::where('user_id', $id)->firstOrFail();

        
        if ($user->email === 'superadmin@gmail.com') {
            return back()->with('error', 'Security Alert: The primary Superadmin account cannot be deleted.');
        }

      
        if ($id == Auth::id()) {
            return back()->with('error', 'Security Alert: You cannot delete your own account.');
        }

        $user->delete();
        return back()->with('success', 'Admin deleted successfully');
    }
    public function userList()
    {
        
        $user = User::where('role', 'user')
            ->when(request('searchKey'), function ($query) {
                $query->whereAny(['name', 'email', 'address', 'phone', 'provider', 'role'], 'like', '%' . request('searchKey') . '%');
            })
            ->paginate(4);

        return view('admin.account.userList', compact('user'));
    }



    public function userDelete($id)
    {
        User::where('user_id', $id)->delete();
        return back()->with('success', 'User deleted successfully');
    }
    // validation
    private function checkAccountValidation($request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:6|max:12',
            'confirmPassword' => 'required|min:6|max:12|same:password',
        ], [
            'name.required' => 'အမည်အကွက် ဖြည့်ရန် လိုအပ်သည်။',
            'email.required' => 'အီးမေးလ်အကွက် ဖြည့်ရန် လိုအပ်သည်။',
            'password.required' => 'စကားဝှက်အကွက် ဖြည့်ရန် လိုအပ်သည်။',
            'confirmPassword.required' => 'အတည်ပြုစကားဝှက်အကွက် ဖြည့်ရန် လိုအပ်သည်။'
        ]);
    }
    
    public function reviewList(Request $request)
    {
        $query = Reviews::with(['user', 'product']);

        
        if ($request->searchKey) {
            $search = $request->searchKey;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('nickname', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            })->orWhere('review_text', 'like', '%' . $search . '%');
        }

        if ($request->sort === 'highest') {
            $query->orderBy('rating', 'desc')->orderBy('created_at', 'desc');
        } elseif ($request->sort === 'lowest') {
            $query->orderBy('rating', 'asc')->orderBy('created_at', 'desc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $reviews = $query->paginate(12)->appends($request->query());
        return view('admin.reviewList.reviewList', compact('reviews'));
    }


    public function reviewDelete($id)
    {
        $review = Reviews::findOrFail($id);
        $review->delete();

        return back()->with('success', 'Review permanently removed from the storefront.');
    }
  
    public function toggleFeature($id)
    {
        $review = Reviews::with('user')->findOrFail($id);

      
        $review->is_featured = !$review->is_featured;
        $review->save();

        $status = $review->is_featured ? 'featured on the homepage' : 'removed from the homepage';
        ActivityLog::log(
            'Review Featured Status',
            Auth::user()->name . " marked a review by " . ($review->user->name ?? 'Unknown') . " as {$status}."
        );

        return back()->with('success', "Review successfully {$status}.");
    }
}
