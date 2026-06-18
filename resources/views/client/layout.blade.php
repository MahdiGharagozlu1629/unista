<html>

<head>
    <title>Unista</title>

    <!-- Jquery -->
    <script src="{{asset("js/jquery.min.js")}}"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/lightslider.css')}}">
    <link rel="stylesheet" href="{{asset("css/feather.css")}}">


    <!-- jQuery and JS bundle w/ Popper.js -->
    <script src="{{asset('js/jquery-3.5.1.slim.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('js/lightslider.js')}}"></script>

    <!-- Meta tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


</head>

<body dir="rtl" class="p-3">

<div class="container-fluid pb-5">

    @yield('main')


    <div class="w-100 p-2 footer-card d-flex justify-content-between">
        <a href="{{route("profile")}}">
            <img src="{{asset("img/profile.jpg")}}" alt="profile" class="card-profile">
        </a>
        <a href="#">
            <span class="fe fe-home icon-size"></span>
        </a>
    </div>

</div>


@yield('js')

</body>

</html>
