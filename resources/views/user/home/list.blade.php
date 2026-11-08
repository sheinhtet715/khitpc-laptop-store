@extends('user.layouts.master')

@section('content')

    <style>
   
        .premium-pagination .pagination {
            gap: 8px;
            align-items: center;
        }
        .premium-pagination .page-item:first-child .page-link,
        .premium-pagination .page-item:last-child .page-link {
            border-radius: 8px;
        }
        .premium-pagination .page-link {
            border-radius: 8px;
            border: 1px solid rgba(30, 58, 95, 0.15);
            color: #1E3A5F;
            font-weight: 600;
            padding: 0.5rem 1rem;
            transition: all 0.2s ease;
            background-color: #fff;
        }
        .premium-pagination .page-link:hover {
            background-color: #1E3A5F;
            color: #fff;
            border-color: #1E3A5F;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(30, 58, 95, 0.2);
        }
        .premium-pagination .page-item.active .page-link {
            background-color: #D32F2F; /* Premium Red */
            border-color: #D32F2F;
            color: #fff;
            box-shadow: 0 4px 10px rgba(211, 47, 47, 0.3);
        }
        .premium-pagination .page-item.disabled .page-link {
            background-color: #f8fafc;
            color: #adb5bd;
            border-color: #e9ecef;
            box-shadow: none;
            transform: none;
        }
    </style>

    <div class="border-2 position-relative w-100 border-bottom border-danger"
        style="height: 550px; background-color: #0f172a;">

        <div class="top-0 pointer-events-none position-absolute start-0 w-100 h-100 d-flex align-items-center z-3">
            <div class="container">
                <div class="p-5 pointer-events-auto ms-md-5">
                    <h5 class="mb-3 tracking-wider text-danger fw-bold">_2026 PREMIUM LINEUP_</h5>
                    <h1 class="mb-3 text-white display-4 fw-bold text-uppercase"
                        style="letter-spacing: -1px; text-shadow: 0 4px 20px rgba(0,0,0,0.8); min-height: 120px;">
                        <span id="hero-typed-text"></span>
                    </h1>
                    <p class="mb-4 text-white opacity-75 lead"
                        style="max-width: 600px; text-shadow: 0 2px 10px rgba(0,0,0,0.8);">Featuring NVIDIA® GeForce RTX™ 50
                        Series Laptop GPUs</p>
                    <div>
                        <a href="#all-products" class="px-4 py-2 btn btn-outline-light rounded-pill fw-bold text-uppercase"
                            style="border-width: 2px;">Shop Collection <i class="fa-solid fa-arrow-down ms-2"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="swiper heroMainSwiper w-100 h-100 z-1">
            <div class="swiper-wrapper">
                <div class="swiper-slide bg-dark">
                    <img src="{{ asset('user/lapimage/camera-photography-design-studio-editing-concept.jpg') }}"
                        alt="Slide 1" class="top-0 w-100 h-100 object-fit-cover position-absolute start-0"
                        style="opacity: 0.5;">
                </div>
                <div class="swiper-slide bg-dark">
                    <img src="{{ asset('user/lapimage/laptop-takeaway-coffee-car-s-hood-with-beautiful-natural-scenery-background.jpg') }}"
                        alt="Slide 2" class="top-0 w-100 h-100 object-fit-cover position-absolute start-0"
                        style="opacity: 0.5;">
                </div>
                <div class="swiper-slide bg-dark">
                    <img src="{{ asset('user/lapimage/opened-notebook-near-laptop.jpg') }}" alt="Slide 3"
                        class="top-0 w-100 h-100 object-fit-cover position-absolute start-0" style="opacity: 0.5;">
                </div>
                <div class="swiper-slide bg-dark">
                    <img src="{{ asset('user/lapimage/top-view-laptop-smartphone-arrangement.jpg') }}" alt="Slide 4"
                        class="top-0 w-100 h-100 object-fit-cover position-absolute start-0" style="opacity: 0.5;">
                </div>
            </div>
            <div class="swiper-pagination hero-pagination"></div>
        </div>
    </div>

    <main class="container my-5">

        <div class="mb-5 row g-3 bento-container">
            <div class="col-12 col-md-7 bento-item">
                <div class="overflow-hidden shadow-sm bento-card bg-dark rounded-4 position-relative h-100 reveal-on-scroll"
                    onclick="window.location.href='#all-products'" data-tilt data-tilt-max="3" data-tilt-speed="400"
                    data-tilt-perspective="1000">
                    <div class="bento-bg"
                        style="background-color: #1a1a2e; background-image: url('{{ asset('user/images/LekCjjpyVoWeFAJwZ79Tzc-970-80.jpg.webp') }}');">
                    </div>
                    <div class="bento-gradient"></div>
                    <div class="bottom-0 p-5 bento-content position-absolute start-0 w-100 z-2"
                        style="transform: translateZ(30px);">
                        <span class="mb-2 shadow-sm badge bg-danger rounded-pill">Gamer's Choice</span>
                        <h2 class="mb-2 text-white fw-bold">Unleash the Beast.</h2>
                        <a href="{{ route('home') }}" class="text-white text-decoration-none fw-bold hover-lift">Shop Gaming
                            Laptops <i class="transition-transform ms-1 fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-5">
                <div class="row g-3 h-100">
                    <div class="col-12 h-50 bento-item">
                        <div class="overflow-hidden shadow-sm bento-card bg-primary rounded-4 position-relative h-100 reveal-on-scroll"
                            style="animation-delay: 0.1s;" onclick="window.location.href='#all-products'" data-tilt
                            data-tilt-max="4" data-tilt-speed="400">
                            <div class="bento-bg"
                                style="background-color: #0f172a; background-image: url('{{ asset('user/images/article_cover.jpg') }}');">
                            </div>
                            <div class="bento-gradient"></div>
                            <div class="bottom-0 p-4 bento-content position-absolute start-0 w-100 z-2"
                                style="transform: translateZ(20px);">
                                <h4 class="mb-1 text-white fw-bold">For Creators</h4>
                                <a href="{{ route('home') }}"
                                    class="text-white-50 text-decoration-none small hover-lift">Explore Studio PCs <i
                                        class="transition-transform ms-1 fa-solid fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 h-50 bento-item">
                        <div class="overflow-hidden shadow-sm bento-card bg-info rounded-4 position-relative h-100 reveal-on-scroll"
                            style="animation-delay: 0.2s;" onclick="window.location.href='#all-products'" data-tilt
                            data-tilt-max="4" data-tilt-speed="400">
                            <div class="bento-bg"
                                style="background-color: #334155; background-image: url('{{ asset('user/images/Acer-Predator-21X-1b.jpg') }}');">
                            </div>
                            <div class="bento-gradient"></div>
                            <div class="bottom-0 p-4 bento-content position-absolute start-0 w-100 z-2"
                                style="transform: translateZ(20px);">
                                <h4 class="mb-1 text-white fw-bold">Ultra-Portable</h4>
                                <a href="{{ route('home') }}"
                                    class="text-white-50 text-decoration-none small hover-lift">Work Anywhere <i
                                        class="transition-transform ms-1 fa-solid fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if (isset($newArrivals) && $newArrivals->count() > 0)
            <div class="pt-3 mb-5 gsap-product-row">
                <div class="mb-4 d-flex justify-content-between align-items-end">
                    <div>
                        <h3 class="mb-1 fw-bold text-dark" style="letter-spacing: -0.5px;">Fresh Drops</h3>
                        <p class="mb-0 text-muted">The latest, most cutting-edge tech just landed.</p>
                    </div>
                    <div class="gap-2 d-flex align-items-center">
                        <a href="{{ route('newarrivals') }}" class="text-danger fw-bold text-decoration-none hover-lift me-md-2 small text-uppercase">View All <i class="fa-solid fa-arrow-right ms-1"></i></a>
                        <button class="border-opacity-50 btn btn-outline-secondary rounded-circle swiper-prev-new"
                            style="width: 40px; height: 40px;"><i class="fa-solid fa-arrow-left"></i></button>
                        <button class="border-opacity-50 btn btn-outline-secondary rounded-circle swiper-next-new"
                            style="width: 40px; height: 40px;"><i class="fa-solid fa-arrow-right"></i></button>
                    </div>
                </div>

                <div class="pb-4 swiper newArrivalsSwiper">
                    <div class="swiper-wrapper">
                        @foreach ($newArrivals as $index => $product)
                            <div class="h-auto swiper-slide">
                                <div class="premium-product-card position-relative h-100" data-tilt data-tilt-max="5"
                                    data-tilt-speed="400" data-tilt-glare="true" data-tilt-max-glare="0.2">
                                    @php $discount = floatval($product->discount_percent ?? 0); @endphp
                                    @if ($discount > 0)
                                        <span class="premium-badge position-absolute" style="top:12px; left:12px;">SAVE
                                            {{ intval($discount) }}%</span>
                                    @endif

                                    <div class="premium-product-thumb">
                                        @php $img = $product->product_image ? asset('productImage/' . $product->product_image) : asset('default/default_image.webp'); @endphp
                                        <a href="{{ route('user#productDetails', $product->id) }}"
                                            class="d-block w-100 h-100">
                                            <img src="{{ $img }}" alt="{{ $product->product_name }}">
                                        </a>
                                    </div>

                                    <div class="premium-card-body">
                                        <div class="mb-3">
                                            <div class="premium-card-title text-truncate"
                                                title="{{ $product->product_name }}">{{ $product->product_name }}</div>
                                            <div class="text-muted small" style="font-weight: 500;">
                                                {{ $product->brand_name ?? 'Brand' }} •
                                                {{ $product->category_name ?? 'Category' }}</div>
                                        </div>

                                        <div class="mb-3 d-flex justify-content-between align-items-end">
                                            <div>
                                                @php
                                                    $original = floatval($product->product_price);
                                                    $discounted =
                                                        $discount > 0
                                                            ? round($original * (1 - $discount / 100))
                                                            : $original;
                                                @endphp
                                                <div class="premium-price-tag">K{{ number_format($discounted) }}</div>
                                                @if ($discount > 0)
                                                    <div class="small text-muted text-decoration-line-through">
                                                        K{{ number_format($original) }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="mt-auto premium-actions">
                                            <a href="{{ route('user#productDetails', $product->id) }}"
                                                class="btn btn-premium-view btn-sm flex-fill"><i
                                                    class="fa-solid fa-magnifying-glass me-1"></i> View</a>
                                            @auth
                                                @if(($product->stock_quantity ?? 0) > 0)
    <form action="{{ route('user#addToCart') }}" method="POST" class="p-0 m-0 d-inline-flex flex-fill add-to-cart-form">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id ?? $product->product_id }}">
        <input type="hidden" name="quantity" value="1">
        <button type="submit" class="btn btn-premium-add btn-sm flex-fill add-btn">
            <i class="fa-solid fa-cart-shopping me-1"></i> <span>Add</span>
        </button>
    </form>
