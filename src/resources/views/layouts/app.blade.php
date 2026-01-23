<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Турбаза')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            color-scheme: light;
            --forest-900: #1f3a2a;
            --forest-700: #2d5a40;
            --forest-500: #3e7a58;
            --sand-50: #f7f5f0;
            --sand-100: #efece4;
            --sky-50: #f4f7fb;
            --shadow-soft: 0 18px 40px rgba(31, 41, 55, 0.12);
        }
        body {
            font-family: "Manrope", "Segoe UI", sans-serif;
            color: #1f2937;
            background: radial-gradient(circle at top, #ffffff 0%, var(--sky-50) 35%, var(--sand-50) 100%);
        }
        .navbar-brand {
            font-weight: 700;
            letter-spacing: 0.3px;
        }
        .brand-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 12px;
            background: var(--forest-700);
            color: #fff;
            margin-right: 10px;
            box-shadow: var(--shadow-soft);
        }
        .hero {
            background: linear-gradient(120deg, #ffffff 0%, #f7faf8 55%, #edf4f0 100%);
            border: 1px solid rgba(31, 41, 55, 0.08);
            border-radius: 24px;
            padding: 32px;
            box-shadow: var(--shadow-soft);
        }
        .pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
            background: rgba(46, 125, 80, 0.12);
            color: var(--forest-700);
        }
        .booking-card {
            border-radius: 20px;
            border: 1px solid rgba(31, 41, 55, 0.08);
            box-shadow: var(--shadow-soft);
        }
        .booking-card img {
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
            height: 220px;
            object-fit: cover;
        }
        .price-tag {
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--forest-900);
        }
        .btn-forest {
            background: var(--forest-700);
            color: #fff;
            border: none;
        }
        .btn-forest:hover {
            background: var(--forest-900);
            color: #fff;
        }
        .soft-card {
            border-radius: 20px;
            border: 1px solid rgba(31, 41, 55, 0.08);
            box-shadow: var(--shadow-soft);
            background: #fff;
        }
        .form-control,
        .form-select {
            border-radius: 12px;
            border-color: rgba(31, 41, 55, 0.12);
        }
        .section-title {
            font-weight: 700;
            letter-spacing: 0.3px;
        }
        .category-pill {
            background: var(--sand-100);
            border-radius: 999px;
            padding: 6px 14px;
            font-size: 13px;
            color: #4b5563;
        }
        .footer-note {
            color: #6b7280;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top">
        <div class="container py-2">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('cabins.index') }}">
                <span class="brand-badge">
                    <i class="bi bi-tree"></i>
                </span>
                Сосновый берег
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-3">
                    <li class="nav-item"><a class="nav-link" href="{{ route('cabins.index') }}">Домики</a></li>
                    <li class="nav-item"><a class="nav-link" href="#features">Преимущества</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contacts">Контакты</a></li>
                    <li class="nav-item d-flex align-items-center text-muted small">
                        <i class="bi bi-telephone me-2"></i> +7 (845) 126-04-93
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-forest" href="{{ route('cabins.index') }}">Забронировать</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container py-4 py-lg-5">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Проверьте форму:</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')

        <div class="mt-5 pt-4 border-top footer-note" id="contacts">
            <div class="row gy-3 align-items-center">
                <div class="col-md-8">
                    <strong>Турбаза "Сосновый берег"</strong> · Саратовская область · Приезд с 16:00, выезд до 12:00
                </div>
                <div class="col-md-4 text-md-end">
                    <i class="bi bi-envelope me-2"></i>hello@pinebay.example
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
