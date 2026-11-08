@extends('authentication.layouts.master')

@section('title', 'Verify Email — Khit PC')

@section('content')
    <section class="auth-form">
        <div class="px-0 container-fluid">
            <div class="row">
                <div class="text-center col-12">

                    <div class="mb-4 fade-in-up">
                        <div class="mb-3 d-inline-flex align-items-center justify-content-center bg-light rounded-circle" style="width: 80px; height: 80px;">
                            <i class="fa-regular fa-envelope-open fs-1" style="color: var(--brand-navy);"></i>
                        </div>
                        <h2 class="mb-2 h3 fw-bolder text-dark">Check your inbox</h2>
                        <p class="mx-auto text-muted small" style="max-width: 350px; line-height: 1.6;">
                            Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you?
                        </p>
                        <p class="fw-bold" style="color: var(--brand-navy);">{{ Auth::user()->email }}</p>
                    </div>

                    <div class="bg-transparent border-0 card">
                        <div class="p-0 card-body">

                            @if (session('message'))
                                <div class="px-3 py-3 mb-4 border-0 shadow-sm alert fade-in-up delay-1 rounded-3 fw-medium small text-success bg-success bg-opacity-10">
                                    <i class="fa-solid fa-circle-check me-2"></i> A new verification link has been sent to your email address.
                                </div>
                            @endif

                            <div class="gap-3 mt-2 d-flex flex-column align-items-center fade-in-up delay-2">

                                <form method="POST" action="{{ route('verification.send') }}" class="w-100">
                                    @csrf
                                    <button type="submit" class="btn btn-brand w-100">
                                        Resend Verification Email
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-link text-decoration-none text-muted small fw-medium custom-hover-red">
                                        <i class="fa-solid fa-arrow-right-from-bracket me-1"></i> Log Out
                                    </button>
                                </form>

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
