<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unista Login</title>

    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;500;700&display=swap" rel="stylesheet">

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Vazirmatn',sans-serif;
        }

        body{
            min-height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;

            background:
                linear-gradient(
                    135deg,
                    #0d8b95 0%,
                    #076c75 35%,
                    #04545c 70%,
                    #02373e 100%
                );
        }

        .login-card{
            width:380px;
            background:#fff;
            padding:40px 30px;
            border-radius:24px;
            box-shadow:0 20px 40px rgba(0,0,0,.15);
        }

        .logo{
            text-align:center;
            margin-bottom:30px;
        }

        .logo h1{
            font-size:42px;
            font-weight:700;
            background:linear-gradient(90deg,#4f46e5,#ec4899);
            -webkit-background-clip:text;
            -webkit-text-fill-color:transparent;
        }

        .logo p{
            color:#666;
            margin-top:8px;
        }

        .form-group{
            margin-bottom:18px;
        }

        .form-group input{
            width:100%;
            padding:14px;
            border:1px solid #ddd;
            border-radius:12px;
            outline:none;
            transition:.3s;
        }

        .form-group input:focus{
            border-color:#0d8b95;
        }

        .login-btn{
            width:100%;
            padding:14px;
            border:none;
            border-radius:12px;
            background:linear-gradient(
                135deg,
                #0d8b95,
                #076c75
            );
            color:#fff;
            font-size:16px;
            font-weight:600;
            cursor:pointer;
        }

        .login-btn:hover{
            opacity:.9;
        }

        .footer{
            text-align:center;
            margin-top:20px;
            color:#666;
            font-size:14px;
        }

        .footer a{
            color:#0d8b95;
            text-decoration:none;
        }
        .logo-image{
            border-radius: 20px;
        }
    </style>


    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/lightslider.css')}}">
    <link rel="stylesheet" href="{{asset("css/feather.css")}}">

</head>
<body>

<div class="login-card mx-3">

    <div class="logo">
        <img class="logo-image" src="{{asset("logo.png")}}" alt="Unista" width="90">
    </div>

    <form action="{{route("loginToClient")}}" method="post">
        @csrf
        <div class="form-group">
            <input type="text" name="username" placeholder="نام کاربری">
        </div>

        <div class="form-group">
            <input type="password" name="password" placeholder="رمز عبور">
        </div>

        <button class="login-btn">
            ورود
        </button>
    </form>

</div>

</body>
</html>
