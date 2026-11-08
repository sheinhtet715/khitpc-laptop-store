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

<link rel="stylesheet" href="{{ asset('user/css/storefront.css') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">

<main class="container my-5">

    <div class="mb-4 d-flex align-items-center">
        <h3 class="mb-0 fw-bold text-dark"><i class="fa-solid fa-fire text-danger me-2"></i>Most Popular</h3>
    </div>

    <div class="row g-4">
        @forelse ($products as $product)
            <div class="col-12 col-md-6 col-lg-3">
                <div class="premium-product-card position-relative h-100" data-tilt data-tilt-max="5" data-tilt-speed="400" data-tilt-glare="true" data-tilt-max-glare="0.1">

                    @php
                        $discount = floatval($product->discount_percent ?? 0);
                    @endphp

                    {{-- Discount badge --}}
                    @if($discount > 0)
                        <span class="premium-badge position-absolute" style="top:12px; left:12px;">
                            SAVE {{ intval($discount) }}%
                        </span>
                    @endif

                    <div class="premium-product-thumb">
                        @php
                            $img = $product->product_image ? asset('productImage/' . $product->product_image) : asset('default/default_image.webp');
                        @endphp
                        <a href="{{ route('user#productDetails', $product->id ?? $product->product_id) }}" class="d-block w-100 h-100" aria-label="View {{ $product->product_name }}">
                            <img src="{{ $img }}" alt="{{ $product->product_name }}">
                        </a>
                    </div>

                    <div class="premium-card-body">
                        <div class="mb-3">
                            <div class="premium-card-title text-truncate" title="{{ $product->product_name }}">{{ $product->product_name }}</div>
                            <div class="text-muted small" style="font-weight: 500;">{{ $product->brand_name ?? 'Brand' }} • {{ $product->category_name ?? 'Category' }}</div>
                        </div>

                        <div class="mb-3 d-flex justify-content-between align-items-end">
                            <div>
                                @php
                                    $original = floatval($product->product_price ?? 0);
                                    $discounted = $discount > 0 ? round($original * (1 - ($discount / 100))) : $original;
                                @endphp
                                <div class="premium-price-tag">K{{ number_format($discounted) }}</div>
                                @if($discount > 0)
                                    <div class="small text-muted text-decoration-line-through">K{{ number_format($original) }}</div>
                                @endif
                            </div>

                            <div class="text-end">
                                @php
                                    $avgRating = number_format($product->reviews_avg_rating ?? 0, 1);
                                    $reviewCount = $product->reviews_count ?? 0;
                                    if ($reviewCount > 0) {
                                        $fullStars = floor($avgRating);
                                        $hasHalfStar = ($avgRating - $fullStars) >= 0.25 && ($avgRating - $fullStars) < 0.75;
                                        $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
                                    }
                                @endphp

                                <div class="mb-1 star-sm">
                                    @if($reviewCount > 0)
                                        @for($i = 0; $i < $fullStars; $i++) <i class="fa-solid fa-star text-warning"></i> @endfor
                                        @if($hasHalfStar) <i class="fa-solid fa-star-half-stroke text-warning"></i> @endif
                                        @for($i = 0; $i < $emptyStars; $i++) <i class="fa-regular fa-star text-warning"></i> @endfor
                                    @else
                                        @for($i = 0; $i < 5; $i++) <i class="opacity-50 fa-regular fa-star text-muted"></i> @endfor
                                    @endif
                                </div>
                                <div class="meta" style="font-size:0.75rem; font-weight: 500;">
                                    <i class="fa-solid fa-eye me-1"></i>{{ number_format($product->views_count ?? 0) }}
                                     @if ($reviewCount > 0)
                                            &bull; {{ number_format($reviewCount) }}
                                            {{ $reviewCount == 1 ? 'review' : 'reviews' }}
                                        @endif
                                </div>
                            </div>
                        </div>

                        <div class="mt-auto premium-actions">
                            <a href="{{ route('user#productDetails', $product->id ?? $product->product_id) }}" class="btn btn-premium-view btn-sm flex-fill">
                                <i class="fa-solid fa-magnifying-glass me-1"></i> View
                            </a>

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
                                <a href="{{ route('login') }}" class="btn btn-outline-danger btn-sm flex-fill d-inline-flex justify-content-center align-items-center" style="border-radius: 8px; font-weight: 600;">
                                    <i class="fa-solid fa-lock me-1"></i> Sign in
                                </a>
                            @endauth
                        </div>

                    </div>
                </div>
            </div>
        @empty
            <div class="py-5 text-center col-12">
                <div class="p-5 bg-white border shadow-sm rounded-4">
                    <i class="mb-3 opacity-50 fa-solid fa-chart-line fs-1 text-muted"></i>
                    <h5 class="fw-bold text-dark">No trending products yet</h5>
                    <p class="text-muted">Check back soon to see what everyone is buying.</p>
                </div>
            </div>
        @endforelse
    </div>

    <nav class="mt-5" aria-label="Page navigation">
        <div class="d-flex justify-content-center premium-pagination">
            {!! $products->withQueryString()->links('pagination::bootstrap-5') !!}
        </div>
    </nav>

</main>
@endsection
