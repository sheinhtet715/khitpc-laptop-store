@extends('authentication.layouts.master')

@section('title', 'Set New Password — Khit PC')

@section('content')
    <section class="auth-form">
        <div class="px-0 container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="mb-4 fade-in-up">
                        <h2 class="mb-1 h3 fw-bolder text-dark">Set New Password</h2>
                        <p class="text-muted small">Please choose a strong password to secure your Khit PC account.</p>
                    </div>

                    <div class="bg-transparent border-0 card">
                        <div class="p-0 card-body">

                            <form action="{{ route('password.store') }}" method="post" novalidate>
                                @csrf

                                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                                <div class="mb-4 fade-in-up delay-1">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input id="email" name="email" type="email" value="{{ old('email', $request->email) }}"
                                        class="form-control @error('email') is-invalid @enderror"
                                        readonly required>
                                    @error('email')
                                        <div class="mt-2 invalid-feedback fw-medium">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4 fade-in-up delay-2">
                                    <label for="password" class="form-label">New Password <span class="text-danger">*</span></label>
                                    <div class="position-relative">
                                        <input id="password" name="password" type="password"
                                            class="form-control pe-5 @error('password') is-invalid @enderror" placeholder="Min 8 chars" required autofocus>
                                        <button type="button" class="border-0 btn position-absolute top-50 end-0 translate-middle-y password-toggle" onclick="togglePassword('password', 'resetEye1')">
                                            <i class="fa-regular fa-eye" id="resetEye1"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <div class="mt-2 text-danger small fw-medium">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4 fade-in-up delay-3">
                                    <label for="password_confirmation" class="form-label">Confirm New Password <span class="text-danger">*</span></label>
                                    <div class="position-relative">
                                        <input id="password_confirmation" name="password_confirmation" type="password"
                                            class="form-control pe-5" placeholder="Match new password" required>
                                        <button type="button" class="border-0 btn position-absolute top-50 end-0 translate-middle-y password-toggle" onclick="togglePassword('password_confirmation', 'resetEye2')">
                                            <i class="fa-regular fa-eye" id="resetEye2"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="mt-4 d-grid fade-in-up delay-4">
                                    <button class="btn btn-brand" type="submit">
                                        <i class="fa-solid fa-lock me-2"></i> Reset Password
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
