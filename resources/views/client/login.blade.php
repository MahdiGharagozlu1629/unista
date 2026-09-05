<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>ورود به یونیستا • Unista</title>

    <link rel="stylesheet" href="{{asset('css/vazirmatn.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset("css/feather.css")}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
</head>
<body class="login-body">

<div class="login-card">
    <a href="#" class="brand-logo">Unista</a>

    <form class="login-form" action="{{route("loginToClient")}}" method="post">
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

<div class="login-footer-card">
    <span>پنل مدیریت دارید؟</span>
    <a href="{{ route('admin.index') }}">ورود به مدیریت</a>
</div>

</body>
</html>
