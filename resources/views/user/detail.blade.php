@extends('user.layouts.master')

@section('content')

    <link rel="stylesheet" href="{{ asset('user/css/storefront.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/details.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
   
        :root {
            --khit-navy: #1C2A3F;
            --khit-navy-dark: #172536;
            --khit-crimson: #C1272D;
            --khit-crimson-dark: #A32025;
            --khit-gold: #FBB03B;
            --khit-offwhite: #FAF9F6;
            --khit-white: #FFFFFF;
        }

    
        body, main {
            background-color: var(--khit-offwhite) !important;
        }

       
        .text-navy { 
			color: var(--khit-navy) !important;
		}
        .text-crimson { 
			color: var(--khit-crimson) !important; 
		}
        .text-gold { 
			color: var(--khit-gold) !important; 
		}

        .product-title {
            color: var(--khit-navy);
            font-weight: 700;
        }

        .product-price {
            color: var(--khit-crimson);
            font-size: 1.75rem;
            font-weight: 700;
        }

        
        .btn-crimson {
            background-color: var(--khit-crimson);
            color: var(--khit-white);
            border: none;
            transition: all 0.2s ease;
        }
        .btn-crimson:hover:not(:disabled) {
            background-color: var(--khit-crimson-dark);
            color: var(--khit-white);
        }

        .btn-navy {
            background-color: var(--khit-navy);
            color: var(--khit-white);
            border: none;
            transition: all 0.2s ease;
        }
        .btn-navy:hover:not(:disabled) {
            background-color: var(--khit-navy-dark);
            color: var(--khit-white);
        }

        .premium-badge {
            background-color: var(--khit-crimson);
            color: var(--khit-white);
            padding: 4px 12px;
            font-weight: 700;
            border-radius: 4px;
            font-size: 0.85rem;
        }

        .detail-card {
            background-color: var(--khit-white);
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 4px 15px rgba(28, 42, 63, 0.05);
            border: 1px solid rgba(28, 42, 63, 0.08);
        }

        .static-gradient-card {
            background: linear-gradient(135deg, #FFFFFF 0%, rgba(251, 176, 59, 0.05) 50%, rgba(28, 42, 63, 0.03) 100%) !important;
            animation: none !important;
            background-size: auto !important;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 4px 15px rgba(28, 42, 63, 0.05);
            border: 1px solid rgba(28, 42, 63, 0.08);
        }

        .clean-specs-list li {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        .clean-specs-list li:last-child {
            border-bottom: none;
        }
        .clean-specs-list .spec-label {
            color: var(--khit-navy);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .clean-specs-list .spec-value {
            color: #495057;
            font-weight: 500;
            text-align: right;
        }

      
        .btn-wishlist {
            border: 1px solid #dee2e6;
            background: var(--khit-white);
            color: var(--khit-navy);
            width: 48px;
            height: 48px;
            transition: all 0.2s;
        }
        .btn-wishlist:hover { background: #f8f9fa; }
        .btn-wishlist.active {
            color: var(--khit-crimson);
            border-color: var(--khit-crimson);
        }

      
        .review-scroll-container {
            max-height: 520px;
            overflow-y: auto;
            padding-right: 12px;
        }
       
        .review-scroll-container::-webkit-scrollbar {
            width: 6px;
        }
        .review-scroll-container::-webkit-scrollbar-track {
            background: rgba(28, 42, 63, 0.03);
            border-radius: 10px;
        }
        .review-scroll-container::-webkit-scrollbar-thumb {
            background: rgba(28, 42, 63, 0.15);
            border-radius: 10px;
        }
        .review-scroll-container::-webkit-scrollbar-thumb:hover {
            background: var(--khit-navy);
        }
    </style>

    @php
        $images = [];
        if (!empty($product->product_image)) {
            $decoded = json_decode($product->product_image, true);
            if (is_array($decoded)) {
                $images = $decoded;
            } else {
                $parts = preg_split('/[,\|;]+/', $product->product_image);
                $parts = array_filter(array_map('trim', $parts));
                if (!empty($parts)) { $images = array_values($parts); }
            }
        }
        if (empty($images)) { $images = [asset('default/default_image.webp')]; }

        $imgUrl = function ($img) {
            return preg_match('/^https?:\\/\\//', $img) ? $img : asset('/productImage/' . ltrim($img, '/'));
        };

        $price = (float) ($product->product_price ?? 0);
        $discountPercent = (float) ($product->discount_percent ?? 0);
        $hasDiscount = $discountPercent > 0;
        $discountedPrice = $hasDiscount ? round($price * (1 - $discountPercent / 100)) : $price;
        $inStock = isset($product->stock_quantity) ? (int) $product->stock_quantity > 0 : true;
    @endphp

    <main class="container my-5">

        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="mb-0 bg-transparent breadcrumb small text-uppercase" style="letter-spacing: 0.5px;">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-muted">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('home', ['category' => $product->category_id]) }}" class="text-decoration-none text-muted">{{ $product->category_name ?? 'Category' }}</a></li>
                <li class="breadcrumb-item active text-navy fw-semibold" aria-current="page">{{ Str::limit($product->product_name, 30) }}</li>
            </ol>
        </nav>

        <div class="pb-4 mb-5 row g-5">

            <div class="col-12 col-lg-6">
                <div class="sticky-gallery">
                    <div class="position-relative detail-card p-2">
                        @if ($hasDiscount)
                            <span class="premium-badge position-absolute" style="top:20px; left:20px; z-index: 10;">
                                SAVE {{ (int) $discountPercent }}%
                            </span>
                        @endif

                        <div class="showcase-img-wrapper text-center">
                            <img id="mainImage" src="{{ $imgUrl($images[0]) }}" alt="{{ $product->product_name }}" style="max-width: 100%; border-radius: 8px;">
                        </div>
                    </div>

                    @if (count($images) > 1)
                        <div class="thumb-strip mt-3 d-flex gap-2 overflow-auto">
                            @foreach ($images as $index => $img)
                                <div class="thumb-wrapper detail-card p-1 {{ $index === 0 ? 'active' : '' }}" onclick="selectThumb(this, '{{ $imgUrl($img) }}')" style="cursor: pointer; min-width: 80px; border: 2px solid transparent;">
                                    <img src="{{ $imgUrl($img) }}" alt="Thumbnail" style="width: 100%; height: auto; border-radius: 4px;">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-12 col-lg-5 offset-lg-1">
                <div class="d-flex flex-column">

                    <div class="mb-2">
                        <span class="text-muted small fw-bold text-uppercase" style="letter-spacing: 1px;">{{ $product->brand_name ?? 'Brand' }}</span>
                        <h1 class="mt-1 product-title">{{ $product->product_name }}</h1>
                    </div>

                    <div class="mb-4 d-flex align-items-center justify-content-between">
                        @php
    $rawAvg = $product->reviews_avg_rating ?? 0;
    $reviewCount = $product->reviews_count ?? 0;


    $roundedRating = round($rawAvg * 2) / 2;


    $fullStars = floor($roundedRating);
    $hasHalfStar = ($roundedRating - $fullStars) == 0.5;
    $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
@endphp
                        <div class="d-flex align-items-center">
                            <div class="text-gold me-2 fs-6">
                                @for ($i = 0; $i < $fullStars; $i++) <i class="fa-solid fa-star"></i> @endfor
                                @if ($hasHalfStar) <i class="fa-solid fa-star-half-stroke"></i> @endif
                                @for ($i = 0; $i < $emptyStars; $i++) <i class="fa-regular fa-star"></i> @endfor
                            </div>
                            <a href="#reviews-section" class="text-decoration-none text-muted small fw-semibold">
                                ({{ number_format($reviewCount) }} reviews)
                            </a>
                        </div>

                        <div>
                            @if ($inStock)
                                <span class="text-success small fw-bold"><i class="fa-solid fa-circle text-success me-1" style="font-size: 8px;"></i> IN STOCK</span>
                            @else
                                <span class="text-crimson small fw-bold"><i class="fa-solid fa-circle text-crimson me-1" style="font-size: 8px;"></i> OUT OF STOCK</span>
                            @endif
                        </div>
                    </div>

                    <div class="gap-3 mb-4 d-flex align-items-baseline">
                        <span class="product-price">K{{ number_format($discountedPrice) }}</span>
                        @if ($hasDiscount)
                            <span class="text-muted text-decoration-line-through fs-5">K{{ number_format($price) }}</span>
                        @endif
                    </div>

                    <div class="gap-3 mb-4 d-flex align-items-center">
                        @auth
                            @if ($inStock)
                                <form action="{{ route('user#addToCart') }}" method="POST" class="m-0 flex-grow-1 add-to-cart-form">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-crimson w-100 d-flex align-items-center justify-content-center add-btn py-2 fs-6 fw-bold rounded-2">
                                        <i class="fa-solid fa-bag-shopping me-2"></i> <span>Add to Bag</span>
                                    </button>
                                </form>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn btn-crimson flex-grow-1 d-flex align-items-center justify-content-center py-2 fs-6 fw-bold rounded-2">
                                <i class="fa-solid fa-lock me-2"></i> Sign in to Add
                            </a>
                        @endauth

                        @auth
                            <form action="{{ !empty($inWishlist) ? route('user#wishlistRemove') : route('user#wishlistAdd') }}" method="POST" class="m-0">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button type="submit" class="btn btn-wishlist rounded-2 d-flex align-items-center justify-content-center {{ !empty($inWishlist) ? 'active' : '' }}" title="Wishlist">
                                    <i class="fa-{{ !empty($inWishlist) ? 'solid' : 'regular' }} fa-heart fs-5"></i>
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-wishlist rounded-2 d-flex align-items-center justify-content-center" title="Sign in to wishlist">
                                <i class="fa-regular fa-heart fs-5"></i>
                            </a>
                        @endauth
                    </div>

                    @if (!$inStock)
                        <div class="p-3 mb-4 detail-card d-flex align-items-center justify-content-between border-0 bg-white shadow-sm">
                            <div>
                                <h6 class="mb-0 text-navy fw-bold">Restock Alert</h6>
                                <small class="text-muted">Get notified when this arrives.</small>
                            </div>
                            @auth
                                @if ($isSubscribed)
                                    <form method="POST" action="{{ route('user#unregisterRestockAlert', $product->id) }}" class="m-0">
                                        @csrf
                                        <button class="btn btn-outline-dark btn-sm fw-bold rounded-2" type="submit">Cancel Alert</button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('user#registerRestockAlert', $product->id) }}" id="restockForm" class="m-0">
                                        @csrf
                                        <button id="restockBtn" class="btn btn-navy btn-sm fw-bold rounded-2" type="submit">Notify Me</button>
                                    </form>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn btn-outline-dark btn-sm fw-bold rounded-2">Sign in</a>
                            @endauth
                        </div>
                    @endif

                    <div class="mt-2 mb-4 static-gradient-card">
                        <h6 class="mb-4 fw-bold text-navy text-uppercase" style="letter-spacing: 1px;">Specifications</h6>
                        <ul class="mb-0 list-unstyled clean-specs-list">
                            <li>
                                <span class="spec-label"><i class="fa-solid fa-laptop text-muted"></i> Model</span>
                                <span class="spec-value">{{ $product->model ?? '—' }}</span>
                            </li>
                            <li>
                                <span class="spec-label"><i class="fa-solid fa-microchip text-muted"></i> CPU</span>
                                <span class="spec-value">{{ $product->processor ?? '—' }}</span>
                            </li>
                            <li>
                                <span class="spec-label"><i class="fa-solid fa-memory text-muted"></i> RAM</span>
                                <span class="spec-value">{{ $product->ram ?? '—' }}</span>
                            </li>
                            <li>
                                <span class="spec-label"><i class="fa-solid fa-gamepad text-muted"></i> GPU</span>
                                <span class="spec-value">{{ $product->graphics_card ?? '—' }}</span>
                            </li>
                            <li>
                                <span class="spec-label"><i class="fa-solid fa-tv text-muted"></i> Display</span>
                                <span class="spec-value">{{ $product->display ?? '—' }}</span>
                            </li>
                            <li>
                                <span class="spec-label"><i class="fa-solid fa-hard-drive text-muted"></i> Storage</span>
                                <span class="spec-value">{{ $product->storage ?? '—' }}</span>
                            </li>
                            <li>
                                <span class="spec-label"><i class="fa-solid fa-battery-full text-muted"></i> Battery</span>
                                <span class="spec-value">{{ $product->battery ?? '—' }}</span>
                            </li>
                            <li>
                                <span class="spec-label"><i class="fa-brands fa-windows text-muted"></i> OS</span>
                                <span class="spec-value">{{ $product->system_type ?? '—' }}</span>
                            </li>
                            <li>
                                <span class="spec-label"><i class="fa-solid fa-hand-pointer text-muted"></i> Touch</span>
                                <span class="spec-value">{{ $product->pen_and_touch ?? '—' }}</span>
                            </li>
                            <li>
                                <span class="spec-label"><i class="fa-solid fa-handshake text-muted"></i>Warranty</span>
                                <span class="spec-value">{{ $product->warranty ?? '—' }}</span>
                            </li>
                        </ul>
                    </div>

                    <div class="mb-4 static-gradient-card">
                        <h6 class="mb-3 fw-bold text-navy text-uppercase" style="letter-spacing: 1px;">Product Description</h6>
                        <div class="text-muted" style="line-height: 1.8; font-size: 0.95rem; white-space: pre-line;">
                            {{ $product->product_description ?: 'No description provided for this product.' }}
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="pt-5 mt-5 row border-top" id="reviews-section" style="border-color: rgba(28, 42, 63, 0.1) !important;">
            <div class="col-12">
                <h3 class="mb-5 text-center fw-bold text-navy">Customer Reviews ({{ number_format($reviewCount) }})</h3>

                <div class="row g-5">
                    <div class="col-12 col-md-7">
                        <div class="review-list pe-md-4 detail-card shadow-none">
                            
                            <!-- ======= FIXED: CONTENT WRAPPED IN SCROLL BOX ======= -->
                            <div class="review-scroll-container">
                                @forelse($reviews as $review)
                                    <div class="pb-4 mb-4 border-bottom">
                                        <div class="mb-2 d-flex align-items-start justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $review->user && $review->user->profile_img ? (filter_var($review->user->profile_img, FILTER_VALIDATE_URL) ? $review->user->profile_img : asset('profile/' . $review->user->profile_img)) : asset('default/default_image.webp') }}"
                                                    alt="avatar" class="border rounded-circle me-3" style="width: 45px; height: 45px; object-fit: cover;">
                                                <div>
                                                    <h6 class="mb-0 fw-bold text-navy">{{ $review->user->name ?? ($review->user->nickname ?? 'Unknown User') }}</h6>
                                                    <div class="gap-2 d-flex align-items-center">
                                                        <div class="text-gold" style="font-size: 12px;">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <i class="fa-{{ $i <= $review->rating ? 'solid' : 'regular' }} fa-star"></i>
                                                            @endfor
                                                        </div>
                                                        <small class="text-muted">{{ $review->created_at ? $review->created_at->diffForHumans() : '' }}</small>
                                                    </div>
                                                </div>
                                            </div>

                                            @if (Auth::check() && Auth::id() == $review->user_id)
                                                <form action="{{ route('user#reviewDelete', $review->id ?? $review->review_id) }}" method="POST" class="m-0 delete-review-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="shadow-sm btn btn-light btn-sm text-crimson rounded-circle" style="width: 35px; height: 35px;" title="Delete Review">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>

                                        @if ($review->review_text)
                                            <p class="mt-3 mb-0 text-muted" style="font-size: 0.95rem; word-break: break-word; overflow-wrap: break-word;">{{ $review->review_text }}</p>
                                        @endif
                                    </div>
                                @empty
                                    <div class="py-4 text-muted text-center">No reviews yet for this product.</div>
                                @endforelse
                            </div>
                            <!-- ==================================================== -->

                            <div class="mt-4">{{ $reviews->links('pagination::bootstrap-5') }}</div>
                        </div>
                    </div>

                    <div class="col-12 col-md-5">
                        <div class="static-gradient-card position-sticky" style="top: 100px;">
                            <h5 class="mb-4 fw-bold text-navy">Write a Review</h5>
                            @auth
                                <form action="{{ route('user#review') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <div class="mb-3">
                                        <label class="mb-1 form-label fw-bold text-muted small text-uppercase">Overall Rating</label>
                                        <div>
                                            <div class="star-rating-css text-gold fs-5">
                                                @for ($i = 5; $i >= 1; $i--)
                                                    <input type="radio" id="rating-{{ $i }}" name="rating" value="{{ $i }}" {{ isset($myReview) && $myReview->rating == $i ? 'checked' : '' }} required class="d-none">
                                                    <label for="rating-{{ $i }}" title="{{ $i }} stars" style="cursor:pointer;"><i class="fa-regular fa-star"></i></label>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <div class="mb-1 d-flex justify-content-between align-items-end">
                                            <label for="review_text" class="mb-0 form-label fw-bold text-muted small text-uppercase">Your Review</label>
                                            <span id="charCount" class="text-muted small" style="font-size: 0.75rem;">0 / 500</span>
                                        </div>
                                        <textarea name="review_text" id="review_text" rows="4" maxlength="500" class="form-control rounded-2 bg-white border @error('review_text') is-invalid @enderror" placeholder="What did you like or dislike?">{{ old('review_text', $myReview->review_text ?? '') }}</textarea>
                                        @error('review_text') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <button type="submit" class="btn btn-navy w-100 rounded-2 fw-bold text-uppercase" style="height: 48px; letter-spacing: 0.5px;">Post Review</button>
                                </form>
                            @else
                                <div class="py-4 text-center">
                                    <i class="mb-3 opacity-50 fa-regular fa-comment-dots fs-1 text-muted"></i>
                                    <p class="mb-4 text-muted small">You must be logged in to leave a review.</p>
                                    <a href="{{ route('login') }}" class="px-5 btn btn-outline-dark rounded-1 fw-bold">Sign In</a>
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function selectThumb(element, imgUrl) {
            document.querySelectorAll('.thumb-wrapper').forEach(el => {
                el.classList.remove('active');
                el.style.borderColor = 'transparent';
            });
            element.classList.add('active');
            element.style.borderColor = 'var(--khit-navy)';
            const mainImg = document.getElementById('mainImage');
            mainImg.style.opacity = '0';
            setTimeout(() => {
                mainImg.src = imgUrl;
                mainImg.style.opacity = '1';
            }, 200);
        }

      
        const restockForm = document.getElementById('restockForm');
        if (restockForm) {
            restockForm.addEventListener('submit', function() {
                const btn = document.getElementById('restockBtn');
                if (btn) {
                    btn.disabled = true;
                    btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
                }
            });
        }

        // Delete Review
        document.querySelectorAll('.delete-review-form').forEach(form => {
            form.addEventListener('submit', function(ev) {
                ev.preventDefault();
                Swal.fire({
                    title: 'Delete review?',
                    text: 'This cannot be undone.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#C1272D',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Delete'
                }).then(result => {
                    if (result.isConfirmed) form.submit();
                });
            });
        });

   
        const reviewText = document.getElementById('review_text');
        const charCount = document.getElementById('charCount');
        if (reviewText && charCount) {
            charCount.textContent = `${reviewText.value.length} / 500`;
            reviewText.addEventListener('input', function() {
                charCount.textContent = `${this.value.length} / 500`;
                if (this.value.length >= 500) {
                    charCount.classList.replace('text-muted', 'text-crimson');
                    charCount.classList.add('fw-bold');
                } else {
                    charCount.classList.replace('text-crimson', 'text-muted');
                    charCount.classList.remove('fw-bold');
                }
            });
        }
    </script>
@endsection