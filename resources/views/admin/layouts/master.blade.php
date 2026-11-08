<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin — Khit PC Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin/css/adminmain.css') }}">
    <style>

        .admin-dropdown {
            box-shadow: 0 10px 30px rgba(30, 58, 95, 0.1) !important;
            padding: 0.5rem 0;
        }


        .theme-dropdown-item {
            color: #4b5563;
            transition: all 0.2s ease;
        }

        .theme-dropdown-item:hover,
        .theme-dropdown-item:focus {
            background-color: rgba(30, 58, 95, 0.05);
            color: #1E3A5F !important;
        }

        .theme-dropdown-item:active {
            background-color: #1E3A5F !important;
            color: #ffffff !important;
        }

        .theme-dropdown-danger {
            color: #dc3545;
            transition: all 0.2s ease;
        }

        .theme-dropdown-danger:hover,
        .theme-dropdown-danger:focus {
            background-color: rgba(220, 53, 69, 0.08);
            color: #dc3545 !important;
        }

        .theme-dropdown-danger:active {
            background-color: #dc3545 !important;
            color: #ffffff !important;
        }


        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }


        ::-webkit-scrollbar-thumb {
            background-color: rgba(30, 58, 95, 0.2);
            border-radius: 10px;
        }


        ::-webkit-scrollbar-thumb:hover {
            background-color: rgba(30, 58, 95, 0.6);
        }

        * {
            scrollbar-width: thin;
            scrollbar-color: rgba(30, 58, 95, 0.4) transparent;
        }
    </style>
</head>

<body>
    <aside id="sidebar" class="sidebar">
        <div class="d-flex justify-content-between align-items-center">
            <div class="brand d-flex align-items-center">
                <img src="{{ asset('user/images/adminlogo.png') }}" alt="Khit PC Logo" class="me-2"
                    style="height: 52px; width: auto; object-fit: contain;">

                <span>Khit PC</span>
            </div>
            <button id="closeSidebar" class="text-white border-0 btn btn-sm d-lg-none" aria-label="Close sidebar">
                <i class="fa-solid fa-xmark fs-5"></i>
            </button>
        </div>

        <div class="user">
            <div class="avatar">
                @php
                    $authUserImage = Auth::user()->profile_img ?? null;
                    $imageSrc = asset('default/profilePic.jpg');

                    if ($authUserImage) {
                        if (filter_var($authUserImage, FILTER_VALIDATE_URL)) {
                            $imageSrc = $authUserImage;
                        } else {
                            $imageSrc = asset('profile/' . $authUserImage);
                        }
                    }
                @endphp
                <img referrerpolicy="no-referrer" src="{{ $imageSrc }}" alt="avatar"
                    style="width:100%;height:100%;object-fit:cover;">
            </div>
          <div class="meta" style="min-width: 0; max-width: 100%;">
    <div class="fw-bold text-white text-truncate" style="max-width: 150px;" title="{{ Auth::user()->name ?: Auth::user()->nickname }}">
        {{ Auth::user()->name ?: Auth::user()->nickname }}
    </div>
    <div class="mt-1 text-uppercase"
        style="font-size:0.75rem; color:rgba(255,255,255,0.6); letter-spacing:1px;">
        {{ Auth::user()->role }}
    </div>
