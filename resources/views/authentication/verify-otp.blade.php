@extends('authentication.layouts.master')

@section('title', 'Verify Your Email — Khit PC')

@section('content')
    <section class="auth-form">
        <div class="px-0 container-fluid">
            <div class="row">
                <div class="text-center col-12">

                    <div class="mb-4 fade-in-up">
                        <div class="mb-3 d-inline-flex align-items-center justify-content-center bg-light rounded-circle" style="width: 80px; height: 80px;">
                            <i class="fa-solid fa-shield-halved fs-1" style="color: var(--brand-navy);"></i>
                        </div>
                        <h2 class="mb-2 h3 fw-bolder text-dark">Enter Verification Code</h2>
                        <p class="mx-auto text-muted small" style="max-width: 350px; line-height: 1.6;">
                            We sent a 6-digit security code to: <br>
                            <span class="fw-bold" style="color: var(--brand-navy);">{{ session('pending_registration_email') }}</span>
                        </p>
                    </div>

                    <div class="bg-transparent border-0 card text-start">
                        <div class="p-0 card-body">

                            <form action="{{ route('otp.verify') }}" method="post" novalidate>
                                @csrf

                                <div class="mb-4 fade-in-up delay-1">
                                    <label for="otp" class="text-center form-label w-100">6-Digit Code</label>
                                    <input id="otp" name="otp" type="text"
                                        class="form-control form-control-lg text-center fw-bolder fs-4 tracking-widest @error('otp') is-invalid @enderror"
                                        placeholder="• • • • • •"
                                        maxlength="6"
                                        style="letter-spacing: 8px;"
                                        required autofocus>

                                    @error('otp')
                                        <div class="mt-2 text-center invalid-feedback fw-medium">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mt-2 d-grid fade-in-up delay-2">
                                    <button class="btn btn-brand btn-lg" type="submit">
                                        Verify & Create Account
                                    </button>
                                </div>
                            </form>

                            <div class="mt-4 text-center fade-in-up delay-3">
                                <p class="mb-0 text-muted" style="font-size: 0.90rem;">
                                    Wrong email?
                                    <a href="{{ route('register') }}" class="text-decoration-none fw-bold custom-hover-red" style="color: var(--brand-navy);">Go back and try again</a>
                                </p>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <style>
        .custom-hover-red:hover { 
			color: var(--brand-red) !important; 
		}
    </style>
@endsection
