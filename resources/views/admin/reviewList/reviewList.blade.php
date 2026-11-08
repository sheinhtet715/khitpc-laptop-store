@extends('admin.layouts.master')

@section('page-title', 'Reviews & Comments')
@section('page-subtitle', 'Manage Customer Feedback')

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


        .col-customer {
            min-width: 180px;
        }

        .col-product {
            min-width: 200px;
        }

        .col-rating {
            min-width: 120px;
        }

        .col-comment {
            width: 45%;
            min-width: 250px;
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

        .star-filled {
            color: #FFBF00;
        }

        .star-empty {
            color: #e2e8f0;
        }

        .comment-box {
            background-color: #f8fafc;
            border: 1px solid rgba(30, 58, 95, 0.1);
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 0.85rem;
            max-height: 90px;
            overflow-y: auto;

            word-wrap: break-word;
            overflow-wrap: break-word;
            word-break: break-word;
            hyphens: auto;
        }

        .btn-action {
            min-width: 85px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
    </style>

    <div class="py-4 container-fluid">

        <div class="gap-3 mb-4 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
            <div class="d-flex align-items-center fw-bold text-muted text-uppercase small" style="letter-spacing: 0.5px;">
                Total Reviews:
                <span class="px-2 py-1 text-white shadow-sm ms-2 rounded-2"
                    style="background-color: #1E3A5F; font-size: 0.85rem; line-height: 1;">
                    {{ $reviews->total() ?? 0 }}
                </span>
            </div>

            <div class="gap-3 d-flex flex-column flex-sm-row">
                <form action="{{ route('review#list') }}" method="get" class="gap-2 d-flex">

                    <select name="sort" class="shadow-sm form-select admin-input fw-medium text-navy"
                        style="width: auto; cursor: pointer;" onchange="this.form.submit()">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                        <option value="highest" {{ request('sort') == 'highest' ? 'selected' : '' }}>Highest Rated (5 Stars)
                        </option>
                        <option value="lowest" {{ request('sort') == 'lowest' ? 'selected' : '' }}>Lowest Rated (1 Star)
                        </option>
                    </select>

                    <div class="shadow-sm input-group">
                        <input type="text" name="searchKey" value="{{ request('searchKey') }}"
                            class="form-control admin-input" placeholder="Search comments or users...">
                        <button type="submit" class="px-3 btn btn-admin-primary">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @if (session('success'))
            <div class="mb-4 border-0 shadow-sm alert alert-success fw-medium rounded-3">
                <i class="fa-solid fa-check-circle me-2"></i> {{ session('success') }}
            </div>
        @endif

        <div class="admin-card">
            <div class="p-0 card-body">
                <div class="table-responsive">
                    <table class="table mb-0 align-middle admin-table table-hover">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 col-customer">Customer</th>
                                <th class="py-3 col-product">Product</th>
                                <th class="py-3 text-center col-rating">Rating</th>
                                <th class="py-3 col-comment">Comment</th>
                                <th class="px-4 py-3 text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($reviews as $review)
                                <tr>
                                    <td class="px-4 py-3">
                                        <div class="fw-bold text-navy">
                                            {{ optional($review->user)->name ?? (optional($review->user)->nickname ?? 'Unknown User') }}
                                        </div>
                                        <div class="small text-muted">{{ optional($review->user)->email ?? 'No email' }}
                                        </div>
                                        <div class="mt-2 text-muted" style="font-size: 0.7rem;"><i
                                                class="fa-regular fa-clock me-1"></i>{{ optional($review->created_at)->format('j M Y') }}
                                        </div>
                                    </td>

                                    <td class="py-3">
                                        @if ($review->product)
                                            <a href="{{ route('product#edit', $review->product_id) }}"
                                                class="text-decoration-none text-dark fw-bold hover-text-primary"
                                                style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                                {{ $review->product->product_name }}
                                            </a>
                                            <div class="mt-1 small text-muted font-monospace"><span
                                                    class="fw-bold">SKU:</span> {{ $review->product->sku }}</div>
                                        @else
                                            <span class="text-muted fst-italic">Product Deleted</span>
                                        @endif
                                    </td>

                                    <td class="py-3 text-center text-nowrap">
                                        @php $rating = $review->rating ?? 0; @endphp
                                        <div>
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $rating)
                                                    <i class="fa-solid fa-star star-filled"></i>
                                                @else
                                                    <i class="fa-solid fa-star star-empty"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <div class="mt-1 small fw-bold text-muted">{{ $rating }} / 5</div>
                                    </td>

                                    <td class="py-3 pr-3">
                                        <div class="comment-box text-dark">
                                            {{ $review->review_text ?: 'No written comment left by user.' }}
                                        </div>
                                    </td>

                                    <td class="px-4 py-3">
                                        <div class="gap-2 d-flex align-items-center justify-content-end">
                                            <form action="{{ route('account#reviewFeature', $review->review_id) }}" method="POST" class="m-0">
                                                @csrf
                                                @if ($review->is_featured)
                                                    <button type="submit" class="shadow-sm btn btn-sm btn-warning text-dark fw-bold btn-action"
                                                        title="Remove from Homepage">
                                                        <i class="fa-solid fa-star me-1"></i> Featured
                                                    </button>
                                                @else
                                                    <button type="submit" class="bg-white border shadow-sm btn btn-sm text-dark fw-bold btn-action"
                                                        title="Feature on Homepage">
                                                        <i class="fa-solid fa-star text-warning me-1"></i> Feature
                                                    </button>
                                                @endif
                                            </form>

                                            <button type="button"
                                                onclick="deleteProcess('{{ route('review#delete', $review->review_id) }}')"
                                                class="bg-white border shadow-sm btn btn-sm text-danger fw-bold btn-action"
                                                title="Delete Comment">
                                                <i class="fa-solid fa-trash-can me-1"></i> Remove
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-5 text-center text-muted">
                                        <i class="mb-3 opacity-50 fa-regular fa-comments fa-3x"></i>
                                        <h5 class="fw-bold text-navy">No reviews found!</h5>
                                        <p>Your products haven't received any feedback yet.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($reviews->hasPages())
                    <div class="p-4 d-flex justify-content-end border-top bg-light">
                        {{ $reviews->links('pagination::bootstrap-5') }}
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
                title: "Remove this Review?",
                text: "This comment will be permanently deleted from the product page.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#D32F2F",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Yes, delete it"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        }
    </script>
@endsection
