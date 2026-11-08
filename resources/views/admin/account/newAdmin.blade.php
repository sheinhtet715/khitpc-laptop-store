@extends('admin.layouts.master')

@section('page-title', 'Invite Admin')
@section('page-subtitle', 'Send an invitation to a new system administrator')

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

.text-gold {
    color: #FFBF00;
}
</style>

<div class="py-4 container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">

            <div class="mb-3">
                <a href="{{ route('account#adminList') }}" class="px-3 border shadow-sm btn btn-light text-navy fw-bold btn-sm transition-hover">
                    <i class="fa-solid fa-arrow-left me-2"></i> Back to Admins
                </a>
            </div>

            <div class="overflow-hidden shadow-sm admin-card rounded-3">

                <div class="p-4 card-header-navy d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-1 text-white fw-bold"><i class="fa-solid fa-envelope-open-text me-2 text-gold"></i> Invite Admin</h4>
                        <div class="small" style="color: rgba(255,255,255,0.7); letter-spacing: 0.5px;">
                            Send a secure link to grant system access
                        </div>
                    </div>
                    <i class="fa-solid fa-shield-halved fs-1" style="color: rgba(255,255,255,0.1);"></i>
                </div>

                <div class="p-4 bg-white card-body p-md-5">
                    <form action="{{ route('account#newAccount') }}" method="post" novalidate>
                        @csrf

                        <div class="mb-5">
                            <label class="form-label fw-bold text-navy small text-uppercase">Email Address</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control form-control-lg admin-input @error('email') is-invalid @enderror" placeholder="Enter the new admin's email address..." required autofocus>

                            @error('email')
                                <div class="mt-2 invalid-feedback fw-medium">{{ $message }}</div>
                            @enderror

                            <div class="mt-3 form-text small text-muted">
                                <i class="fa-solid fa-circle-info me-1"></i> We will send a secure link to this email address so the new admin can privately set their own name and password.
                            </div>
                        </div>

                        <div class="pt-4 border-top" style="border-color: rgba(30,58,95,0.08) !important;">
                            <button type="submit" class="px-5 py-3 shadow-sm btn btn-admin-primary fw-bold text-uppercase w-100" style="letter-spacing: 1px;">
                                <i class="fa-solid fa-paper-plane me-2"></i> Send Invitation Link
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
