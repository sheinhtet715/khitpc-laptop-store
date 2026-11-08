@extends('user.layouts.master')

@section('content')
    <style>
       
        .password-container {
            min-height: 70vh;
    
        }

        .password-card {
            background-color: #ffffff;
            border: 1px solid rgba(30, 58, 95, 0.08);
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(30, 58, 95, 0.04);
            overflow: hidden;
        }

        .premium-input-group {
            border-radius: 8px;
            transition: box-shadow 0.2s ease;
        }

        .premium-input-group:focus-within {
            box-shadow: 0 0 0 3px rgba(30, 58, 95, 0.1);
        }

        .premium-input-group .input-group-text {
            background-color: transparent;
            border: 1px solid rgba(30, 58, 95, 0.15);
            border-right: none;
            color: #FFBF00;
            border-radius: 8px 0 0 8px;
        }

        .premium-input-group .form-control {
            border: 1px solid rgba(30, 58, 95, 0.15);
            border-left: none;
            background-color: transparent;
            border-radius: 0 8px 8px 0;
            color: #1F2937;
            font-weight: 500;
        }

        .premium-input-group .form-control:focus {
            box-shadow: none;
            border-color: rgba(30, 58, 95, 0.15);
        }

        .form-label {
            color: #6c757d;
            font-weight: 700;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 0.5rem;
        }


        .btn-save {
            background-color: #1E3A5F;
            color: #ffffff;
            border-radius: 8px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            transition: all 0.3s ease;
        }

        .btn-save:hover {
            background-color: #D32F2F;
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(211, 47, 47, 0.2);
        }

        .back-btn {
            color: #6c757d;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: color 0.2s ease;
        }

        .back-btn:hover {
            color: #1E3A5F;
        }

        /* --- Forgot Password Link --- */
        .forgot-link {
            color: #1E3A5F;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            transition: color 0.2s ease;
        }

        .forgot-link:hover {
            color: #D32F2F;
      
        }
    </style>

    <div class="container my-5 password-container d-flex align-items-center justify-content-center">

        <div class="password-card w-100" style="max-width: 600px;">

            <div class="p-4 p-md-5 border-bottom position-relative" style="border-color: rgba(30,58,95,0.08) !important;">
                <a href="{{ route('userprofile#edit') }}"
                    class="p-0 mb-3 btn btn-link text-decoration-none back-btn d-inline-block">
                    <i class="fa-solid fa-arrow-left me-2"></i> Back to Profile
                </a>
                <h3 class="mb-1 fw-bold text-navy text-uppercase" style="letter-spacing: 1px;">Security</h3>
                <p class="mb-0 text-muted">Update your password to keep your account secure.</p>
            </div>

            <form action="" method="post">
                @csrf
                <div class="p-4 p-md-5">
                    <div class="row g-4">

                        <div class="col-12">
                            <div class="mb-2 d-flex justify-content-between align-items-center">
                                <label class="mb-0 form-label">Current Password</label>
                                <a href="{{ route('profile.forgot-password.transition') }}"
                                    class="text-decoration-none forgot-link">
                                    Forgot password?
                                </a>
                            </div>

                            <div class="input-group premium-input-group">
                                <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                <input type="password" name="oldPassword"
                                    class="form-control @error('oldPassword') is-invalid @enderror"
                                    placeholder="Enter current password...">
                            </div>
                            @error('oldPassword')
                                <div class="mt-1 text-danger small fw-medium">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-4 col-12">
                            <label class="form-label">New Password</label>
                            <div class="input-group premium-input-group">
                                <span class="input-group-text"><i class="fa-solid fa-key"></i></span>
                                <input type="password" name="newPassword"
                                    class="form-control @error('newPassword') is-invalid @enderror"
                                    placeholder="Enter new password...">
                            </div>
                            @error('newPassword')
                                <div class="mt-1 text-danger small fw-medium">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Confirm New Password</label>
                            <div class="input-group premium-input-group">
                                <span class="input-group-text"><i class="fa-solid fa-check-double"></i></span>
                                <input type="password" name="confirmPassword"
                                    class="form-control @error('confirmPassword') is-invalid @enderror"
                                    placeholder="Confirm new password...">
                            </div>
                            @error('confirmPassword')
                                <div class="mt-1 text-danger small fw-medium">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-5 col-12">
                            <button type="submit" class="py-3 shadow-sm btn btn-save w-100">
                                <i class="fa-solid fa-shield-halved me-2"></i> Update Password
                            </button>
                        </div>

                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection
