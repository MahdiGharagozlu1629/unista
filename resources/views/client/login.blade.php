<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>ورود به یونیستا • Unista</title>

    <link rel="stylesheet" href="{{asset('css/vazirmatn.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset("css/feather.css")}}">

    <style>
        :root {
            --ig-bg: #000000;
            --ig-card: #000000;
            --ig-border: #262626;
            --ig-input: #121212;
            --ig-blue: #0095f6;
            --ig-blue-hover: #1877f2;
            --ig-text: #fafafa;
            --ig-muted: #a8a8a8;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Vazirmatn', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: var(--ig-bg);
            color: var(--ig-text);
            padding: 20px 16px;
        }

        .login-card {
            width: 100%;
            max-width: 360px;
            background: var(--ig-card);
            border: 1px solid var(--ig-border);
            border-radius: 12px;
            padding: 40px 32px 30px;
            text-align: center;
        }

        .brand-logo {
            font-family: "Segoe Script", "Brush Script MT", "Grand Hotel", cursive;
            font-size: 40px;
            font-weight: 700;
            color: #fafafa;
            letter-spacing: .5px;
            margin-bottom: 24px;
            display: block;
            text-decoration: none;
            user-select: none;
        }

        .brand-logo:hover {
            color: #fff;
            text-decoration: none;
        }

        .form-group {
            margin-bottom: 12px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 14px;
            background: var(--ig-input);
            border: 1px solid var(--ig-border);
            border-radius: 8px;
            color: #fafafa;
            font-size: 13.5px;
            outline: none;
            transition: border-color .18s ease;
        }

        .form-group input::placeholder {
            color: #737373;
            font-size: 13px;
        }

        .form-group input:focus {
            border-color: #555555;
            background: #161616;
        }

        .login-btn {
            width: 100%;
            padding: 11px;
            margin-top: 8px;
            border: none;
            border-radius: 8px;
            background: var(--ig-blue);
            color: #fff;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: background .18s ease, transform .1s ease;
        }

        .login-btn:hover {
            background: var(--ig-blue-hover);
        }

        .login-btn:active {
            transform: scale(.98);
        }

        .divider-row {
            display: flex;
            align-items: center;
            margin: 24px 0 18px;
            color: #737373;
            font-size: 12.5px;
            font-weight: 600;
        }

        .divider-row::before,
        .divider-row::after {
            content: "";
            flex: 1;
            height: 1px;
            background: var(--ig-border);
        }

        .divider-row span {
            padding: 0 14px;
        }

        .footer-card {
            width: 100%;
            max-width: 360px;
            background: var(--ig-card);
            border: 1px solid var(--ig-border);
            border-radius: 12px;
            padding: 18px 24px;
            text-align: center;
            margin-top: 12px;
            font-size: 13px;
            color: var(--ig-muted);
        }

        .footer-card a {
            color: var(--ig-blue);
            text-decoration: none;
            font-weight: 600;
            margin-inline-start: 4px;
        }

        .footer-card a:hover {
            text-decoration: underline;
        }

        /* Mobile (< 480px) */
        @media (max-width: 479.98px) {
            body {
                padding: 16px 12px;
                justify-content: flex-start;
                padding-top: 40px;
            }

            .login-card {
                border: none;
                padding: 24px 16px;
            }

            .footer-card {
                border: none;
                margin-top: 0;
            }
        }
    </style>
</head>
<body>

<div class="login-card">
    <a href="#" class="brand-logo">Unista</a>

    <form action="{{route("loginToClient")}}" method="post">
        @csrf
        <div class="form-group">
            <input type="text" name="username" placeholder="نام کاربری" autocomplete="username" required>
        </div>

        <div class="form-group">
            <input type="password" name="password" placeholder="رمز عبور" autocomplete="current-password" required>
        </div>

        <button type="submit" class="login-btn">
            ورود
        </button>
    </form>

    <div class="divider-row">
        <span>یا</span>
    </div>

    <div style="font-size: 12.5px; color: #8e8e8e;">
        شبکه اجتماعی اختصاصی دانشجویان دانشگاه
    </div>
</div>

<div class="footer-card">
    <span>پنل مدیریت دارید؟</span>
    <a href="{{ route('admin.index') }}">ورود به مدیریت</a>
</div>

</body>
</html>