</div>
        </div>

        <nav class="mb-2 nav flex-column">
            <a class="nav-link {{ request()->routeIs('admin#home') ? 'active' : '' }}" href="{{ route('admin#home') }}">
                <i class="fa-solid fa-gauge-high me-3"></i>Dashboard
            </a>

            <a class="nav-link {{ request()->routeIs('category#*') ? 'active' : '' }}"
                href="{{ route('category#list') }}">
                <i class="fa-solid fa-layer-group me-3"></i>Categories
            </a>

            <a class="nav-link {{ request()->routeIs('brand#*') ? 'active' : '' }}" href="{{ route('brand#list') }}">
                <i class="fa-solid fa-tags me-3"></i>Brands
            </a>

            <a class="nav-link {{ request()->routeIs('productspecs#*') ? 'active' : '' }}"
                href="{{ route('productspecs#list') }}">
                <i class="fa-solid fa-list-check me-3"></i>Specifications
            </a>

            <a class="nav-link {{ request()->routeIs('product#*') ? 'active' : '' }}"
                href="{{ route('product#list') }}">
                <i class="fa-solid fa-laptop me-3"></i>Products
            </a>

            @if (Auth()->user()->role == 'superadmin')
                <a class="nav-link {{ request()->routeIs('payment#*') ? 'active' : '' }}"
                    href="{{ route('payment#list') }}">
                    <i class="fa-solid fa-credit-card me-3"></i>Payment Methods
                </a>
            @endif

            <a class="nav-link {{ request()->routeIs('discount#*') ? 'active' : '' }}"
                href="{{ route('discount#list') }}">
                <i class="fa-solid fa-percent me-3"></i>Discount Codes
            </a>

            <a class="nav-link {{ request()->routeIs('offer#*') ? 'active' : '' }}" href="{{ route('offer#list') }}">
                <i class="fa-solid fa-ticket me-3"></i>Offers
            </a>

            <a class="nav-link {{ request()->routeIs('receipts#*') ? 'active' : '' }}"
                href="{{ route('receipts#list') }}">
                <i class="fa-solid fa-boxes-stacked me-3"></i>Orders
            </a>

            <a class="nav-link {{ request()->routeIs('admin#salesReport') ? 'active' : '' }}"
                href="{{ route('admin#salesReport') }}">
                <i class="fa-solid fa-chart-area me-3"></i>Reports
            </a>
            <a class="nav-link {{ request()->routeIs('review#list') ? 'active' : '' }}"
                href="{{ route('review#list') }}">
                <i class="fa-solid fa-comment me-3"></i>Reviews
            </a>
            @if (Auth::user()->role === 'superadmin')
                <a class="nav-link {{ request()->routeIs('admin#auditLogs') ? 'active' : '' }}"
                    href="{{ route('admin#auditLogs') }}">
                    <i class="fa-solid fa-clipboard-list me-2"></i>
                    <span>Audit Logs</span>
                </a>
            @endif
        </nav>

        <hr>

        <div class="mt-auto text-center small" style="color: rgba(255,255,255,0.4);">
            <div class="fw-medium">© <span id="year"></span> Khit PC</div>
            <div style="font-size:0.75rem;">Admin Control Panel</div>
        </div>
    </aside>

    <main id="main-content-wrapper">
        <header id="topbar" class="topbar">
            <div class="gap-3 d-flex align-items-center">
                <button id="openSidebar" class="border-0 shadow-sm hamburger btn btn-light d-lg-none"
                    aria-label="Open sidebar">
                    <i class="fa-solid fa-bars text-dark"></i>
                </button>
                <div>
                    <h4 class="mb-0 fw-bold text-navy">@yield('page-title', 'Dashboard')</h4>
                    <div class="text-muted small fw-medium text-uppercase" style="letter-spacing: 0.5px;">
                        @yield('page-subtitle', 'Overview & Key Metrics')</div>
                </div>
            </div>

            <div class="dropdown">
                <a class="d-flex align-items-center text-decoration-none" href="#" id="adminMenu"
                    data-bs-toggle="dropdown">
                    <div class="d-none d-sm-block text-end me-3">
                        <div class="fw-bold text-dark" style="font-size: 0.95rem;">
                            {{ Auth::user()->name ?: Auth::user()->nickname }}</div>
                        <div class="text-muted text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.5px;">
                            {{ Auth::user()->role }}</div>
                    </div>
                    <img referrerpolicy="no-referrer" src="{{ $imageSrc }}" alt="avatar"
                        style="width:42px;height:42px;object-fit:cover; border-radius: 12px; border: 1px solid rgba(30,58,95,0.1);">
                </a>

                <ul class="mt-2 border-0 admin-dropdown dropdown-menu dropdown-menu-end" style="border-radius: 12px;">
                    <li>
                        <a class="py-2 dropdown-item fw-medium theme-dropdown-item"
                            href="{{ route('profile#edit') }}">
                            <i class="fa-solid fa-user me-2"></i> My Profile
                        </a>
                    </li>

                    @if (Auth()->user()->role == 'superadmin')
                        <li>
                            <hr class="opacity-25 dropdown-divider">
                        </li>
                        <li>
                            <h6 class="dropdown-header text-uppercase text-navy fw-bold"
                                style="letter-spacing: 0.5px;">Administration</h6>
                        </li>
                        <li>
                            <a class="py-2 dropdown-item fw-medium theme-dropdown-item"
                                href="{{ route('account#newAccountPage') }}">
                                <i class="fa-solid fa-user-plus me-2"></i> Add Admin
                            </a>
                        </li>
                        <li>
                            <a class="py-2 dropdown-item fw-medium theme-dropdown-item"
                                href="{{ route('account#adminList') }}">
                                <i class="fa-solid fa-user-shield me-2"></i> Admin List
                            </a>
                        </li>
                        <li>
                            <a class="py-2 dropdown-item fw-medium theme-dropdown-item"
                                href="{{ route('account#userList') }}">
                                <i class="fa-solid fa-users me-2"></i> User List
                            </a>
                        </li>
                    @endif

                    <li>
                        <hr class="opacity-25 dropdown-divider">
                    </li>

                    <li>
                        <a class="py-2 dropdown-item fw-medium theme-dropdown-item"
                            href="{{ route('profile#changePasswordPage') }}">
                            <i class="fa-solid fa-lock me-2"></i> Security
                        </a>
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="py-2 dropdown-item fw-bold theme-dropdown-danger">
                                <i class="fa-solid fa-right-from-bracket me-2"></i> Sign Out
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </header>

        @yield('content')

    </main>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script src="{{ asset('admin/js/adminmain.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

    @yield('js-script')
    @yield('js-script')

    <script>

        document.getElementById('year').textContent = new Date().getFullYear();

        function loadFile(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById("output");
                if (output) output.src = reader.result;
            }
            if (event.target.files[0]) reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>

</html>
