@extends('authentication.layouts.master')

@section('title', 'Accept Admin Invitation — Khit PC')

@section('content')
    <section class="auth-form">
        <div class="px-0 container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="mb-4 text-center fade-in-up">
                        <div class="mb-3 shadow-sm d-inline-flex align-items-center justify-content-center bg-light rounded-circle" style="width: 80px; height: 80px;">
                            <i class="fa-solid fa-user-shield fs-1" style="color: var(--brand-navy);"></i>
                        </div>
                        <h2 class="mb-1 h3 fw-bolder text-dark">Welcome to the Team!</h2>
                        <p class="text-muted small">You have been invited to join Khit PC as an <strong>{{ ucfirst($invitation->role) }}</strong>. Please complete your profile setup.</p>
                    </div>

                    <div class="bg-transparent border-0 card">
                        <div class="p-0 card-body">

                            <form action="{{ route('admin.invitation.process', $invitation->invitation_token) }}" method="post" novalidate>
                                @csrf

                                <div class="mb-3 fade-in-up delay-1">
                                    <label class="form-label text-uppercase small fw-bold text-muted" style="letter-spacing: 0.5px;">Assigned Email</label>
                                    <input type="email" value="{{ $invitation->email }}" class="form-control text-muted" readonly style="background-color: #f8fafc;">
                                </div>

                                <div class="mb-3 fade-in-up delay-2">
                                    <label for="name" class="form-label text-uppercase small fw-bold" style="color: var(--brand-navy); letter-spacing: 0.5px;">Your Full Name</label>
                                    <input id="name" name="name" type="text" value="{{ old('name') }}"
                                        class="form-control @error('name') is-invalid @enderror"
                                        placeholder="Aung Aung" required autofocus>
                                    @error('name')
                                        <div class="mt-2 invalid-feedback fw-medium">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 fade-in-up delay-3">
                                    <label for="password" class="form-label text-uppercase small fw-bold" style="color: var(--brand-navy); letter-spacing: 0.5px;">Create Private Password</label>
                                    <input id="password" name="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" placeholder="Min 8 characters" required>
                                    @error('password')
                                        <div class="mt-2 invalid-feedback fw-medium">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4 fade-in-up delay-4">
                                    <label for="password_confirmation" class="form-label text-uppercase small fw-bold" style="color: var(--brand-navy); letter-spacing: 0.5px;">Confirm Password</label>
                                    <input id="password_confirmation" name="password_confirmation" type="password"
                                        class="form-control" placeholder="Match new password" required>
                                </div>

                                <div class="mt-4 d-grid fade-in-up delay-5">
                                    <button class="py-3 btn btn-brand" type="submit">
                                        <i class="fa-solid fa-check me-2"></i> Create Admin Account
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
