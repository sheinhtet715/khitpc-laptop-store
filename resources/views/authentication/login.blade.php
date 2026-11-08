@extends('authentication.layouts.master')

@section('title', 'Sign In — Khit PC')

@section('content')
    <section class="auth-form">
        <div class="px-0 container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="mb-4 fade-in-up">
                        <h2 class="mb-1 h3 fw-bolder text-dark">Welcome back</h2>
                        <p class="text-muted small">Please enter your details to sign in.</p>
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

                            <div class="divider fade-in-up delay-2">or continue with email</div>

                            @error('email')
                                <div class="px-3 py-2 border-0 shadow-sm alert alert-danger fade-in-up delay-2 rounded-3 fw-medium small text-danger bg-danger bg-opacity-10"><i class="fa-solid fa-circle-exclamation me-2"></i>{{ $message }}</div>
                            @enderror

                            <form action="{{ url('login') }}" method="post" novalidate>
                                @csrf

                                <div class="mb-4 fade-in-up delay-3">
                                    <label for="signinEmail" class="form-label">Email Address</label>
                                    <input id="signinEmail" name="email" type="email" value="{{ old('email') }}"
                                        class="form-control @error('email') is-invalid @enderror"
                                        placeholder="you@example.com" required>
                                </div>

                                <div class="mb-4 fade-in-up delay-4">
                                    <label for="signinPassword" class="form-label d-flex justify-content-between">
                                        Password
                                        <a href="{{ route('password.request') }}" class="text-decoration-none fw-bold" style="color: var(--brand-navy); text-transform: none; letter-spacing: 0;">Forgot password?</a>
                                    </label>

                                    <div class="position-relative">
                                        <input id="signinPassword" name="password" type="password"
                                            class="form-control pe-5 @error('password') is-invalid @enderror" placeholder="••••••••" required minlength="6">

                                        <button type="button" class="border-0 btn position-absolute top-50 end-0 translate-middle-y password-toggle" onclick="togglePassword('signinPassword', 'loginEyeIcon')">
                                            <i class="fa-regular fa-eye" id="loginEyeIcon"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <div class="mt-2 text-danger small fw-medium">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mt-2 d-grid fade-in-up delay-4">
                                    <button class="btn btn-brand" type="submit">Sign in to your account</button>
                                </div>

                                <div class="mt-4 text-center fade-in-up delay-4">
                                    <p class="mb-0 text-muted" style="font-size: 0.95rem;">
                                        Don't have an account?
                                        <a href="{{ route('register') }}" class="text-decoration-none fw-bold" style="color: var(--brand-navy);">Create one</a>
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
