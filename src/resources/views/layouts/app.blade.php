<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Турбаза')</title>
    <style>
        :root {
            color-scheme: light;
            --bg: #f6f4ef;
            --card: #ffffff;
            --accent: #2c6e49;
            --accent-dark: #1f4f35;
            --text: #1f2937;
            --muted: #6b7280;
            --border: #e5e7eb;
        }
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            font-family: "Georgia", "Times New Roman", serif;
            color: var(--text);
            background: radial-gradient(circle at top, #ffffff, var(--bg));
        }
        a {
            color: var(--accent-dark);
            text-decoration: none;
        }
        .container {
            max-width: 980px;
            margin: 0 auto;
            padding: 32px 20px 60px;
        }
        header {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            gap: 16px;
            border-bottom: 1px solid var(--border);
            padding-bottom: 16px;
            margin-bottom: 28px;
        }
        header h1 {
            margin: 0;
            font-size: 30px;
        }
        header p {
            margin: 4px 0 0;
            color: var(--muted);
        }
        .grid {
            display: grid;
            gap: 20px;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        }
        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 12px 30px rgba(31, 41, 55, 0.08);
        }
        .badge {
            display: inline-block;
            background: #ecfdf3;
            color: var(--accent-dark);
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 12px;
            letter-spacing: 0.4px;
            text-transform: uppercase;
        }
        .price {
            font-size: 20px;
            font-weight: bold;
        }
        .button {
            display: inline-block;
            background: var(--accent);
            color: #ffffff;
            padding: 10px 18px;
            border-radius: 12px;
            border: none;
            cursor: pointer;
        }
        .button:hover {
            background: var(--accent-dark);
        }
        form label {
            display: block;
            margin: 12px 0 6px;
            font-weight: bold;
        }
        form input,
        form textarea,
        form select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid var(--border);
            border-radius: 10px;
            font-family: inherit;
            font-size: 14px;
        }
        .notice {
            background: #e6f4ea;
            border: 1px solid #a3d9b1;
            color: #1f4f35;
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 16px;
        }
        .errors {
            background: #fdecea;
            border: 1px solid #f5b7b1;
            color: #7b241c;
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 16px;
        }
        .meta {
            color: var(--muted);
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <div>
                <h1>Турбаза "Сосновый берег"</h1>
                <p>Бронирование уютных домиков для отдыха на природе</p>
            </div>
            <a class="button" href="{{ route('cabins.index') }}">Все домики</a>
        </header>

        @if (session('success'))
            <div class="notice">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="errors">
                <strong>Проверьте форму:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>
</body>
</html>