@else
    <div class="p-0 m-0 d-inline-flex flex-fill">
        <button type="button" class="btn btn-secondary btn-sm flex-fill fw-bold" style="background-color: #e9ecef; color: #6c757d; border-color: #dee2e6; pointer-events: none;" disabled>
            <i class="fa-solid fa-box-open me-1"></i> <span style="font-size: 0.85rem;">Out of Stock</span>
        </button>
    </div>
@endif
                                            @else
                                                <a href="{{ route('login') }}"
                                                    class="btn btn-outline-danger btn-sm flex-fill d-inline-flex justify-content-center align-items-center"
                                                    style="border-radius: 8px; font-weight: 600;"><i
                                                        class="fa-solid fa-lock me-1"></i> Sign in</a>
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4 swiper-pagination position-relative"></div>
                </div>
            </div>
        @endif

        <div class="mb-5 overflow-hidden rounded-4 position-relative d-flex align-items-center reveal-on-scroll"
            style="background: linear-gradient(135deg, #1E3A5F 0%, #112540 100%); min-height: 250px; border: 1px solid rgba(212, 163, 115, 0.3); box-shadow: 0 25px 45px -10px rgba(30, 58, 95, 0.5), 0 10px 30px -5px rgba(212, 163, 115, 0.35);">

            <div class="pointer-events-none"
                style="position: absolute; top: -50%; left: -10%; width: 300px; height: 300px; background: rgba(212, 163, 115, 0.15); filter: blur(60px); border-radius: 50%; z-index: 0;">
            </div>

            <div class="m-0 row w-100 align-items-center position-relative z-1">
                <div class="p-5 col-12 col-md-8">
                    <span class="mb-3 text-white shadow-sm badge rounded-pill"
                        style="background: linear-gradient(135deg, #D32F2F 0%, #B02323 100%); border: 1px solid rgba(255,255,255,0.2);">About
                        Khit PC</span>

                    <h3 class="mb-3 text-white fw-bold" style="letter-spacing: -0.5px;">Your Trusted Tech Partner in
                        Myanmar.</h3>
                    <p class="mb-0 text-white opacity-75" style="max-width: 600px; font-weight: 500;">We believe in
                        providing more than just hardware. We deliver lifetime technical support, guaranteed authentic
                        products, and a commitment to powering your digital lifestyle.</p>
                </div>
                <div class="p-5 text-center col-12 col-md-4 text-md-end">
                    <i class="fa-solid fa-microchip"
                        style="color: rgba(212, 163, 115, 0.15); font-size: 8rem; position: absolute; right: 20px; bottom: -20px; transform: rotate(-10deg);"></i>
                </div>
            </div>
        </div>

        @if (isset($specialOffers) && $specialOffers->count() > 0)
            <div class="pt-3 mb-5 gsap-product-row">
                <div class="mb-4 d-flex justify-content-between align-items-end">
                    <div>
                        <h3 class="mb-1 fw-bold text-dark" style="letter-spacing: -0.5px;"><i
                                class="fa-solid fa-fire text-danger me-2"></i>Hot Deals</h3>
                        <p class="mb-0 text-muted">Unbeatable prices on premium hardware. Limited time only.</p>
                    </div>
                    <div class="gap-2 d-flex align-items-center">
                        <a href="{{ route('specialOffers') }}" class="text-danger fw-bold text-decoration-none hover-lift me-md-2 small text-uppercase">View All <i class="fa-solid fa-arrow-right ms-1"></i></a>
                        <button class="border-opacity-50 btn btn-outline-secondary rounded-circle swiper-prev-hot"
                            style="width: 40px; height: 40px;"><i class="fa-solid fa-arrow-left"></i></button>
                        <button class="border-opacity-50 btn btn-outline-secondary rounded-circle swiper-next-hot"
                            style="width: 40px; height: 40px;"><i class="fa-solid fa-arrow-right"></i></button>
                    </div>
                </div>

                <div class="pb-4 swiper hotDealsSwiper">
                    <div class="swiper-wrapper">
                        @foreach ($specialOffers as $index => $product)
                            <div class="h-auto swiper-slide">
                                <div class="premium-product-card position-relative h-100" data-tilt data-tilt-max="5"
                                    data-tilt-speed="400" data-tilt-glare="true" data-tilt-max-glare="0.2">
                                    @php $discount = floatval($product->discount_percent ?? 0); @endphp
                                    @if ($discount > 0)
                                        <span class="premium-badge position-absolute" style="top:12px; left:12px;">SAVE
                                            {{ intval($discount) }}%</span>
                                    @endif

                                    <div class="premium-product-thumb">
                                        @php $img = $product->product_image ? asset('productImage/' . $product->product_image) : asset('default/default_image.webp'); @endphp
                                        <a href="{{ route('user#productDetails', $product->id) }}"
                                            class="d-block w-100 h-100">
                                            <img src="{{ $img }}" alt="{{ $product->product_name }}">
                                        </a>
                                    </div>

                                    <div class="premium-card-body">
                                        <div class="mb-3">
                                            <div class="premium-card-title text-truncate"
                                                title="{{ $product->product_name }}">{{ $product->product_name }}</div>
                                            <div class="text-muted small" style="font-weight: 500;">
                                                {{ $product->brand_name ?? 'Brand' }} •
                                                {{ $product->category_name ?? 'Category' }}</div>
                                        </div>

                                        <div class="mb-3 d-flex justify-content-between align-items-end">
                                            <div>
                                                @php
                                                    $original = floatval($product->product_price);
                                                    $discounted =
                                                        $discount > 0
                                                            ? round($original * (1 - $discount / 100))
                                                            : $original;
                                                @endphp
                                                <div class="premium-price-tag">K{{ number_format($discounted) }}</div>
                                                @if ($discount > 0)
                                                    <div class="small text-muted text-decoration-line-through">
                                                        K{{ number_format($original) }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="mt-auto premium-actions">
                                            <a href="{{ route('user#productDetails', $product->id) }}"
                                                class="btn btn-premium-view btn-sm flex-fill"><i
                                                    class="fa-solid fa-magnifying-glass me-1"></i> View</a>
                                            @auth
                                                <form action="{{ route('user#addToCart') }}" method="POST"
                                                    class="p-0 m-0 d-inline-flex flex-fill add-to-cart-form">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                    <input type="hidden" name="quantity" value="1">
                                                    <button type="submit"
                                                        class="btn btn-premium-add btn-sm flex-fill add-btn"><i
                                                            class="fa-solid fa-cart-shopping me-1"></i>
                                                        <span>Add</span></button>
                                                </form>
                                            @else
                                                <a href="{{ route('login') }}"
                                                    class="btn btn-outline-danger btn-sm flex-fill d-inline-flex justify-content-center align-items-center"
                                                    style="border-radius: 8px; font-weight: 600;"><i
                                                        class="fa-solid fa-lock me-1"></i> Sign in</a>
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4 swiper-pagination position-relative"></div>
                </div>
            </div>
        @endif

        <div class="py-5 mb-5 overflow-hidden border shadow-sm position-relative rounded-4 reveal-on-scroll"
            style="background: linear-gradient(135deg, #F3EAE3 0%, #FFF9F5 100%); border-color: rgba(212, 163, 115, 0.2) !important;">
            <div class="mb-4 text-center position-relative z-2">
                <h3 class="mb-1 fw-bold" style="color: #1F2937;">Loved by Customers</h3>
                <div class="fs-5" style="color: #FFBF00;"> <i class="fa-solid fa-star"></i><i
                        class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                        class="fa-solid fa-star"></i>
                </div>
            </div>

            <div class="marquee-fade left"></div>
            <div class="marquee-fade right"></div>

            <div class="mt-4 testimonial-marquee-container">
                <div class="testimonial-track">

                    @forelse($featuredReviews as $review)
                        <div class="testimonial-card">
                            <p class="mb-2 fw-bold" style="color: #1F2937;">"{{ Str::limit($review->review_text, 60) }}"</p>
                            <div class="mb-1" style="color: #FFBF00; font-size: 0.8rem;">
                                @for($i = 0; $i < $review->rating; $i++)
                                    <i class="fa-solid fa-star"></i>
                                @endfor
                            </div>
                            <p class="mb-0 small" style="color: rgba(31, 41, 55, 0.7);">- {{ $review->user->name ?? 'Happy Customer' }}</p>
                        </div>
                    @empty
                        <div class="testimonial-card">
                            <p class="mb-2 fw-bold" style="color: #1F2937;">"Best laptop buying experience."</p>
                            <p class="mb-0 small" style="color: rgba(31, 41, 55, 0.7);">- Khit PC Team</p>
                        </div>
                    @endforelse

                    @foreach($featuredReviews as $review)
                        <div class="testimonial-card" aria-hidden="true">
                            <p class="mb-2 fw-bold" style="color: #1F2937;">"{{ Str::limit($review->review_text, 60) }}"</p>
                            <div class="mb-1" style="color: #FFBF00; font-size: 0.8rem;">
                                @for($i = 0; $i < $review->rating; $i++)
                                    <i class="fa-solid fa-star"></i>
                                @endfor
                            </div>
                            <p class="mb-0 small" style="color: rgba(31, 41, 55, 0.7);">- {{ $review->user->name ?? 'Happy Customer' }}</p>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>

        <div class="p-5 mb-5 overflow-hidden text-center rounded-4 position-relative reveal-on-scroll"
            style="background: linear-gradient(135deg, #1E3A5F 0%, #112540 100%); border: 1px solid rgba(211, 47, 47, 0.2); box-shadow: 0 25px 45px -10px rgba(30, 58, 95, 0.6), 0 15px 35px -5px rgba(211, 47, 47, 0.35);">

            <div class="pointer-events-none"
                style="position: absolute; top: -30%; right: -5%; width: 300px; height: 300px; background: rgba(211, 47, 47, 0.15); filter: blur(60px); border-radius: 50%; z-index: 0;">
            </div>
            <div class="pointer-events-none"
                style="position: absolute; bottom: -30%; left: -5%; width: 250px; height: 250px; background: rgba(212, 163, 115, 0.1); filter: blur(50px); border-radius: 50%; z-index: 0;">
            </div>

            <div class="position-relative z-1">
                <i class="mb-3 fa-solid fa-headset" style="font-size: 3rem; color: #FFBF00;"></i>

                <h3 class="mb-2 text-white fw-bold" style="letter-spacing: -0.5px;">Need help finding the right setup?
                </h3>
                <p class="mx-auto mb-4" style="max-width: 500px; color: rgba(255, 255, 255, 0.7); font-weight: 500;">Our
                    technical experts are standing by to help you pick the perfect laptop for your specific needs and
                    budget.</p>
                <div class="gap-3 d-flex justify-content-center">

                    <a href="https://t.me/khitpc" target="_blank"
                        class="px-4 py-2 btn rounded-pill fw-bold hover-lift btn-outline-premium-red">
                        <i class="fa-brands fa-telegram me-2"></i> Chat on Telegram
                    </a>

                    <a href="tel:+959123456789"
                        class="px-4 py-2 btn rounded-pill fw-bold hover-lift btn-outline-premium-gold">
                        <i class="fa-solid fa-phone me-2"></i> Call Support
                    </a>

                </div>
            </div>
        </div>
        <div id="all-products" class="pt-5 border-top border-secondary-subtle">

            <div class="mb-5 text-center reveal-on-scroll">
                <h2 class="fw-bold text-dark">Browse All Laptops</h2>
                <p class="text-muted">Use the filters below to find exactly what you are looking for.</p>
            </div>

            <div class="mb-4 brand-scroll-container">
                <div class="gap-2 pb-2 overflow-auto d-flex brand-chip-track hide-scrollbar justify-content-lg-center">
                    <a href="{{ route('home', request()->except('brand', 'page')) }}"
                        class="brand-chip {{ request()->has('brand') ? '' : 'active' }}">All Brands</a>
                    @foreach ($brands as $brand)
                        <a href="{{ route('home', array_merge(request()->except('page'), ['brand' => $brand->brand_id])) }}"
                            class="brand-chip {{ (string) request('brand') === (string) $brand->brand_id ? 'active' : '' }}">
                            {{ $brand->brand_name }}
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="flex-wrap mb-5 d-flex align-items-center justify-content-between premium-filter-bar"
                style="z-index: 50;">
                <form method="get" action="{{ route('home') }}"
                    class="flex-wrap gap-2 d-flex align-items-center flex-grow-1">
                    @php
                        $selectedCategory = $categories->firstWhere('category_id', request('category'));
                        $categoryLabel = $selectedCategory->category_name ?? 'All Categories';

                        $sortLabels = [
                            'new' => 'Newest',
                            'price_asc' => 'Price: Low → High',
                            'price_desc' => 'Price: High → Low',
                        ];
                        $currentSort = request('sort', 'new');
                        $sortLabel = $sortLabels[$currentSort] ?? 'Newest';
                    @endphp

                    <div class="dropdown">
                        <button
                            class="btn btn-outline-secondary btn-sm dropdown-toggle d-flex justify-content-between align-items-center"
                            style="width: 180px; height: 36px;" type="button" data-bs-toggle="dropdown">
                            <span><i class="fa-solid fa-arrow-down-a-z me-1 text-muted"></i> {{ $sortLabel }}</span>
                        </button>
                        <ul class="border-0 shadow-sm dropdown-menu rounded-3" style="width: 180px;">
                            <li><a class="dropdown-item {{ $currentSort == 'new' ? 'active' : '' }}"
                                    href="{{ route('home', array_merge(request()->except('page'), ['sort' => 'new'])) }}">Newest</a>
                            </li>
                            <li><a class="dropdown-item {{ $currentSort == 'price_asc' ? 'active' : '' }}"
                                    href="{{ route('home', array_merge(request()->except('page'), ['sort' => 'price_asc'])) }}">Price:
                                    Low → High</a></li>
                            <li><a class="dropdown-item {{ $currentSort == 'price_desc' ? 'active' : '' }}"
                                    href="{{ route('home', array_merge(request()->except('page'), ['sort' => 'price_desc'])) }}">Price:
                                    High → Low</a></li>
                        </ul>
                    </div>

                    <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" style="height: 36px;"
                            type="button" data-bs-toggle="dropdown">
                            <i class="fa-solid fa-layer-group me-1 text-muted"></i> {{ $categoryLabel }}
                        </button>
                        <ul class="border-0 shadow-sm dropdown-menu rounded-3">
                            <li><a class="dropdown-item {{ request()->has('category') ? '' : 'active' }}"
                                    href="{{ route('home', request()->except('category', 'page')) }}">All Categories</a>
                            </li>
                            @foreach ($categories as $category)
                                <li><a class="dropdown-item {{ (string) request('category') === (string) $category->category_id ? 'active' : '' }}"
                                        href="{{ route('home', array_merge(request()->except('page'), ['category' => $category->category_id])) }}">{{ $category->category_name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </form>

                <form class="mt-3 d-flex align-items-center search-form ms-lg-auto mt-lg-0" role="search">
                    <div class="shadow-sm input-group" style="border-radius: 8px; overflow: hidden;">
                        <span class="bg-white border-0 input-group-text text-muted"><i
                                class="fa-solid fa-magnifying-glass"></i></span>
                        <input class="border-0 shadow-none form-control ps-0" style="height: 36px;" type="search"
                            name="searchKey" value="{{ request('searchKey') }}" placeholder="Search laptops...">
                        <button class="px-3 border-0 btn btn-danger fw-bold" style="height: 36px;"
                            type="submit">Search</button>
                    </div>
                </form>
            </div>

            <div class="row g-4 gsap-product-row">
                @forelse ($products as $index => $product)
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="premium-product-card position-relative" data-tilt data-tilt-max="5"
                            data-tilt-speed="400" data-tilt-glare="true" data-tilt-max-glare="0.1">

                            @php $discount = floatval($product->discount_percent ?? 0); @endphp
                            @if ($discount > 0)
                                <span class="premium-badge position-absolute" style="top:12px; left:12px;">SAVE
                                    {{ intval($discount) }}%</span>
                            @endif

                            <div class="premium-product-thumb">
                                @php $img = $product->product_image ? asset('productImage/' . $product->product_image) : asset('default/default_image.webp'); @endphp
                                <a href="{{ route('user#productDetails', $product->id) }}" class="d-block w-100 h-100">
                                    <img src="{{ $img }}" alt="{{ $product->product_name }}">
                                </a>
                            </div>

                            <div class="premium-card-body">
                                <div class="mb-3">
                                    <div class="premium-card-title text-truncate" title="{{ $product->product_name }}">
                                        {{ $product->product_name }}</div>
                                    <div class="text-muted small" style="font-weight: 500;">
                                        {{ $product->brand_name ?? 'Brand' }} •
                                        {{ $product->category_name ?? 'Category' }}</div>
                                </div>

                                <div class="mb-3 d-flex justify-content-between align-items-end">
                                    <div>
                                        @php
                                            $original = floatval($product->product_price);
                                            $discounted =
                                                $discount > 0 ? round($original * (1 - $discount / 100)) : $original;
                                        @endphp
                                        <div class="premium-price-tag">K{{ number_format($discounted) }}</div>
                                        @if ($discount > 0)
                                            <div class="small text-muted text-decoration-line-through">
                                                K{{ number_format($original) }}</div>
                                        @endif
                                    </div>

                                    <div class="text-end">
                                        @php
                                            $avgRating = number_format($product->reviews_avg_rating ?? 0, 1);
                                            $reviewCount = $product->reviews_count ?? 0;
                                            $fullStars = floor($avgRating);
                                            $hasHalfStar =
                                                $avgRating - $fullStars >= 0.25 && $avgRating - $fullStars < 0.75;
                                            $emptyStars = 5 - ($fullStars + ($hasHalfStar ? 1 : 0));
                                        @endphp

                                        <div class="mb-1 star-sm">
                                            @if ($reviewCount > 0)
                                                @for ($i = 0; $i < $fullStars; $i++)
                                                    <i class="fa-solid fa-star text-warning"></i>
                                                @endfor
                                                @if ($hasHalfStar)
                                                    <i class="fa-solid fa-star-half-stroke text-warning"></i>
                                                @endif
                                                @for ($i = 0; $i < $emptyStars; $i++)
                                                    <i class="fa-regular fa-star text-warning"></i>
                                                @endfor
                                            @else
                                                @for ($i = 0; $i < 5; $i++)
                                                    <i class="opacity-50 fa-regular fa-star text-muted"></i>
                                                @endfor
                                            @endif
                                        </div>
                                        <div class="meta" style="font-size:0.75rem; font-weight: 500;">
                                            <i class="fa-solid fa-eye me-1"></i>{{ number_format($product->views_count) }}
                                            @if ($reviewCount > 0)
                                            &bull; {{ number_format($reviewCount) }}
                                            {{ $reviewCount == 1 ? 'review' : 'reviews' }}
                                        @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-auto premium-actions">
                                    <a href="{{ route('user#productDetails', $product->id) }}"
                                        class="btn btn-premium-view btn-sm flex-fill"><i
                                            class="fa-solid fa-magnifying-glass me-1"></i> View</a>
                                    @auth
                                        <form action="{{ route('user#addToCart') }}" method="POST"
                                            class="p-0 m-0 d-inline-flex flex-fill add-to-cart-form">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="btn btn-premium-add btn-sm flex-fill add-btn"><i
                                                    class="fa-solid fa-cart-shopping me-1"></i> <span>Add</span></button>
                                        </form>
                                    @else
                                        <a href="{{ route('login') }}"
                                            class="btn btn-outline-danger btn-sm flex-fill d-inline-flex justify-content-center align-items-center"
                                            style="border-radius: 8px; font-weight: 600;"><i
                                                class="fa-solid fa-lock me-1"></i> Sign in</a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="py-5 text-center col-12">
                        <div class="p-5 bg-white border shadow-sm rounded-4">
                            <i class="mb-3 opacity-50 fa-solid fa-laptop-slash fs-1 text-muted"></i>
                            <h5 class="fw-bold text-dark">No laptops found</h5>
                            <p class="text-muted">Try adjusting your filters or searching for something else.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <nav class="mt-5" aria-label="Page navigation">
                <div class="d-flex justify-content-center premium-pagination">
                    {!! $products->withQueryString()->links('pagination::bootstrap-5') !!}
                </div>
            </nav>
        </div>

    </main>
    <script>
       
        document.addEventListener("DOMContentLoaded", function() {
        
            const urlParams = new URLSearchParams(window.location.search);
            const hasFilters = urlParams.has('brand') ||
                               urlParams.has('category') ||
                               urlParams.has('sort') ||
                               urlParams.has('searchKey') ||
                               urlParams.has('page');

            if (hasFilters) {
                const productSection = document.getElementById('all-products');
                if (productSection) {
                  
                    setTimeout(() => {
                      
                        const yOffset = -100;
                        const y = productSection.getBoundingClientRect().top + window.pageYOffset + yOffset;

                        window.scrollTo({ top: y, behavior: 'smooth' });
                    }, 300);
                }
            }
        });
    </script>
@endsection
