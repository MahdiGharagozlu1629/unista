<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">
    <title>Unista</title>
    <!-- Simple bar CSS -->
    <link rel="stylesheet" href="{{asset("admin/css/simplebar.css")}}">
    <!-- Fonts CSS -->
    <!-- Icons CSS -->
    <link rel="stylesheet" href="{{asset("admin/css/feather.css")}}">
    <!-- Date Range Picker CSS -->
    <link rel="stylesheet" href="{{asset("admin/css/daterangepicker.css")}}">
    <!-- App CSS -->
    <link rel="stylesheet" href="{{asset("admin/css/app-light.css")}}" id="lightTheme">
    <link rel="stylesheet" href="{{asset("admin/css/app-dark.css")}}" id="darkTheme" disabled>
</head>
<body class="light rtl">
<div class="wrapper vh-100">
    <div class="row align-items-center h-100">
        <form class="col-lg-3 col-md-4 col-10 mx-auto text-center" method="post" action="{{route("loginToPanel")}}">
            @csrf
            <svg version="1.1" id="logo" class="navbar-brand-img brand-md" xmlns="http://www.w3.org/2000/svg"
                 xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 120 120" xml:space="preserve">
              <g>
                  <polygon class="st0" points="78,105 15,105 24,87 87,87 	"/>
                  <polygon class="st0" points="96,69 33,69 42,51 105,51 	"/>
                  <polygon class="st0" points="78,33 15,33 24,15 87,15 	"/>
              </g>
            </svg>
            <div class="form-group">
                <label for="inputUsername" class="sr-only">نام کاربری</label>
                <input type="text" id="inputUsername" name="username" class="form-control form-control-lg" placeholder="نام کاربری"
                       required="" autofocus="">
            </div>
            <div class="form-group">
                <label for="inputPassword" class="sr-only">رمز عبور</label>
                <input type="password" id="inputPassword" name="password" class="form-control form-control-lg" placeholder="رمز عبور"
                       required="">
            </div>
            <button class="btn btn-lg btn-primary btn-block" type="submit">ورود به سامانه</button>
        </form>
    </div>
</div>
<script src="{{asset("admin/js/jquery.min.js")}}"></script>
<script src="{{asset("admin/js/popper.min.js")}}"></script>
<script src="{{asset("admin/js/moment.min.js")}}"></script>
<script src="{{asset("admin/js/bootstrap.min.js")}}"></script>
<script src="{{asset("admin/js/simplebar.min.js")}}"></script>
<script src='{{asset("admin/js/daterangepicker.js")}}'></script>
<script src='{{asset("admin/js/jquery.stickOnScroll.js")}}'></script>
<script src="{{asset("admin/js/tinycolor-min.js")}}"></script>
<script src="{{asset("admin/js/config.js")}}"></script>
<script src="{{asset("admin/js/apps.js")}}"></script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }

    gtag('js', new Date());
    gtag('config', 'UA-56159088-1');
</script>
</body>
</html>
