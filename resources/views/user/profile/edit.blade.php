@extends('user.layouts.master')

@section('content')

<style>
 
    .profile-container {
        min-height: 70vh; 
    }


    .profile-card {
        background-color: #ffffff;
        border: 1px solid rgba(30, 58, 95, 0.08);
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(30, 58, 95, 0.04);
        overflow: hidden;
    }

    
    .avatar-wrapper {
        position: relative;
        display: inline-block;
    }

    .profile-avatar {
        width: 180px;
        height: 180px;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid #ffffff;
        box-shadow: 0 8px 25px rgba(30, 58, 95, 0.15);
        transition: transform 0.3s ease;
    }

    .avatar-wrapper:hover .profile-avatar {
        transform: scale(1.02);
    }


    .custom-file-upload input[type="file"] {
        display: none;
    }

    .btn-upload {
        background-color: #ffffff;
        color: #1E3A5F;
        border: 1px solid rgba(30, 58, 95, 0.2);
        border-radius: 50px;
        padding: 8px 20px;
        font-weight: 600;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-upload:hover {
        background-color: #1E3A5F;
        color: #ffffff;
        border-color: #1E3A5F;
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
        color: #FFBF00; /* Gold Icon Accent */
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
        background-color: #1E3A5F; /* Navy */
        color: #ffffff;
        border-radius: 8px;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        transition: all 0.3s ease;
    }

    .btn-save:hover {
        background-color: #D32F2F; /* Red */
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(211, 47, 47, 0.2);
    }

    .btn-password {
        background-color: transparent;
        color: #1E3A5F;
        border: 2px solid rgba(30, 58, 95, 0.2);
        border-radius: 8px;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        transition: all 0.3s ease;
    }

    .btn-password:hover {
        border-color: #1E3A5F;
        background-color: rgba(30, 58, 95, 0.05);
        transform: translateY(-2px);
    }
</style>

<div class="container my-5 profile-container d-flex align-items-center justify-content-center">

    <div class="profile-card w-100" style="max-width: 950px;">

        <div class="p-4 p-md-5 border-bottom" style="border-color: rgba(30,58,95,0.08) !important;">
            <h3 class="mb-1 fw-bold text-navy text-uppercase" style="letter-spacing: 1px;">My Profile</h3>
            <p class="mb-0 text-muted">Manage your personal information and security.</p>
        </div>

        <form action="{{ route('userprofile#update') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="p-4 p-md-5">
                <div class="row g-5 align-items-start">

                    <div class="text-center col-12 col-md-4 d-flex flex-column align-items-center border-md-end" style="border-color: rgba(30,58,95,0.08) !important;">
                        <div class="mb-4 avatar-wrapper">
                            <img id="output" src="{{ $authUserAvatar }}" alt="avatar" class="profile-avatar">
                        </div>

                        <div class="custom-file-upload w-100">
                            <label for="profile_img" class="mb-2 shadow-sm btn-upload d-inline-block">
                                <i class="fa-solid fa-camera me-2"></i> Change Photo
                            </label>
                            <input type="file" id="profile_img" accept="image/*" name="profile_img" onchange="loadFile(event)">

                            @error('profile_img')
                                <div class="mt-2 text-danger small fw-medium">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12 col-md-8 ps-md-4">
                        <div class="row g-4">

                            <div class="col-md-6">
                                <label class="form-label">Full Name</label>
                                <div class="input-group premium-input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Mg Mg" value="{{ old('name', Auth::user()->name != null ? Auth::user()->name : Auth::user()->nickname) }}">
                                </div>
                                @error('name') <div class="mt-1 text-danger small fw-medium">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email Address</label>
                                <div class="input-group premium-input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="john@example.com" value="{{ old('email', Auth::user()->email) }}">
                                </div>
                                @error('email') <div class="mt-1 text-danger small fw-medium">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Phone Number</label>
                                <div class="input-group premium-input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-phone"></i></span>
                                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="09xxxxxxxxx" value="{{ old('phone', Auth::user()->phone) }}">
                                </div>
                                @error('phone') <div class="mt-1 text-danger small fw-medium">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Delivery Address</label>
                                <div class="input-group premium-input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-location-dot"></i></span>
                                    <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" placeholder="123 Main St..." value="{{ old('address', Auth::user()->address) }}">
                                </div>
                                @error('address') <div class="mt-1 text-danger small fw-medium">{{ $message }}</div> @enderror
                            </div>

                            <div class="mt-5 col-12">
                                <div class="gap-3 d-flex flex-column flex-sm-row justify-content-end">

                                    @if(auth()->check() && (auth()->user()->provider === 'simple' || is_null(auth()->user()->provider)))
                                        <a href="{{ route('userprofile#changePasswordPage') }}" class="order-2 px-4 py-2 btn btn-password order-sm-1">
                                            <i class="fa-solid fa-lock me-2"></i> Change Password
                                        </a>
                                    @endif

                                    <button type="submit" class="order-1 px-5 py-2 shadow-sm btn btn-save order-sm-2">
                                        <i class="fa-solid fa-floppy-disk me-2"></i> Save Changes
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>

<script>
    function loadFile(event) {
        const file = event.target.files && event.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('output').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
</script>

@endsection
