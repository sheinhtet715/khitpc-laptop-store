@extends('user.layouts.master')

@section('content')

<style>
 
    .wishlist-container {
        min-height: 70vh; 
    }

    .wishlist-title {
        color: #1E3A5F; 
        letter-spacing: 0.5px;
    }

    .wishlist-card {
        background-color: #ffffff;
        border: 1px solid rgba(30, 58, 95, 0.08);
        border-radius: 12px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .wishlist-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(30, 58, 95, 0.08);
    }

    .wishlist-img-wrapper {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border-bottom: 1px solid rgba(30, 58, 95, 0.05);
        padding: 1.5rem;
        height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .wishlist-img-wrapper img {
        max-height: 100%;
        max-width: 100%;
        object-fit: contain;
        transition: transform 0.4s ease;
    }

    .wishlist-card:hover .wishlist-img-wrapper img {
        transform: scale(1.05);
    }


    .wishlist-product-name {
        color: #1F2937; 
        font-size: 1.05rem;
        font-weight: 700;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .wishlist-product-price {
        color: #D32F2F; 
        font-size: 1.25rem;
        font-weight: 700;
    }

    .btn-wishlist-view {
        background-color: #ffffff;
        color: #1E3A5F;
        border: 1px solid rgba(30, 58, 95, 0.2);
        border-radius: 6px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.2s ease;
    }

    .btn-wishlist-view:hover {
        background-color: #1E3A5F;
        color: #ffffff;
        border-color: #1E3A5F;
    }

    .btn-wishlist-remove {
        background-color: rgba(211, 47, 47, 0.05);
        color: #D32F2F;
        border: 1px solid transparent;
        border-radius: 6px;
        transition: all 0.2s ease;
    }

    .btn-wishlist-remove:hover {
        background-color: #D32F2F;
        color: #ffffff;
    }

    .wishlist-empty-state {
        background: #ffffff;
        border: 1px dashed rgba(30, 58, 95, 0.1);
        border-radius: 16px;
        padding: 4rem 2rem;
    }

    .wishlist-empty-icon {
        font-size: 4rem;
        color: #FFBF00; /* Gold Accent */
        margin-bottom: 1rem;
        opacity: 0.5;
    }
</style>

<div class="container my-5 wishlist-container">
    <h3 class="mb-4 fw-bold text-uppercase wishlist-title">My Wishlist</h3>

    @if(session('success'))
        <div class="text-white border-0 shadow-sm alert alert-success rounded-3 bg-success fw-medium">
            <i class="fa-solid fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('info'))
        <div class="border-0 shadow-sm alert alert-info rounded-3 fw-medium">
            <i class="fa-solid fa-circle-info me-2"></i> {{ session('info') }}
        </div>
    @endif

    @if($items->isEmpty())
        <div class="text-center shadow-sm wishlist-empty-state">
            <i class="fa-regular fa-heart wishlist-empty-icon"></i>
            <h4 class="mb-2 text-navy fw-bold">Your wishlist is empty</h4>
            <p class="mb-4 text-muted">Save your favorite tech here to review them later.</p>
            <a href="{{ route('home') }}" class="px-5 py-3 text-white shadow-sm btn fw-bold text-uppercase rounded-3" style="background-color: #1E3A5F; letter-spacing: 1px;">
                Explore Products
            </a>
        </div>
    @else
        <div class="mt-2 row g-4">
            @foreach($items as $it)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="wishlist-card h-100 d-flex flex-column">

                        <div class="wishlist-img-wrapper">
                            <img src="{{ $it->product_image ? asset('productImage/'.$it->product_image) : asset('default/default_image.webp') }}" alt="{{ $it->product_name }}">
                        </div>

                        <div class="p-4 card-body d-flex flex-column flex-grow-1">
                            <h6 class="mb-3 wishlist-product-name" title="{{ $it->product_name }}">
                                {{ $it->product_name }}
                            </h6>
                            <div class="mt-auto mb-4 wishlist-product-price">
                                K{{ number_format($it->product_price) }}
                            </div>

                            <div class="gap-2 d-flex justify-content-between">
                                <a href="{{ route('user#productDetails', $it->product_id) }}" class="py-2 btn btn-wishlist-view btn-sm flex-grow-1">
                                    View Details
                                </a>

                                <form action="{{ route('user#wishlistRemove') }}" method="POST" class="m-0">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $it->product_id }}">
                                    <button type="submit" class="px-3 btn btn-wishlist-remove btn-sm h-100" title="Remove from Wishlist">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-5 d-flex justify-content-end">
            {{ $items->links('pagination::bootstrap-5') }}
        </div>
    @endif

</div>
@endsection
