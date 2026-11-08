<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Khit PC — LaptopStore</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="{{ asset('user/css/home.css') }}?v=3">
    <link rel="stylesheet" href="{{ asset('user/css/storefront.css') }}?v=5">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <style>
      
        html, body {
           
            overflow-x: clip !important;
        }

      
        .swiper:not(.heroMainSwiper) {
            padding: 20px 10px 40px 10px !important;
            margin: -20px -10px -40px -10px !important;
        }

    
        .navbar.glass-nav {
            border-top: none !important;
            border-bottom: 1px solid rgba(30, 58, 95, 0.08) !important;
            background: rgba(255, 255, 255, 0.95) !important;

            position: sticky !important;
            top: 0;
            z-index: 1050;

        
            transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), background-color 0.3s ease !important;
        }

        .nav-hidden {
            transform: translateY(-100%) !important;
        }


        .navbar.glass-nav .custom-nav-link {
            color: #1F2937 !important;
            font-weight: 600;
            padding: 8px 16px !important;
            border-radius: 8px;
            background: transparent;
            transition: all 0.2s ease-in-out;
        }

        .navbar.glass-nav .custom-nav-link:hover,
        .navbar.glass-nav .custom-nav-link.active {
            color: var(--brand-red) !important;
            background: rgba(211, 47, 47, 0.06) !important;
            transform: translateY(-1px);
        }

        .navbar.glass-nav .custom-nav-link::after {
            display: none !important;
        }


        .hero-pagination {
            bottom: 30px !important;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 10;
        }

        .hero-pagination .swiper-pagination-bullet {
            width: 60px;
            height: 4px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 0;
            margin: 0 5px !important;
            position: relative;
            overflow: hidden;
            opacity: 1;
        }

        .hero-pagination .swiper-pagination-bullet .progress-bar {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 0%;
            background: var(--brand-red);
        }

        .hero-pagination .swiper-pagination-bullet-active .progress-bar {
            animation: fillProgress 5s linear forwards;
        }

        @keyframes fillProgress {
            0% { width: 0%; }
            100% { width: 100%; }
        }


        .advanced-footer {
            background: linear-gradient(135deg, #1E3A5F 0%, #112540 100%) !important;
            color: #ffffff !important;
        }

        .advanced-footer .text-muted { color: rgba(255, 255, 255, 0.6) !important; }
        .advanced-footer .text-dark { color: #ffffff !important; }
        .advanced-footer h6 { color: #FFBF00 !important; }

        .pointer-events-none { pointer-events: none; }
        .pointer-events-auto { pointer-events: auto; }

        .typed-cursor {
            font-size: 3.5rem;
            color: var(--brand-red);
            font-weight: bold;
        }


        .flying-cart-dot {
            position: fixed;
            width: 16px;
            height: 16px;
            background-color: #D32F2F;
            border-radius: 50%;
            z-index: 999999;
            pointer-events: none;
            transition: all 1.5s cubic-bezier(0.25, 1, 0.25, 1);
            box-shadow: 0 4px 12px rgba(211, 47, 47, 0.8);
        }

        .cart-bump {
            animation: bumpCart 0.4s ease-out;
        }

        @keyframes bumpCart {
            0% { transform: scale(1); }
            50% { transform: scale(1.3) translateY(-3px); color: #D32F2F; }
            100% { transform: scale(1); }
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg glass-nav">
        <div class="container position-relative z-1">
            <a class="gap-2 navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <img src="{{ asset('user/images/loglo-removebg-preview 2.png') }}" alt="Khit PC Logo"
                    style="height: 46px; margin-left: 20px;">
            </a>

            <button class="border-0 shadow-none navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navMain" aria-controls="navMain" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa-solid fa-bars-staggered fs-4 text-dark"></i>
            </button>

            <div class="collapse navbar-collapse" id="navMain">

                <ul class="gap-1 mb-2 me-auto ms-lg-4 navbar-nav mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link custom-nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link custom-nav-link {{ request()->routeIs('newarrivals') ? 'active' : '' }}" href="{{ route('newarrivals') }}">New Arrivals</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link custom-nav-link {{ request()->routeIs('specialOffers') ? 'active' : '' }}" href="{{ route('specialOffers') }}">Special Offers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link custom-nav-link {{ request()->routeIs('mostPopular') ? 'active' : '' }}" href="{{ route('mostPopular') }}">Most Popular</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link custom-nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link custom-nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact Us</a>
                    </li>
                </ul>

                <div class="gap-3 mt-3 d-flex align-items-center mt-lg-0 ms-auto">

                    @guest
                        <a href="{{ route('login') }}" class="px-4 btn btn-brand-outline rounded-pill fw-semibold">Sign in</a>
                    @endguest

                    @auth
                        @php
                            $visibleAlerts = collect($alerts ?? [])
                                ->filter(function ($a) {
                                    return !empty($a->notification_message);
                                })
                                ->values();
                            $unreadCount = $visibleAlerts
                                ->filter(function ($a) {
                                    return empty($a->is_read);
                                })
                                ->count();
                            $hasUnread = $unreadCount > 0;
                        @endphp

                        <div class="dropdown">
                            <a id="inboxDropdown" class="nav-icon-btn position-relative" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fa-regular fa-bell"></i>
                                @if ($hasUnread)
                                    <span class="top-0 p-1 border border-2 border-white position-absolute start-100 translate-middle bg-danger rounded-circle"
                                        style="width: 10px; height: 10px; margin-top: 6px; margin-left: -6px;"></span>
                                @endif
                            </a>

                            <div class="p-0 overflow-hidden border-0 shadow-lg dropdown-menu dropdown-menu-end rounded-3" aria-labelledby="inboxDropdown" style="width: 320px;">
                                <div class="px-3 py-2 bg-light border-bottom d-flex justify-content-between align-items-center">
                                    <strong class="text-dark">Notifications</strong>
                                    @if ($hasUnread)
                                        <span class="text-white badge bg-danger" style="font-size: 0.7rem;">{{ $unreadCount }} New</span>
                                    @endif
                                </div>
                                <div class="list-group list-group-flush" style="max-height:300px; overflow-y:auto;">
                                    @forelse ($visibleAlerts as $alert)
                                        <a href="{{ route('user#productDetails', $alert->product_id) }}?alert_id={{ $alert->alert_id }}"
                                            class="p-3 list-group-item list-group-item-action border-bottom-0 {{ empty($alert->is_read) ? 'bg-light' : '' }}">
                                            <div class="mb-1 d-flex w-100 justify-content-between align-items-center">
                                                <h6 class="mb-0 fw-semibold text-truncate" style="max-width: 70%;">{{ $alert->product_name ?? 'Product Update' }}</h6>
                                                <small class="text-muted" style="font-size: 0.75rem;">{{ \Carbon\Carbon::parse($alert->created_at)->diffForHumans() }}</small>
                                            </div>
                                            <p class="mb-0 small text-muted">{{ $alert->notification_message ?? 'Product is back in stock.' }}</p>
                                        </a>
                                    @empty
                                        <div class="p-4 text-center text-muted small">
                                            <i class="mb-2 opacity-50 fa-regular fa-bell-slash fs-3"></i><br>
                                            You're all caught up!
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('user#cart') }}" id="nav-cart-icon" class="nav-icon-btn position-relative">
                            <i class="fa-solid fa-cart-shopping"></i>
                        </a>

                        <div class="dropdown">
                            <a class="p-1 transition-all d-flex align-items-center text-decoration-none profile-trigger rounded-pill" href="#" id="profileDropdown" data-bs-toggle="dropdown">
                                <div class="overflow-hidden border border-2 border-white shadow-sm avatar-sm rounded-circle" style="width: 40px; height: 40px;">
                                    @php
                                        $authUserImage = Auth::user()->profile_img ?? null;
                                        $imageSrc = $authUserImage
                                            ? (filter_var($authUserImage, FILTER_VALIDATE_URL)
                                                ? $authUserImage
                                                : asset('profile/' . $authUserImage))
                                            : asset('default/profilePic.jpg');
                                    @endphp
                                    <img referrerpolicy="no-referrer" src="{{ $imageSrc }}" alt="avatar" class="w-100 h-100 object-fit-cover">
                                </div>
                            </a>
                            <ul class="py-2 mt-2 border-0 shadow-lg dropdown-menu dropdown-menu-end rounded-4" aria-labelledby="profileDropdown" style="min-width: 240px;">
                                <li class="px-3 py-2 mb-2 border-bottom">
                                    <span class="d-block fw-bold text-dark">{{ Auth::user()->name ?: Auth::user()->nickname }}</span>
                                    <span class="d-block small text-muted">{{ Auth::user()->email }}</span>
                                </li>
                                <li><a class="py-2 dropdown-item custom-drop-item" href="{{ route('userprofile#edit') }}"><i class="fa-regular fa-user me-3 text-muted"></i> Manage Profile</a></li>
                                <li><a class="py-2 dropdown-item custom-drop-item" href="{{ route('user#wishlist') }}"><i class="fa-regular fa-heart me-3 text-muted"></i> Wishlist</a></li>
                                <li><a class="py-2 dropdown-item custom-drop-item" href="{{ route('user#orders') }}"><i class="fa-solid fa-box-open me-3 text-muted"></i> Order History</a></li>
                                <li><hr class="my-2 dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="py-2 dropdown-item text-danger custom-drop-item"><i class="fa-solid fa-arrow-right-from-bracket me-3"></i> Sign out</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    @guest
        <div class="py-2 text-center text-white shadow-sm w-100"
            style="background-color: #1E3A5F; font-size: 0.85rem; font-weight: 500; z-index: 1000; position: relative;">
            Create an account for better product support, lifetime technical assistance, and exclusive flash deals!
            <a href="{{ route('register') }}" class="fw-bold ms-2 text-decoration-none" style="color: #FFBF00;">
                Sign Up Now <i class="fa-solid fa-arrow-right ms-1" style="font-size: 0.75rem;"></i>
            </a>
        </div>
    @endguest

    @yield('content')

    <footer class="site-footer advanced-footer">
        <div class="delivery-track">
            <i class="fa-solid fa-truck-fast delivery-truck"></i>
        </div>

        <div class="container pt-5 pb-2">
            <div class="row gy-4">
                <div class="col-lg-4 pe-lg-5">
                    <a class="gap-3 mb-4 navbar-brand d-inline-flex align-items-center text-decoration-none" href="{{ route('home') }}">
                        <img src="{{ asset('user/images/footerkhit.png') }}" alt="Khit PC Logo" style="height: 50px; width: auto; object-fit: contain; mix-blend-mode: lighten;">
                        <span class="fs-3 fw-bold text-uppercase" style="letter-spacing: 1.5px; color: #FFF9F5; margin-top: 5px;">Khit<span style="color: #D32F2F;">PC</span></span>
                    </a>
                    <p class="mb-4 text-muted" style="font-size: 0.9rem; line-height: 1.6;">Your trusted vendor for premium laptops and accessories. Experience fast, secure local delivery across Myanmar with lifetime technical support.</p>
                    <div class="gap-2 d-flex">
                        <a class="social-icon-btn" href="https://www.facebook.com/profile.php?id=61590207278065" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
    <i class="fa-brands fa-facebook-f"></i>
</a>
<a class="social-icon-btn" href="https://youtube.com/@khitpc2?si=NjHIdiGS0V1LTsdj" target="_blank" rel="noopener noreferrer" aria-label="YouTube">
    <i class="fa-brands fa-youtube"></i>
</a>
<a class="social-icon-btn" href="https://www.tiktok.com/@khitpc?is_from_webapp=1&sender_device=pc" target="_blank" rel="noopener noreferrer" aria-label="TikTok">
    <i class="fa-brands fa-tiktok"></i>
</a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-4">
                    <h6 class="mb-3 tracking-wider text-white fw-bold text-uppercase" style="font-size: 0.9rem;">Shop</h6>
                    <ul class="gap-2 list-unstyled footer-links d-flex flex-column" style="font-size: 0.9rem;">
                        <li><a href="{{ route('newarrivals') }}">New Arrivals</a></li>
                        <li><a href="{{ route('specialOffers') }}">Special Offers</a></li>
                        <li><a href="{{ route('mostPopular') }}">Most Popular</a></li>
                        <li><a href="{{ route('home') }}">All Products</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-4">
                    <h6 class="mb-3 tracking-wider text-white fw-bold text-uppercase" style="font-size: 0.9rem;">Contact Us</h6>
                    <ul class="gap-2 list-unstyled footer-links d-flex flex-column" style="font-size: 0.9rem;">
                        <li class="gap-3 d-flex align-items-start">
                            <i class="mt-1 fa-solid fa-location-dot text-danger"></i>
                            <span class="text-muted">No. X, Main St,<br>Yangon, Myanmar</span>
                        </li>
                        <li class="gap-3 d-flex align-items-center">
                            <i class="fa-solid fa-phone text-danger"></i>
                            <a href="tel:+959123456789">+95 9 123 456 789</a>
                        </li>
                        <li class="gap-3 d-flex align-items-center">
                            <i class="fa-solid fa-envelope text-danger"></i>
                            <a href="mailto:info@khitpc.com">info@khitpc.com</a>
                        </li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-4">
                    <h6 class="mb-3 tracking-wider text-white fw-bold text-uppercase" style="font-size: 0.9rem;">Why Choose Us</h6>
                    <div class="gap-2 d-flex flex-column">
                        <div class="gap-3 d-flex align-items-center text-muted">
                            <div class="feature-icon bg-dark text-danger rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height:32px;"><i class="fa-solid fa-shield-halved fs-6"></i></div>
                            <span class="small fw-semibold">Genuine Warranty</span>
                        </div>
                        <div class="gap-3 d-flex align-items-center text-muted">
                            <div class="feature-icon bg-dark text-danger rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height:32px;"><i class="fa-solid fa-headset fs-6"></i></div>
                            <span class="small fw-semibold">24/7 Tech Support</span>
                        </div>
                        <div class="gap-3 d-flex align-items-center text-muted">
                            <div class="feature-icon bg-dark text-danger rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height:32px;"><i class="fa-solid fa-truck-fast fs-6"></i></div>
                            <span class="small fw-semibold">Secure Delivery</span>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="mt-4 mb-3 border-opacity-50 border-secondary">

            <div class="pb-3 d-flex flex-column flex-md-row justify-content-between align-items-center text-muted" style="font-size: 0.85rem;">
                <div>&copy; <span id="currentYear">2026</span> Khit PC. All rights reserved.</div>
                <div class="gap-3 mt-2 d-flex mt-md-0">
                    <a href="#" class="text-muted text-decoration-none hover-white">Privacy Policy</a>
                    <span>&bull;</span>
                    <a href="#" class="text-muted text-decoration-none hover-white">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <button id="backToTop" class="btn btn-danger btn-lg" title="Back to top"
        style="position:fixed; right:18px; bottom:18px; display:none; z-index:1100;">
        <i class="fa-solid fa-arrow-up"></i>
    </button>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('user/js/home.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.8.0/vanilla-tilt.min.js"></script>
    <script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

     
            if (document.getElementById('hero-typed-text')) {
                new Typed('#hero-typed-text', {
                    strings: [
                        'Unlock Next-Level<br>Performance',
                        'Power to go<br>Anywhere',
                        'Studio Grade<br>Displays',
                        'Unbeatable Prices.<br>Guaranteed.'
                    ],
                    typeSpeed: 50,
                    backSpeed: 30,
                    backDelay: 3000,
                    loop: true,
                    showCursor: true,
                    cursorChar: '|'
                });
            }

     
            if (document.querySelector('.heroMainSwiper')) {
                new Swiper(".heroMainSwiper", {
                    loop: true,
                    autoplay: { delay: 5000, disableOnInteraction: false },
                    pagination: {
                        el: ".hero-pagination", clickable: true,
                        renderBullet: function(index, className) {
                            return '<span class="' + className + '"><span class="progress-bar"></span></span>';
                        },
                    },
                });
            }


            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                    }
                });
            }, { threshold: 0.1 });

            document.querySelectorAll('.reveal-on-scroll').forEach((el) => { observer.observe(el); });

            var swiperConfig = {
                slidesPerView: 1, spaceBetween: 20, grabCursor: true,
                pagination: { el: ".swiper-pagination", clickable: true },
                breakpoints: {
                    576: { slidesPerView: 2, spaceBetween: 20 },
                    992: { slidesPerView: 3, spaceBetween: 24 },
                    1200: { slidesPerView: 4, spaceBetween: 24 },
                },
            };

            if (document.querySelector('.newArrivalsSwiper')) {
                new Swiper(".newArrivalsSwiper", Object.assign({}, swiperConfig, {
                    navigation: { nextEl: ".swiper-next-new", prevEl: ".swiper-prev-new" }
                }));
            }

            if (document.querySelector('.hotDealsSwiper')) {
                new Swiper(".hotDealsSwiper", Object.assign({}, swiperConfig, {
                    navigation: { nextEl: ".swiper-next-hot", prevEl: ".swiper-prev-hot" }
                }));
            }

           
            let lastScrollTop = window.scrollY || document.documentElement.scrollTop;
            const navbar = document.querySelector('.glass-nav');
            const scrollThreshold = 500; 

            window.addEventListener('scroll', function() {
                let scrollTop = window.scrollY || document.documentElement.scrollTop;

              
                if (Math.abs(lastScrollTop - scrollTop) <= 10) return;

                if (scrollTop <= scrollThreshold) {
                    navbar.classList.remove('nav-hidden');
                } else if (scrollTop > lastScrollTop) {
                    navbar.classList.add('nav-hidden');
                } else if (scrollTop < lastScrollTop) {
                    navbar.classList.remove('nav-hidden');
                }

                lastScrollTop = Math.max(0, scrollTop);
            }, { passive: true });

            document.querySelectorAll('.add-to-cart-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

        
                    if (navbar.classList.contains('nav-hidden')) {
                        navbar.classList.remove('nav-hidden');
                        lastScrollTop = window.scrollY || document.documentElement.scrollTop;
                    }

                    const btn = form.querySelector('button[type="submit"]');
                    const text = btn.querySelector('span');
                    const icon = btn.querySelector('i');
                    const navCart = document.getElementById('nav-cart-icon');
                    const origText = text.innerHTML;
                    const origIcon = icon.className;

                    if (navCart) {
                        const btnRect = btn.getBoundingClientRect();
                        const cartRect = navCart.getBoundingClientRect();
                        const navRect = navbar.getBoundingClientRect();

                        const flyingDot = document.createElement('div');
                        flyingDot.classList.add('flying-cart-dot');

                        flyingDot.style.left = `${btnRect.left + (btnRect.width / 2) - 8}px`;
                        flyingDot.style.top = `${btnRect.top + (btnRect.height / 2) - 8}px`;
                        document.body.appendChild(flyingDot);

                        const finalCartY = (cartRect.top - navRect.top) + (cartRect.height / 2);
                        const finalCartX = cartRect.left + (cartRect.width / 2);

                        flyingDot.getBoundingClientRect();

                        requestAnimationFrame(() => {
                            requestAnimationFrame(() => {
                                flyingDot.style.left = `${finalCartX - 8}px`;
                                flyingDot.style.top = `${finalCartY - 8}px`;
                                flyingDot.style.opacity = '0.5';
                                flyingDot.style.transform = 'scale(0.5)';
                            });
                        });

                        setTimeout(() => {
                            flyingDot.remove();
                            navCart.classList.add('cart-bump');
                            setTimeout(() => navCart.classList.remove('cart-bump'), 400);
                        }, 1500);
                    }

              
                    btn.disabled = true;
                    icon.className = 'fa-solid fa-circle-notch fa-spin me-2';
                    text.innerHTML = 'Wait...';

                    fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json' 
                            },
                            body: new FormData(form)
                        })
                        .then(async res => {
                         
                            const data = await res.json().catch(() => ({}));

                   
                            if (!res.ok) {
                                throw { status: res.status, data: data };
                            }

                       
                            btn.style.setProperty('background-color', '#10b981', 'important');
                            btn.style.setProperty('border-color', '#10b981', 'important');
                            btn.style.setProperty('color', '#ffffff', 'important');
                            icon.className = 'fa-solid fa-check me-2';
                            text.innerHTML = 'Added';

                            setTimeout(() => {
                                btn.style.removeProperty('background-color');
                                btn.style.removeProperty('border-color');
                                btn.style.removeProperty('color');
                                btn.disabled = false;
                                icon.className = origIcon;
                                text.innerHTML = origText;
                            }, 2000);
                        })
                       .catch((err) => {
                      
                            btn.style.removeProperty('background-color');
                            btn.style.removeProperty('border-color');
                            btn.style.removeProperty('color');
                            btn.disabled = false;
                            icon.className = origIcon;
                            text.innerHTML = origText;

                          
                            if (err.status === 422 && err.data && err.data.limit_reached) {
                                Swal.fire({
                                    html: `
                                        <div class="px-2 pt-3 pb-1 text-center">
                                            <div class="mx-auto mb-4 position-relative d-flex align-items-center justify-content-center"
                                                 style="width: 80px; height: 80px; background: rgba(28, 42, 63, 0.05); border-radius: 50%; border: 1px solid rgba(28, 42, 63, 0.1);">
                                                <i class="fa-solid fa-bag-shopping" style="font-size: 2.2rem; color: #1E3A5F;"></i>
                                                <span class="position-absolute translate-middle badge rounded-pill bg-danger border border-white border-2"
                                                      style="top: 25px; left: 80%; font-size: 0.65rem; padding: 4px 6px;">
                                                    MAX
                                                </span>
                                            </div>
                                            <h4 class="mb-2 fw-bold text-navy" style="letter-spacing: -0.5px;">Cart Limit Reached</h4>
                                            <p class="text-muted" style="font-size: 0.95rem; line-height: 1.6;">${err.data.message}</p>
                                        </div>
                                    `,
                                    showConfirmButton: true,
                                    confirmButtonText: 'Got it',
                                    buttonsStyling: false,
                                    background: '#ffffff',
                                    width: '26em',
                                    backdrop: 'rgba(28, 42, 63, 0.7)',
                                    customClass: {
                                        popup: 'rounded-4 shadow-lg border-0',
                                        confirmButton: 'btn btn-navy px-5 py-2 mb-2 fw-bold rounded-3 shadow-sm'
                                    }
                                });
                            } 
                       
                            else if (err.status === 422 && err.data && err.data.out_of_stock) {
                                Swal.fire({
                                    html: `
                                        <div class="px-2 pt-3 pb-1 text-center">
                                            <div class="mx-auto mb-4 position-relative d-flex align-items-center justify-content-center"
                                                 style="width: 80px; height: 80px; background: rgba(211, 47, 47, 0.05); border-radius: 50%; border: 1px solid rgba(211, 47, 47, 0.1);">
                                                <i class="fa-solid fa-box-open" style="font-size: 2.2rem; color: #D32F2F;"></i>
                                                <span class="position-absolute translate-middle badge rounded-pill bg-dark border border-white border-2"
                                                      style="top: 25px; left: 80%; font-size: 0.65rem; padding: 4px 6px;">
                                                    0
                                                </span>
                                            </div>
                                            <h4 class="mb-2 fw-bold text-navy" style="letter-spacing: -0.5px;">Out of Stock</h4>
                                            <p class="text-muted" style="font-size: 0.95rem; line-height: 1.6;">${err.data.message}</p>
                                        </div>
                                    `,
                                    showConfirmButton: true,
                                    confirmButtonText: 'Got it',
                                    buttonsStyling: false,
                                    background: '#ffffff',
                                    width: '26em',
                                    backdrop: 'rgba(28, 42, 63, 0.7)',
                                    customClass: {
                                        popup: 'rounded-4 shadow-lg border-0',
                                        confirmButton: 'btn btn-navy px-5 py-2 mb-2 fw-bold rounded-3 shadow-sm'
                                    }
                                });
                            }
                          
                            else {
                           
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Failed to add to cart. Please try again.',
                                    confirmButtonColor: '#D32F2F',
                                    borderRadius: '16px'
                                });
                            }
                        });
                });
            });
        });
    </script>
</body>

</html>
