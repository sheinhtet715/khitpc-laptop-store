@extends('authentication.layouts.master')

@section('title', 'Create Account — Khit PC')

@section('content')
    <section class="auth-form">
        <div class="px-0 container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="mb-4 fade-in-up">
                        <h2 class="mb-1 h3 fw-bolder text-dark">Create an account</h2>
                        <p class="text-muted small">Join Khit PC for exclusive tech deals.</p>
                    </div>

                    <div class="bg-transparent border-0 card">
                        <div class="p-0 card-body">

                            <div class="gap-2 mb-3 fade-in-up delay-1 d-flex flex-column flex-sm-row">
                                <a class="btn social-btn social-google flex-fill" href="{{ route('socialLogin', 'google') }}">
                                    <img src="https://www.gstatic.com/images/branding/product/1x/gsa_64dp.png" alt="" style="width:18px;height:18px;object-fit:contain">
                                    <span class="text-center flex-fill">Google</span>
                                </a>

                                <a class="btn social-btn social-github flex-fill" href="{{ route('socialLogin', 'github') }}">
                                    <i class="fa-brands fa-github fs-5"></i>
                                    <span class="text-center flex-fill">GitHub</span>
                                </a>
                            </div>

                            <div class="divider fade-in-up delay-2">or register with email</div>

                            <form action="{{ url('register') }}" method="post" class="row g-3" novalidate>
                                @csrf

                                <div class="col-12 fade-in-up delay-3">
                                    <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input id="name" name="name" value="{{ old('name') }}" type="text"
                                        class="form-control @error('name') is-invalid @enderror"
                                        placeholder="e.g. Mg Mg" required>
                                    @error('name')
                                        <div class="invalid-feedback fw-medium">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 fade-in-up delay-3">
                                    <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                    <input id="email" name="email" value="{{ old('email') }}" type="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        placeholder="you@example.com" required>
                                    @error('email')
                                        <div class="invalid-feedback fw-medium">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 fade-in-up delay-4">
                                    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                    <div class="position-relative">
                                        <input id="password" name="password" type="password"
                                            class="form-control pe-5 @error('password') is-invalid @enderror"
                                            placeholder="Min 8 chars" required minlength="8">
                                        <button type="button" class="border-0 btn position-absolute top-50 end-0 translate-middle-y password-toggle" onclick="togglePassword('password', 'regEye1')">
                                            <i class="fa-regular fa-eye" id="regEye1"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <div class="mt-1 text-danger small fw-medium">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 fade-in-up delay-4">
                                    <label for="password_confirmation" class="form-label">Confirm <span class="text-danger">*</span></label>
                                    <div class="position-relative">
                                        <input id="password_confirmation" name="password_confirmation" type="password"
                                            class="form-control pe-5" placeholder="Match password" required minlength="8">
                                        <button type="button" class="border-0 btn position-absolute top-50 end-0 translate-middle-y password-toggle" onclick="togglePassword('password_confirmation', 'regEye2')">
                                            <i class="fa-regular fa-eye" id="regEye2"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="mt-4 col-12 d-grid fade-in-up delay-5">
                                    <button class="btn btn-brand" type="submit">Create account</button>
                                </div>

                                <div class="mt-3 text-center col-12 fade-in-up delay-5">
                                    <p class="mb-0 text-muted" style="font-size: 0.95rem;">
                                        Already have an account?
                                        <a href="{{ route('login') }}" class="text-decoration-none fw-bold" style="color: var(--brand-navy);">Sign in</a>
                                    </p>
                                </div>
                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
