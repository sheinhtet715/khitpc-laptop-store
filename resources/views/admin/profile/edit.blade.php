@extends('admin.layouts.master')

@section('page-title', 'My Profile')
@section('page-subtitle', 'Manage Your Account Settings')

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

    .profile-img-container {
        width: 180px;
        height: 180px;
        border-radius: 50%;
        overflow: hidden;
        border: 4px solid #ffffff;
        box-shadow: 0 8px 20px rgba(30, 58, 95, 0.15);
        margin: 0 auto 1.5rem auto;
        background-color: #f8fafc;
        position: relative;
    }
    .profile-img-container img { 
		width: 100%; 
		height: 100%; 
		object-fit: cover; 
	}
</style>

<div class="py-4 container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-10">

            <div class="overflow-hidden admin-card">

                <div class="p-4 card-header-navy d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-1 text-white fw-bold"><i class="fa-solid fa-user-pen me-2 text-gold"></i> Edit Profile</h4>
                        <div class="small" style="color: rgba(255,255,255,0.7); letter-spacing: 0.5px;">
                            ROLE: <span class="badge bg-warning text-dark ms-1 fw-bold text-uppercase">{{ Auth::user()->role }}</span>
                        </div>
                    </div>
                    <i class="fa-solid fa-id-badge fs-1" style="color: rgba(255,255,255,0.1);"></i>
                </div>

                <form action="{{ route('profile#update') }}" method="post" enctype="multipart/form-data" novalidate>
                    @csrf
                    <div class="p-4 card-body p-md-5">
                        <div class="row g-5">

                            <div class="text-center col-12 col-lg-4 border-end-lg" style="border-color: rgba(30,58,95,0.05) !important;">
                                <div class="profile-img-container">
                                    <img id="output" src="{{ asset(Auth::user()->profile_img != null ? 'profile/' . Auth::user()->profile_img : 'default/default_image.webp' )}}" alt="Profile Picture">
                                </div>

                                <label class="mb-2 form-label fw-bold text-navy small text-uppercase">Profile Photo</label>
                                <input type="file" accept="image/*" name="profile_img" class="form-control admin-input @error('profile_img') is-invalid @enderror" onchange="loadFile(event)">
                                @error('profile_img')
                                    <div class="mt-2 text-danger small fw-medium">{{ $message }}</div>
                                @enderror
                                <div class="mt-2 text-muted small"><i class="fa-solid fa-circle-info me-1"></i> Recommended: Square JPG or PNG.</div>
                            </div>

                            <div class="col-12 col-lg-8">
                                <div class="row g-4">

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-navy small text-uppercase">Full Name</label>
                                        <input type="text" name="name" class="form-control form-control-lg admin-input @error('name') is-invalid @enderror"
                                            placeholder="Your name..." value="{{ old('name', Auth::user()->name ?? Auth::user()->nickname) }}">
                                        @error('name')
                                            <div class="mt-2 invalid-feedback fw-medium">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-navy small text-uppercase">Email Address</label>
                                        <input type="email" name="email" class="form-control form-control-lg admin-input @error('email') is-invalid @enderror"
                                            placeholder="Your email..." value="{{ old('email', Auth::user()->email) }}">
                                        @error('email')
                                            <div class="mt-2 invalid-feedback fw-medium">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-navy small text-uppercase">Phone Number</label>
                                        <input type="number" name="phone" class="form-control form-control-lg admin-input @error('phone') is-invalid @enderror"
                                            placeholder="e.g. 09123456789" value="{{ old('phone', Auth::user()->phone) }}">
                                        @error('phone')
                                            <div class="mt-2 invalid-feedback fw-medium">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-navy small text-uppercase">Address</label>
                                        <input type="text" name="address" class="form-control form-control-lg admin-input @error('address') is-invalid @enderror"
                                            placeholder="Your address..." value="{{ old('address', Auth::user()->address) }}">
                                        @error('address')
                                            <div class="mt-2 invalid-feedback fw-medium">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>

                                <div class="gap-3 pt-4 mt-5 d-flex flex-column flex-sm-row justify-content-between border-top" style="border-color: rgba(30,58,95,0.08) !important;">
                                    <button type="submit" class="px-5 py-2 shadow-sm btn btn-admin-primary fw-bold text-uppercase" style="letter-spacing: 0.5px;">
                                        <i class="fa-solid fa-floppy-disk me-2"></i> Save Profile
                                    </button>

                                    <a href="{{ route('profile#changePasswordPage') }}" class="px-4 py-2 border shadow-sm btn btn-light fw-bold text-navy">
                                        <i class="fa-solid fa-lock me-2 text-gold"></i> Change Password
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

@endsection

@section('js-script')
<script>

    function loadFile(event) {
        var output = document.getElementById('output');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src) 
        }
    }
</script>
@endsection
