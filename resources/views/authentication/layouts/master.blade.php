<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title', 'Sign in — Khit PC')</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('user/authentication/css/login.css') }}">
</head>
<body>

  <div class="auth-card" role="main">

    <aside class="overflow-hidden auth-visual d-none d-lg-flex position-relative">
      <div class="bg-glow"></div>

      <div class="d-flex flex-column justify-content-between h-100 position-relative" style="z-index: 2;">
        <div class="brand">
            <i class="fa-solid fa-laptop me-2"></i>Khit PC
        </div>

        <div class="text-center showcase-container">
          <img src="{{ asset('user/authentication/image/laptop_login.jpg') }}" alt="Premium Laptop" class="showcase-laptop img-fluid rounded-3">
        </div>

        <div class="visual-text-area">
          <div class="visual-title animate-text">Find the right laptop for your needs</div>
          <div class="visual-sub animate-text delay-1">Secure access to your Khit PC dashboard. Manage orders, track shipments, and explore the latest tech.</div>
        </div>
      </div>
    </aside>

    @yield('content')
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);

        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
  </script>
</body>
</html>
