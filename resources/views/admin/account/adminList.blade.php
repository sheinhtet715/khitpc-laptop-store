@extends('admin.layouts.master')

@section('page-title', 'Admin Management')
@section('page-subtitle', 'System Administrators')

@section('content')

    <style>
        .admin-table th {
            background-color: #1E3A5F !important;
            color: #ffffff !important;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            font-size: 0.85rem;
            border-bottom: none;
        }

        .admin-table td {
            vertical-align: middle;
            color: #1F2937;
            font-weight: 500;
            border-bottom: 1px solid rgba(30, 58, 95, 0.05);
        }

        .admin-table tbody tr:hover {
            background-color: rgba(30, 58, 95, 0.02);
        }

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

        .avatar-img {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #fff;
            box-shadow: 0 2px 5px rgba(30, 58, 95, 0.15);
        }
    </style>

    <div class="py-4 container-fluid">

        <div class="gap-3 mb-4 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
            <div class="d-flex align-items-center fw-bold text-muted text-uppercase small" style="letter-spacing: 0.5px;">
                Total Admins:
                <span class="px-2 py-1 text-white shadow-sm ms-2 rounded-2"
                    style="background-color: #1E3A5F; font-size: 0.85rem; line-height: 1;">
                    {{ $admin->total() }}
                </span>
            </div>

            <div class="gap-3 d-flex flex-column flex-sm-row">
                <form action="{{ route('account#adminList') }}" method="get" class="d-flex">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="searchKey" value="{{ request('searchKey') }}"
                            class="form-control admin-input" placeholder="Search admins...">
                        <button type="submit" class="px-3 btn btn-admin-primary">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </form>

                <a href="{{ route('account#newAccountPage') }}" class="shadow-sm btn btn-admin-primary fw-bold text-nowrap">
                    <i class="fa-solid fa-user-plus me-2 text-gold"></i> Add Admin
                </a>

                <a href="{{ route('account#userList') }}"
                    class="border shadow-sm btn btn-light fw-bold text-navy text-nowrap">
                    <i class="fa-solid fa-users me-2 text-gold"></i> Users
                </a>
            </div>
        </div>

        <div class="admin-card">
            <div class="p-0 card-body">
                <div class="table-responsive">
                    <table class="table mb-0 align-middle admin-table table-hover">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 text-center">Profile</th>
                                <th class="py-3">Name</th>
                                <th class="py-3">Contact Info</th>
                                <th class="py-3 text-center">Role</th>
                                <th class="py-3 text-center">Platform</th>
                                <th class="py-3">Joined</th>
                                <th class="px-4 py-3 text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($admin as $item)
                                <tr>
                                    <td class="px-4 py-3 text-center">
                                        <img class="avatar-img"
                                            src="{{ asset($item->profile_img != null ? 'profile/' . $item->profile_img : 'default/default_image.webp') }}"
                                            alt="Profile">
                                    </td>

                                    <td class="py-3 fw-bold text-navy">
                                        {{ $item->name != null ? $item->name : $item->nickname }}
                                    </td>

                                    <td class="py-3">
                                        <div class="mb-1 small fw-medium text-dark">
                                            <i class="fa-solid fa-envelope text-muted me-2"></i>{{ $item->email }}
                                        </div>
                                        @if ($item->phone)
                                            <div class="small text-muted">
                                                <i class="fa-solid fa-phone text-muted me-2"></i>{{ $item->phone }}
                                            </div>
                                        @endif
                                    </td>

                                    <td class="py-3 text-center">
                                        @if ($item->role == 'superadmin')
                                            <span
                                                class="px-2 py-1 bg-opacity-25 border badge bg-warning text-dark border-warning">
                                                <i class="fa-solid fa-crown me-1 text-gold"></i> Super Admin
                                            </span>
                                        @else
                                            <span class="px-2 py-1 border badge bg-light text-navy"
                                                style="background-color: #f8fafc; color: #1E3A5F; font-size: 0.85rem;">Admin</span>
                                        @endif
                                    </td>

                                    <td class="py-3 text-center fs-5">
                                        @if ($item->provider == 'google')
                                            <i class="fa-brands fa-google text-danger" title="Google"></i>
                                        @elseif ($item->provider == 'github')
                                            <i class="fa-brands fa-github text-dark" title="GitHub"></i>
                                        @else
                                            <i class="fa-solid fa-envelope text-navy" title="Email"></i>
                                        @endif
                                    </td>

                                    <td class="py-3 text-muted small">
                                        {{ $item->created_at->format('j M, Y') }}
                                    </td>

                                    <td class="px-4 py-3 text-end">
                                        {{-- Check if it's NOT the logged-in user AND NOT the protected superadmin --}}
                                        @if (Auth::user()->email !== $item->email && $item->email !== 'superadmin@gmail.com')
                                            <form action="{{ route('account#changeRole', $item->user_id) }}" method="POST"
                                                class="d-inline-block me-2">
                                                @csrf
                                                @if ($item->role === 'admin')
                                                    <button type="submit" class="btn btn-sm btn-outline-success fw-bold"
                                                        title="Promote to Superadmin">
                                                        <i class="fa-solid fa-arrow-up-right-dots me-1"></i> Promote
                                                    </button>
                                                @else
                                                    <button type="submit" class="btn btn-sm btn-outline-warning fw-bold"
                                                        title="Demote to Admin">
                                                        <i class="fa-solid fa-arrow-down me-1"></i> Demote
                                                    </button>
                                                @endif
                                            </form>

                                            <button type="button"
                                                onclick="deleteProcess('{{ route('account#adminDelete', $item->user_id) }}')"
                                                class="btn btn-sm btn-outline-danger fw-bold" title="Delete Admin">
                                                <i class="fa-solid fa-trash me-1"></i> Delete
                                            </button>
                                        @else
                                            {{-- If it IS the logged-in user --}}
                                            @if (Auth::user()->email === $item->email)
                                                <span class="px-3 py-2 border badge bg-light text-secondary">
                                                    <i class="fa-solid fa-user-shield me-1"></i> It's You
                                                </span>
                                                {{-- If it is the protected Superadmin --}}
                                            @else
                                                <span
                                                    class="px-3 py-2 border badge bg-danger bg-opacity-10 text-danger border-danger">
                                                    <i class="fa-solid fa-lock me-1"></i> Protected
                                                </span>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-5 text-center text-muted">
                                        <i class="mb-3 opacity-50 fa-solid fa-user-shield fa-3x"></i>
                                        <h5 class="fw-bold text-navy">No admins found!</h5>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($admin->hasPages())
                    <div class="p-4 d-flex justify-content-end border-top">
                        {{ $admin->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection

@section('js-script')
    <script>
        function deleteProcess(url) {
            Swal.fire({
                title: "Delete Admin?",
                text: "This admin account will be permanently deleted.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#D32F2F",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Yes, delete admin"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        }
    </script>
@endsection
