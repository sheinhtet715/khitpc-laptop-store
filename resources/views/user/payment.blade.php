@extends('user.layouts.master')

@section('content')

<style>

    .payment-wrapper {
        max-width: 1100px;
        margin: 0 auto;
        animation: fadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    @keyframes fadeUp {
        0% { opacity: 0; transform: translateY(20px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    .payment-card {
        border: none;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 25px 50px rgba(30, 58, 95, 0.1);
        background: #ffffff;
    }

    .left-panel {
        padding: 50px;
        background: #ffffff;
    }

    .right-panel {
        padding: 50px;
        background: linear-gradient(135deg, #1E3A5F 0%, #112540 100%);
        color: #ffffff;
        position: relative;
    }

    .premium-input {
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 14px 18px;
        font-weight: 500;
        color: #1F2937;
        transition: all 0.3s ease;
        background-color: #f8fafc;
    }

    .premium-input:focus {
        border-color: #D32F2F;
        background-color: #ffffff;
        box-shadow: 0 0 0 4px rgba(211, 47, 47, 0.1);
        outline: none;
    }

    .form-label.premium-label {
        font-weight: 700;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        margin-bottom: 8px;
    }

    .upload-zone {
        border: 2px dashed #cbd5e1;
        border-radius: 16px;
        padding: 40px 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background: #f8fafc;
        display: block;
    }

    .upload-zone:hover, .upload-zone.dragover {
        border-color: #D32F2F;
        background: #fff1f2;
    }

    .upload-icon {
        font-size: 2.5rem;
        color: #94a3b8;
        margin-bottom: 15px;
        transition: color 0.3s ease;
    }

    .upload-zone:hover .upload-icon, .upload-zone.dragover .upload-icon {
        color: #D32F2F;
    }

    .preview-image-container {
        position: relative;
        display: inline-block;
        margin: 5px;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .order-item-card {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 16px;
        padding: 15px;
        transition: transform 0.3s ease;
    }

    .order-item-card:hover {
        transform: translateX(5px);
        background: rgba(255, 255, 255, 0.08);
    }

    .btn-pay {
        background: linear-gradient(135deg, #D32F2F 0%, #B02323 100%);
        border: none;
        border-radius: 14px;
        font-weight: 800;
        font-size: 1.1rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 18px;
        color: white;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 10px 20px rgba(211, 47, 47, 0.2);
    }

    .btn-pay:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(211, 47, 47, 0.35);
        color: white;
    }

    .btn-pay:disabled {
        background: #94a3b8;
        transform: none;
        box-shadow: none;
    }

    @media (max-width: 991px) {
        .left-panel, .right-panel { padding: 30px; }
        .payment-card { border-radius: 16px; }
    }
</style>

<div class="container my-5 payment-wrapper">
    <div class="payment-card">

        <form id="paymentForm" action="{{ route('user#submitPayment') }}" method="POST" enctype="multipart/form-data" class="needs-validation w-100" novalidate>
            @csrf
            <div class="row g-0">

                <div class="col-lg-7 left-panel">
                    <div class="mb-5 d-flex align-items-center">
                        <div class="shadow-sm bg-light text-danger rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; font-size: 1.2rem;">
                            <i class="fa-solid fa-lock"></i>
                        </div>
                        <div>
                            <h3 class="mb-0 fw-bold text-dark" style="letter-spacing: -0.5px;">Secure Checkout</h3>
                            <p class="mb-0 text-muted small fw-medium">Complete your payment details below.</p>
                        </div>
                    </div>

                    {{-- Server Side Alerts --}}
                    @if(session('success'))
                        <div class="border-0 shadow-sm alert alert-success fw-bold rounded-3"><i class="fa-solid fa-check-circle me-2"></i> {{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="border-0 shadow-sm alert alert-danger fw-bold rounded-3"><i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('error') }}</div>
                    @endif

                    <div class="mb-4 row g-4">
                        <div class="col-md-6">
                            <label class="form-label premium-label" for="amount">Transfer Amount (K)</label>
                            <input id="amount" name="amount" type="number" min="0" step="0.01" value="{{ number_format($total ?? 0, 2, '.', '') }}" class="form-control premium-input" required readonly>
                            <div class="mt-2 form-text small text-muted"><i class="fa-solid fa-circle-info text-primary me-1"></i> Pre-filled with total order amount.</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label premium-label" for="payment_method">Transfer To Account</label>
                            <select id="payment_method" name="payment_method" class="form-select premium-input @error('payment_method') is-invalid @enderror" required>
                                <option value="" disabled {{ old('payment_method') ? '' : 'selected' }}>-- Select Bank / Wallet --</option>
                                @forelse ($paymentMethods as $pm)
                                    <option value="{{ $pm->payment_method_id }}" {{ (string) old('payment_method') === (string)$pm->payment_method_id ? 'selected' : '' }}>
                                        {{ $pm->account_type }} - {{ $pm->account_name }} ({{ $pm->account_number }})
                                    </option>
                                @empty
                                    <option value="" disabled>No payment methods available</option>
                                @endforelse
                            </select>
                            @error('payment_method')
                                <div class="mt-2 invalid-feedback fw-bold">{{ $message }}</div>
                            @enderror
                            @if ($paymentMethods->isEmpty())
                                <div class="mt-2 form-text text-danger fw-bold"><i class="fa-solid fa-triangle-exclamation"></i> No payment methods configured. Contact admin.</div>
                            @endif
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label premium-label">Upload Transaction Screenshot</label>

                        <label for="imageInput" class="shadow-sm upload-zone" id="dropZone">
                            <i class="fa-solid fa-cloud-arrow-up upload-icon"></i>
                            <h6 class="mb-1 fw-bold text-dark">Click to browse or drag image here</h6>
                            <p class="mb-3 small text-muted">Max file size: 2MB. Allowed: JPG, PNG, WEBP.</p>

                            <input id="imageInput" name="payment_images[]" type="file" accept="image/jpeg, image/png, image/webp" multiple style="display:none" required class="{{ $errors->has('payment_images') || $errors->has('payment_images.*') ? 'is-invalid' : '' }}">

                            <div id="imagesPreview" class="flex-wrap gap-2 mt-3 d-flex justify-content-center"></div>
                        </label>

                        <div class="mt-3 d-flex justify-content-between align-items-center">
                            <div id="fileMeta" class="small fw-bold text-primary"><i class="fa-regular fa-image me-1"></i> No image selected</div>
                            <button id="clearImagesBtn" type="button" class="px-3 btn btn-sm btn-outline-danger fw-bold rounded-pill" disabled>
                                <i class="fa-solid fa-trash-can me-1"></i> Clear Image
                            </button>
                        </div>

                        @error('payment_images')
                            <div class="mt-2 text-danger fw-bold small"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                        @foreach ($errors->get('payment_images.*') as $messages)
                            @foreach ($messages as $message)
                                <div class="mt-2 text-danger fw-bold small"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                            @endforeach
                        @endforeach

                    </div>

                    <div class="mt-5 d-grid">
                        <button id="payBtn" type="submit" class="btn btn-pay">
                            Confirm & Submit Payment <i class="fa-solid fa-arrow-right ms-2"></i>
                        </button>
                        <div class="mt-3 text-center small text-muted fw-medium">
                            <i class="fa-solid fa-shield-halved text-success me-1"></i> Your payment receipt will be verified manually by our team.
                        </div>
                    </div>
                </div>

                <div class="col-lg-5 right-panel d-flex flex-column">

                    <div class="pb-3 mb-4 border-opacity-50 d-flex justify-content-between align-items-center border-bottom border-secondary">
                        <h5 class="mb-0 text-white text-uppercase fw-bold" style="letter-spacing: 1px;">Order Summary</h5>
                        <span class="px-3 py-2 bg-white badge text-navy rounded-pill fw-bold text-dark">{{ $cartItems->count() }} Items</span>
                    </div>

                    <div id="orderItems" class="mb-4 flex-grow-1" style="overflow-y: auto; max-height: 400px; padding-right: 5px;">
                        @foreach($cartItems as $it)
                            <div class="mb-3 shadow-sm order-item-card d-flex align-items-center">
                                <div class="flex-shrink-0 p-1 bg-white rounded-3 me-3">
                                    <img src="{{ $it->product_image ? asset('productImage/'.$it->product_image) : asset('default/default_image.webp') }}"
                                         alt="item" style="width:60px; height:60px; object-fit:contain; border-radius:8px;">
                                </div>
                                <div class="flex-grow-1">
                                    <div class="mb-1 text-white fw-bold" style="display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden;">
                                        {{ $it->product_name }}
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="small" style="color: rgba(255,255,255,0.7); font-weight: 500;">Qty: {{ $it->quantity }}</div>
                                        <div class="fw-bold" style="color: #FFBF00;">K{{ number_format($it->unit_price ?? $it->product_price) }}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="pt-4 mt-auto border-opacity-50 border-top border-secondary">
                        <div class="mb-2 d-flex justify-content-between align-items-center" style="color: rgba(255,255,255,0.7);">
                            <div class="fw-medium">Subtotal</div>
                            <div class="fw-medium">K{{ number_format($subtotal) }}</div>
                        </div>
                        <div class="mb-3 d-flex justify-content-between align-items-center" style="color: rgba(255,255,255,0.7);">
                            <div class="fw-medium">Tax & Fees</div>
                            <div class="fw-medium text-success">Included</div>
                        </div>
                        <div class="mt-4 d-flex justify-content-between align-items-end">
                            <div class="text-white text-uppercase fw-bold" style="letter-spacing: 1px;">Total Amount</div>
                            <div id="total" class="fw-bolder" style="font-size: 1.8rem; color: #FFBF00; line-height: 1;">K{{ number_format($total) }}</div>
                        </div>
                    </div>

                </div>

            </div>
        </form>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('imageInput');
    const preview = document.getElementById('imagesPreview');
    const fileMeta = document.getElementById('fileMeta');
    const clearBtn = document.getElementById('clearImagesBtn');
    const form = document.getElementById('paymentForm');
    const payBtn = document.getElementById('payBtn');
    const amountInput = document.getElementById('amount');
    const dropZone = document.getElementById('dropZone');

    // FIXED: Lowered Max file size to 2MB to match standard PHP/Laravel limits
    const MAX_FILE_SIZE = 2 * 1024 * 1024;

    // Allowed MIME types
    const validImageTypes = ['image/jpeg', 'image/png', 'image/webp'];

    function showNoFiles() {
        preview.innerHTML = '';
        fileMeta.innerHTML = '<i class="fa-regular fa-image me-1"></i> No image selected';
        fileMeta.classList.remove('text-success');
        fileMeta.classList.add('text-primary');
        clearBtn.disabled = true;
        input.value = ''; 
    }

    function handleFiles(files) {
        preview.innerHTML = '';

        if (files.length === 0) {
            showNoFiles();
            return;
        }

        let hasError = false;

        files.forEach(file => {
            if (!validImageTypes.includes(file.type)) {
                hasError = true;
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid File Type',
                    text: `The file "${file.name}" is not a valid image. Please upload JPG, PNG, or WEBP only.`,
                    confirmButtonColor: '#D32F2F'
                });
            }

            else if (file.size > MAX_FILE_SIZE) {
                hasError = true;
                Swal.fire({
                    icon: 'error',
                    title: 'File Too Large',
                    text: `The image "${file.name}" is ${(file.size / 1024 / 1024).toFixed(1)}MB. The limit is 2MB. Please select a smaller image.`,
                    confirmButtonColor: '#D32F2F'
                });
            }
        });

        if (hasError) {
            showNoFiles();
            return;
        }

        fileMeta.innerHTML = `<i class="fa-solid fa-check-circle me-1"></i> ${files.length} file(s) ready to upload`;
        fileMeta.classList.remove('text-primary');
        fileMeta.classList.add('text-success');
        clearBtn.disabled = false;

        files.forEach(file => {
            const reader = new FileReader();
            reader.onload = function (e) {
                const imgContainer = document.createElement('div');
                imgContainer.className = 'preview-image-container border border-2 border-danger';

                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.width = '100px';
                img.style.height = '100px';
                img.style.objectFit = 'cover';

                imgContainer.appendChild(img);
                preview.appendChild(imgContainer);
            };
            reader.readAsDataURL(file);
        });
    }

    input.addEventListener('change', function () {
        handleFiles(Array.from(this.files));
    });

    dropZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        dropZone.classList.add('dragover');
    });

    dropZone.addEventListener('dragleave', function(e) {
        e.preventDefault();
        dropZone.classList.remove('dragover');
    });

    dropZone.addEventListener('drop', function(e) {
        e.preventDefault();
        dropZone.classList.remove('dragover');

        if (e.dataTransfer.files && e.dataTransfer.files.length > 0) {
            input.files = e.dataTransfer.files;
            handleFiles(Array.from(e.dataTransfer.files));
        }
    });

    clearBtn.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        showNoFiles();
    });

    form.addEventListener('submit', function (e) {
        const files = Array.from(input.files || []);
        const amount = parseFloat(amountInput.value || 0);

        if (files.length === 0) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Missing Screenshot',
                text: 'Please upload the payment transaction screenshot to proceed.',
                confirmButtonText: 'Got it',
                confirmButtonColor: '#D32F2F',
                borderRadius: '16px'
            });
            return;
        }

        if (!(amount > 0)) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Invalid Amount',
                text: 'The payment amount must be greater than 0.',
                confirmButtonText: 'Okay',
                confirmButtonColor: '#D32F2F'
            });
            return;
        }

        payBtn.disabled = true;
        payBtn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin me-2"></i> Processing Securely...';
        payBtn.style.opacity = '0.9';
    });
});
</script>

@endsection
