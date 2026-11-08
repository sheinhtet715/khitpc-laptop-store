@extends('authentication.layouts.master')

@section('title', 'Forgot Password — Khit PC')

@section('content')
    <section class="auth-form">
        <div class="px-0 container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="mb-4 fade-in-up">
                        <a href="{{ route('login') }}" class="mb-3 text-decoration-none d-inline-block fw-bold" style="color: var(--brand-navy); font-size: 0.85rem;">
                            <i class="fa-solid fa-arrow-left me-1"></i> Back to sign in
                        </a>
                        <h2 class="mb-1 h3 fw-bolder text-dark">Reset Password</h2>
                        <p class="text-muted small">Enter your email address and we'll send you a link to securely reset your password.</p>
                    </div>

                    <div class="bg-transparent border-0 card">
                        <div class="p-0 card-body">

                            @if(session('status'))
                                <div class="px-3 py-3 mb-4 border-0 shadow-sm alert fade-in-up delay-1 rounded-3 fw-medium small text-success bg-success bg-opacity-10">
                                    <i class="fa-solid fa-circle-check me-2"></i> {{ session('status') }}
                                </div>
                            @endif

                            <form action="{{ route('password.email') }}" method="post" novalidate>
                                @csrf

                                <div class="mb-4 fade-in-up delay-2">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input id="email" name="email" type="email" value="{{ old('email') }}"
                                        class="form-control @error('email') is-invalid @enderror"
                                        placeholder="you@example.com" required autofocus>

                                    @error('email')
                                        <div class="mt-2 invalid-feedback fw-medium">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mt-2 d-grid fade-in-up delay-3">
                                    <button class="btn btn-brand" type="submit">
                                        <i class="fa-regular fa-envelope me-2"></i> Send Reset Link
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
