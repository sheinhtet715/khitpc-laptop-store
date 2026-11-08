@extends('admin.layouts.master')

@section('page-title', 'Security')
@section('page-subtitle', 'Manage Your Password')

@section('content')

<style>
   .admin-input:focus {
    border-color: #FFBF00;
    box-shadow: 0 0 0 3px rgba(255, 191, 0, 0.15);
}

.btn-admin-primary {
    background-color: #1E3A5F;
    color: white;
    transition: all 0.2s ease;
}

.btn-admin-primary:hover {
    background-color: #FFBF00;
    color: #1E3A5F;
}

.card-header-navy {
    background: linear-gradient(135deg, #1E3A5F 0%, #152842 100%);
    color: white;
}

 
    .forgot-link {
        color: #1E3A5F;
        font-size: 0.8rem;
        font-weight: 700;
        letter-spacing: 0.5px;
        transition: color 0.2s ease;
    }
    .forgot-link:hover {
        color: #D32F2F;
    }
</style>

<div class="py-4 container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">

            <div class="mb-3">
                <a href="{{ route('profile#edit') }}" class="px-3 border shadow-sm btn btn-light text-navy fw-bold btn-sm transition-hover">
                    <i class="fa-solid fa-arrow-left me-2"></i> Back to Profile
                </a>
            </div>

            <div class="overflow-hidden shadow-sm admin-card rounded-3">

                <div class="p-4 card-header-navy d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-1 text-white fw-bold"><i class="fa-solid fa-shield-halved me-2 text-gold"></i> Change Password</h4>
                        <div class="small" style="color: rgba(255,255,255,0.7); letter-spacing: 0.5px;">
                            Ensure your account stays secure
                        </div>
                    </div>
                    <i class="fa-solid fa-lock fs-1" style="color: rgba(255,255,255,0.1);"></i>
                </div>

                <div class="p-4 bg-white card-body p-md-5">
                    <form action="" method="post" novalidate>
                        @csrf

                        <div class="mb-4">
                            <div class="mb-2 d-flex justify-content-between align-items-center">
                                <label class="mb-0 form-label fw-bold text-navy small text-uppercase">Current Password</label>
                                <a href="{{ route('profile.forgot-password.transition') }}" class="text-decoration-none forgot-link">
                                    Forgot password?
                                </a>
                            </div>
                            <input type="password" name="oldPassword" class="form-control form-control-lg admin-input @error('oldPassword') is-invalid @enderror" placeholder="Enter current password...">
                            @error('oldPassword')
                                <div class="mt-2 invalid-feedback fw-medium">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="mb-2 form-label fw-bold text-navy small text-uppercase">New Password</label>
                            <input type="password" name="newPassword" class="form-control form-control-lg admin-input @error('newPassword') is-invalid @enderror" placeholder="Enter new password...">
                            @error('newPassword')
                                <div class="mt-2 invalid-feedback fw-medium">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-5">
                            <label class="mb-2 form-label fw-bold text-navy small text-uppercase">Confirm New Password</label>
                            <input type="password" name="confirmPassword" class="form-control form-control-lg admin-input @error('confirmPassword') is-invalid @enderror" placeholder="Confirm new password...">
                            @error('confirmPassword')
                                <div class="mt-2 invalid-feedback fw-medium">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="pt-4 border-top" style="border-color: rgba(30,58,95,0.08) !important;">
                            <button type="submit" class="px-5 py-3 btn btn-admin-primary fw-bold text-uppercase w-100" style="letter-spacing: 0.5px;">
                                <i class="fa-solid fa-key me-2"></i> Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
