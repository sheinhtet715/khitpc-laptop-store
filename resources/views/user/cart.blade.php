@extends('user.layouts.master')

@section('content')

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700;800&display=swap" rel="stylesheet">

    <style>
      
        body {
            background-color: #f4f6f9;
        }

        .cart-wrapper {
            animation: fadeUp 0.5s ease-out forwards;
        }

        @keyframes fadeUp {
            0% {
                opacity: 0;
                transform: translateY(15px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

     
        .shipping-card {
            background: #ffffff;
            border: 1px solid rgba(0, 0, 0, 0.05);
            border-radius: 12px;
            padding: 16px 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
        }

        .progress-custom {
            height: 6px;
            background-color: #e2e8f0;
            border-radius: 10px;
            overflow: hidden;
            margin-top: 8px;
        }

        .progress-custom-bar {
            height: 100%;
            background: #10b981;
            border-radius: 10px;
            transition: width 1s ease-out;
        }

       
        .cart-item-card {
            background: #ffffff;
            border: 1px solid rgba(0, 0, 0, 0.08);
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.02);
            transition: all 0.2s ease;
            margin-bottom: 16px;
        }

        .cart-item-card:hover {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.06);
            border-color: rgba(211, 47, 47, 0.15);
            transform: translateY(-2px);
        }

        .cart-img-wrap {
            border: 1px solid rgba(0, 0, 0, 0.05);
            background: #f8fafc;
        }

        .mix-blend-multiply {
            mix-blend-mode: multiply;
        }

        .hover-brand {
            color: #1F2937;
            transition: color 0.2s ease;
            text-decoration: none;
        }

        .hover-brand:hover {
            color: var(--brand-red, #d32f2f) !important;
        }

        .remove-item-btn {
            color: #94a3b8;
            transition: all 0.2s ease;
            background: transparent;
            padding: 0;
            border: none;
        }

        .remove-item-btn:hover {
            color: #b91c1c !important;
        }

        .qty-select {
            cursor: pointer;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
            border: 2px solid #e2e8f0;
            color: #1F2937;
        }

        .qty-select:focus {
            border-color: #94a3b8;
            box-shadow: 0 0 0 3px rgba(148, 163, 184, 0.15);
            outline: none;
        }

        .qty-select:disabled {
            opacity: 0.7;
            cursor: wait;
        }

     
        .sticky-top {
            z-index: 1020;
        }

        .summary-panel {
            background: #112540;
            border-radius: 20px;
            color: #ffffff;
            box-shadow: 0 20px 40px rgba(17, 37, 64, 0.15);
        }

        .glass-input {
            background: rgba(255, 255, 255, 0.08) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: #ffffff !important;
            border-radius: 8px 0 0 8px;
        }

        .glass-input::placeholder {
            color: rgba(255, 255, 255, 0.4);
        }

        .glass-input:focus {
            border-color: #FFD700 !important;
        }

        .btn-apply-glass {
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-left: none;
            color: #ffffff;
            border-radius: 0 8px 8px 0;
        }

        .btn-apply-glass:hover:not(:disabled) {
            background: #FFD700;
            color: #112540;
            border-color: #FFD700;
        }

        #summaryDiscount {
            letter-spacing: 0.5px;
        }

      
        .place-order-animated-btn {
            font-family: 'Montserrat', sans-serif !important;
            overflow: hidden;
            transition: all 0.3s ease;
            background: linear-gradient(135deg, #D32F2F 0%, #B02323 100%);
            border: none;
            box-shadow: 0 8px 20px rgba(211, 47, 47, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .place-order-animated-btn:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(211, 47, 47, 0.35);
        }

        .place-order-animated-btn:disabled {
            background: #334155;
            box-shadow: none;
            transform: none;
        }

        .animated-content-idle {
            transition: transform 0.4s ease, opacity 0.4s ease;
        }

        .animated-drone-outline {
            transition: transform 0.4s ease, opacity 0.4s ease;
        }

        .animated-dots {
            display: inline-block;
            width: 2ch;
            text-align: left;
        }

        @media (max-width: 767.98px) {
            .cart-item-card {
                padding: 15px;
            }
        }
    </style>
<main class="container my-5 cart-wrapper">

        <div class="mb-5 pb-3 border-bottom border-secondary-subtle d-flex align-items-baseline">
            <h1 class="mb-0 fw-bolder text-navy" style="letter-spacing: -1.2px; font-size: 2.2rem;">Your Cart</h1>
            <span class="ms-3 text-muted fw-medium fs-5" style="font-family: 'Montserrat', sans-serif;">
                <span id="cart-total-count" class="text-danger fw-bold">{{ $cartItems->sum('quantity') }}</span> items
            </span>
        </div>

        <div class="row g-4 g-lg-5">
            <div class="col-lg-7 col-xl-8">

                @if (!$cartItems->isEmpty())
                    @php
                        $shippingThreshold = 1500000;
                        $progress = min(100, ($subtotal / $shippingThreshold) * 100);
                    @endphp
                @endif

                <div id="cartList">
                    @if ($cartItems->isEmpty())
                        <div class="p-5 text-center cart-item-card">
                            <i class="mb-3 fa-solid fa-cart-arrow-down text-muted" style="font-size: 4rem; opacity: 0.2;"></i>
                            <h4 class="mb-2 fw-bold text-dark">Your cart is empty</h4>
                            <p class="mb-4 text-muted">Looks like you haven't added any products yet.</p>
                            <a href="{{ route('home') }}" class="px-4 py-2 btn btn-dark rounded-pill fw-bold">Continue Shopping</a>
                        </div>
                    @else
                        @foreach ($cartItems as $item)
                            @php
                                $image = $item->product_image ? asset('productImage/' . $item->product_image) : asset('productImage/default_image.webp');
                                $orig = floatval($item->product_price ?? 0);
                                $disc = floatval($item->discount_percent ?? 0);
                                $unit = $item->unit_price ?? ($disc > 0 ? round($orig * (1 - $disc / 100)) : $orig);
                                $itemAmount = $unit * $item->quantity;
                            @endphp

                            <div class="cart-item-card" id="cart-item-{{ $item->cart_item_id }}">
                                <div class="m-0 row align-items-center w-100">

                                    <div class="p-0 mb-3 col-12 col-md-5 d-flex align-items-center mb-md-0">
                                        <div class="flex-shrink-0 cart-img-wrap rounded-3 me-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                            <img src="{{ $image }}" alt="{{ $item->product_name }}" class="p-1 img-fluid mix-blend-multiply" style="object-fit: contain; max-height: 100%;" onerror="this.onerror=null; this.src='{{ asset('productImage/default_image.webp') }}';">
                                        </div>
                                        <div>
                                            <span class="mb-1 border badge bg-success bg-opacity-10 text-success border-success-subtle" style="font-size: 0.65rem;"><i class="fa-solid fa-check"></i> IN STOCK</span>
                                            <h6 class="mb-1 fw-bold lh-sm">
                                                <a href="{{ route('user#productDetails', $item->product_id) }}" class="hover-brand">{{ $item->product_name }}</a>
                                            </h6>
                                            <div class="mb-1 text-muted small" style="font-size: 0.75rem;">SKU: {{ $item->product_id }}</div>
                                            <button class="remove-item-btn small fw-medium" data-cart-item-id="{{ $item->cart_item_id }}">
                                                <i class="fa-regular fa-trash-can"></i> Remove
                                            </button>
                                        </div>
                                    </div>

                                    <div class="p-0 col-4 col-md-3 text-md-center">
                                        <div class="mb-1 text-muted text-uppercase fw-bold" style="font-size: 0.65rem; letter-spacing: 0.5px;">Unit Price</div>
                                        <div class="fw-bold text-dark fs-6">K{{ number_format($unit) }}</div>
                                        @if ($disc > 0)
                                            <div class="small text-danger fw-bold text-decoration-line-through" style="font-size: 0.75rem;">K{{ number_format($orig) }}</div>
                                        @endif
                                    </div>

                                    <div class="p-0 col-4 col-md-2 d-flex flex-column align-items-md-center">
                                        <div class="mb-1 text-muted text-uppercase fw-bold" style="font-size: 0.65rem; letter-spacing: 0.5px;">Quantity</div>
                                        @php
                                            $maxLimit = min(10, $item->stock_quantity ?? 10);
                                            $displayQty = min($item->quantity, $maxLimit);
                                        @endphp
                                        <select class="text-center shadow-none form-select form-select-sm qty-select fw-bold" style="width: 70px;" data-cart-item-id="{{ $item->cart_item_id }}">
                                            @for ($i = 1; $i <= $maxLimit; $i++)
                                                <option value="{{ $i }}" {{ $i == $displayQty ? 'selected' : '' }}>{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>

                                    <div class="p-0 col-4 col-md-2 text-end">
                                        <div class="mb-1 text-muted text-uppercase fw-bold" style="font-size: 0.65rem; letter-spacing: 0.5px;">Item Total</div>
                                        <div class="fw-bold text-danger fs-5" id="item-amount-{{ $item->cart_item_id }}">
                                            K{{ number_format($itemAmount) }}
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="col-lg-5 col-xl-4">
                <div class="p-4 summary-panel sticky-top" style="top: 110px;">
                    <h5 class="mb-4 text-white fw-bold text-uppercase d-flex align-items-center" style="letter-spacing: 1px;">
                        <i class="fa-solid fa-receipt text-warning me-2"></i> Summary
                    </h5>

                    <div class="mb-4">
                        <label for="discountCode" class="mb-2 text-white opacity-75 form-label small fw-bold">Gift Card or Promo Code</label>
                        <div class="shadow-sm input-group">
                            <input type="text" id="discountCode" class="shadow-none form-control glass-input" placeholder="Enter code" {{ $cartItems->isEmpty() ? 'disabled' : '' }}>
                            <button id="applyDiscount" class="px-3 btn btn-apply-glass" type="button" {{ $cartItems->isEmpty() ? 'disabled' : '' }}>Apply</button>
                        </div>
                    </div>

                    <hr class="my-4 border-white border-opacity-25">

                    <div class="mb-3 d-flex justify-content-between summary-text-muted fw-medium fs-6">
                        <span>Subtotal</span>
                        <span class="text-white" id="summarySubtotal">K{{ number_format($subtotal) }}</span>
                    </div>
                    <div class="mb-3 d-flex justify-content-between summary-text-muted fw-medium fs-6">
                        <span>Discount</span>
                        <span class="text-warning fw-bold" id="summaryDiscount">- K{{ number_format($discount) }}</span>
                    </div>
                    <div class="mb-4 d-flex justify-content-between summary-text-muted fw-medium fs-6">
                        <span>Tax & Fees</span>
                        <span class="text-success fw-bold"><i class="fa-solid fa-check me-1"></i> Included</span>
                    </div>

                    <div class="pt-4 pb-4 border-white border-opacity-25 d-flex flex-column border-top">
                        <span class="mb-1 text-white text-uppercase fw-bold" style="letter-spacing: 1px; font-size: 0.85rem;">Estimated Total</span>
                        <span class="fw-bolder" id="summaryTotal" style="font-size: 2rem; color: #FFD700; line-height: 1;">K{{ number_format($total) }}</span>
                    </div>

                    <form id="placeOrderForm" action="{{ route('user#placeOrder') }}" method="POST">
                        @csrf
                        <input type="hidden" name="code" id="orderDiscountCode" value="">

                        <div class="overflow-hidden w-100 position-relative rounded-3" style="height: 60px;">
                            <button id="placeOrderBtn" type="button" class="m-0 btn w-100 h-100 place-order-animated-btn position-relative" {{ $cartItems->isEmpty() ? 'disabled' : '' }}>

                                <div class="animated-content-idle d-flex align-items-center justify-content-center w-100 h-100 position-absolute" style="top: 0; left: 0;">
                                    <span class="text-white fw-bold fs-5 me-2 animated-text text-uppercase">Checkout Securely</span>
                                    <div class="bg-white bg-opacity-25 icon-wrap rounded-circle d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                                        <i class="text-white fa-solid fa-arrow-right" style="font-size: 0.9rem;"></i>
                                    </div>
                                </div>

                                <div class="animated-drone-outline position-absolute w-100 h-100 d-flex align-items-center justify-content-center" style="top: 100%; left: 0; opacity: 0;">
                                    <i class="text-white fa-solid fa-plane-up fs-3"></i>
                                </div>

                            </button>
                        </div>
                    </form>

                    <div class="mt-4 text-center">
                        <div class="flex-wrap gap-2 mb-3 d-flex justify-content-center">
                            <span class="px-3 py-2 bg-white shadow-sm badge rounded-pill text-dark fw-bold"><i class="fa-solid fa-building-columns text-primary me-1"></i> KBZPay</span>
                            <span class="px-3 py-2 bg-white shadow-sm badge rounded-pill text-dark fw-bold"><i class="fa-solid fa-wallet text-warning me-1"></i> WavePay</span>
                        </div>
                        <div class="mt-2 opacity-75 d-flex align-items-center justify-content-center text-success small fw-bold">
                            <i class="fa-solid fa-lock me-2"></i> 256-bit SSL Encryption
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <script>
    (() => {
        const routes = {
            update: "{{ route('user#cartUpdate') }}",
            remove: "{{ route('user#cartRemove') }}",
            apply: "{{ route('user#applyDiscount') }}"
        };

        const csrf = document.querySelector('meta[name="csrf-token"]').content;
        const fmt = n => 'K' + new Intl.NumberFormat('en-US').format(Math.round(n || 0));

        const updateUI = (data) => {
            if (typeof data.itemAmount !== 'undefined') {
                const itemEl = document.getElementById('item-amount-' + data.cart_item_id);
                if(itemEl) itemEl.innerText = fmt(data.itemAmount);
            }
            if (typeof data.subtotal !== 'undefined') {
                const subEl = document.getElementById('summarySubtotal');
                if(subEl) subEl.innerText = fmt(data.subtotal);

                const discEl = document.getElementById('summaryDiscount');
                if(discEl) discEl.innerText = '- ' + fmt(data.discount);

                const totEl = document.getElementById('summaryTotal');
                if(totEl) totEl.innerText = fmt(data.total);
            }

            if (typeof data.total_quantity !== 'undefined') {
                const countEl = document.getElementById('cart-total-count');
                if (countEl) countEl.innerText = data.total_quantity;
            }
        };

        const cartList = document.getElementById('cartList');

        if(cartList){
        
            cartList.addEventListener('change', async (ev) => {
                const sel = ev.target;
                if (!sel.classList.contains('qty-select')) return;

                const id = sel.dataset.cartItemId;
                const qty = parseInt(sel.value, 10);
                sel.disabled = true;

                try {
                    const res = await fetch(routes.update, {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                        body: JSON.stringify({ cart_item_id: id, quantity: qty })
                    });

                    const data = await res.json();
                    if (!res.ok) throw new Error(data.message || 'Update failed');

                    data.cart_item_id = id; 
                    updateUI(data);

                } catch (err) {
           
                    await Swal.fire({
                        icon: 'error',
                        title: 'Oops',
                        text: err.message,
                        confirmButtonColor: '#D32F2F',
                        borderRadius: '16px'
                    });


                    window.location.reload();
                } finally {
                    sel.disabled = false;
                }
            });

      
            cartList.addEventListener('click', async (ev) => {
                const btn = ev.target.closest('.remove-item-btn');
                if (!btn) return;

                const confirmed = await Swal.fire({ title: 'Remove item?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#D32F2F' });
                if (!confirmed.isConfirmed) return;

                try {
                    const res = await fetch(routes.remove, {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                        body: JSON.stringify({ cart_item_id: btn.dataset.cartItemId })
                    });

                    if (res.ok) window.location.reload();
                } catch (err) {
                    Swal.fire('Error', 'Could not remove item', 'error');
                }
            });
        }


        const orderForm = document.getElementById('placeOrderForm');
        const animatedBtn = document.getElementById('placeOrderBtn');

        if (orderForm && animatedBtn) {
            animatedBtn.addEventListener('click', (ev) => {
                ev.preventDefault();

                const hasItems = document.querySelector('.cart-item-card');
                if (!hasItems) {
                    if (typeof Swal !== 'undefined') Swal.fire('Error', 'Your cart is empty', 'error');
                    return;
                }

                const idleContent = animatedBtn.querySelector('.animated-content-idle');
                const textSpan = animatedBtn.querySelector('.animated-text');
                const iconWrap = animatedBtn.querySelector('.icon-wrap');
                const droneOutline = animatedBtn.querySelector('.animated-drone-outline');

                if (!idleContent || !textSpan || !droneOutline) {
                    orderForm.submit();
                    return;
                }

                animatedBtn.disabled = true;
                animatedBtn.style.cursor = 'wait';

                textSpan.innerHTML = 'PROCESSING<span class="animated-dots">..</span>';
                iconWrap.innerHTML = '<i class="text-white fa-solid fa-circle-notch fa-spin"></i>';

                let dots = 0;
                const dotsInterval = setInterval(() => {
                    dots = (dots + 1) % 4;
                    const dotsEl = animatedBtn.querySelector('.animated-dots');
                    if (dotsEl) dotsEl.innerHTML = '.'.repeat(dots);
                }, 300);

                setTimeout(() => {
                    clearInterval(dotsInterval);

                    idleContent.style.transform = 'translateY(-150%)';
                    idleContent.style.opacity = '0';

                    droneOutline.style.top = '0';
                    droneOutline.style.opacity = '1';

                    setTimeout(() => {
                        droneOutline.innerHTML = '<i class="text-white fa-solid fa-circle-check fs-2"></i>';
                        setTimeout(() => {
                            orderForm.submit();
                        }, 600);
                    }, 800);

                }, 1500);
            });
        }


        const applyBtn = document.getElementById('applyDiscount');
        const codeInput = document.getElementById('discountCode');

        if (applyBtn && codeInput) {
            applyBtn.addEventListener('click', async (ev) => {
                ev.preventDefault();
                const code = codeInput.value.trim();
                if (!code) {
                    if (typeof Swal !== 'undefined') Swal.fire('Warning', 'Please enter a discount code', 'warning');
                    return;
                }

                const originalText = applyBtn.innerHTML;
                applyBtn.disabled = true;
                applyBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';

                try {
                    const res = await fetch(routes.apply, {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                        body: JSON.stringify({ code: code })
                    });
                    const data = await res.json();

                    if (!res.ok || !data.success) throw new Error(data.message || 'Invalid code');

                    updateUI(data);

                    const hiddenInput = document.getElementById('orderDiscountCode');
                    if (hiddenInput) hiddenInput.value = code;

                    if (typeof Swal !== 'undefined') Swal.fire({
                        title: 'Code Applied!',
                        text: `You saved K${new Intl.NumberFormat('en-US').format(data.discount)}`,
                        icon: 'success',
                        confirmButtonColor: '#10b981',
                        borderRadius: '16px'
                    });

             
                    applyBtn.disabled = true;
                    applyBtn.innerHTML = '<i class="fa-solid fa-check"></i> Applied';
                    applyBtn.style.pointerEvents = 'none';
                    codeInput.disabled = true;

                } catch (err) {
                    applyBtn.disabled = false;
                    applyBtn.innerHTML = originalText;

                    const hiddenInput = document.getElementById('orderDiscountCode');
                    if (hiddenInput) hiddenInput.value = '';

                    if (typeof Swal !== 'undefined') Swal.fire('Error', err.message || 'Failed to apply coupon', 'error');
                }
            });
        }
    })();
</script>
@endsection
