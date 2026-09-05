<html>

<head>
    <title>Unista</title>

    <!-- Jquery -->
    <script src="{{asset("js/jquery.min.js")}}"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/lightslider.css')}}">
    <link rel="stylesheet" href="{{asset("css/feather.css")}}">
    <link rel="stylesheet" href="{{asset("admin/css/dropzone.css")}}">
    <link rel="stylesheet" href="{{asset("admin/css/dropzone.min.css")}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">

    <link rel="stylesheet" href="{{asset('css/vazirmatn.css')}}">



    <!-- jQuery and JS bundle w/ Popper.js -->
    <script src="{{asset('js/jquery-3.7.1.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('js/lightslider.js')}}"></script>

    <!-- Meta tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    {{csrf_field()}}

</head>

<body dir="rtl" class="p-0 m-0">

<!-- Desktop / Tablet Sidebar (>= 768px) -->
<aside class="desktop-sidebar">
    <div>
        <div class="sidebar-brand-wrap">
            <a href="{{ route('index') }}" class="brand brand-text">Unista</a>
            <a href="{{ route('index') }}" class="brand-icon" title="Unista">
                <span class="fe fe-instagram"></span>
            </a>
        </div>

        <ul class="sidebar-nav">
            <li>
                <a href="{{ route('index') }}" class="sidebar-item {{ request()->routeIs('index') ? 'active' : '' }}">
                    <span class="fe fe-home"></span>
                    <span class="sidebar-title">خانه</span>
                </a>
            </li>
            <li>
                <a href="{{ route('search') }}" class="sidebar-item {{ request()->routeIs('search') ? 'active' : '' }}">
                    <span class="fe fe-search"></span>
                    <span class="sidebar-title">جستجو</span>
                </a>
            </li>
            <li>
                <a href="{{ route('post.create') }}" class="sidebar-item {{ request()->routeIs('post.create') ? 'active' : '' }}">
                    <span class="sidebar-icon"><span class="nav-create"></span></span>
                    <span class="sidebar-title">ایجاد پست</span>
                </a>
            </li>
            <li>
                <a href="{{ route('follow.requests') }}" class="sidebar-item {{ request()->routeIs('follow.requests') ? 'active' : '' }}">
                    <span class="fe fe-heart"></span>
                    <span class="sidebar-title">درخواست‌ها</span>
                </a>
            </li>
            <li>
                <a href="{{ route('profile') }}" class="sidebar-item {{ request()->routeIs('profile') ? 'active' : '' }}">
                    <img src="{{ asset('img/profile.jpg') }}" alt="profile" class="sidebar-avatar">
                    <span class="sidebar-title">پروفایل</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="sidebar-bottom">
        <a href="{{ route('login') }}" class="sidebar-item text-danger" title="خروج">
            <span class="fe fe-log-out"></span>
            <span class="sidebar-title">خروج</span>
        </a>
    </div>
</aside>

<!-- Mobile Top App Bar (< 768px) -->
<header class="app-header">
    <div class="app-header-inner">
        <a href="{{ route('index') }}" class="brand">Unista</a>
        <div class="app-header-actions">
            <a href="{{ route('follow.requests') }}" title="درخواست‌ها">
                <span class="fe fe-heart"></span>
            </a>
            <a href="#" title="پیام‌ها">
                <span class="fe fe-send"></span>
            </a>
        </div>
    </div>
</header>

<!-- Main content area -->
<main class="app-main">
    <div class="app-container">
        @yield('main')
    </div>
</main>

<!-- Mobile Bottom Tab Bar (< 768px) -->
<nav class="bottom-nav">
    <a href="{{ route('index') }}" class="{{ request()->routeIs('index') ? 'active' : '' }}" title="خانه">
        <span class="fe fe-home"></span>
    </a>
    <a href="{{ route('search') }}" class="{{ request()->routeIs('search') ? 'active' : '' }}" title="جستجو">
        <span class="fe fe-search"></span>
    </a>
    <a href="{{ route('post.create') }}" class="{{ request()->routeIs('post.create') ? 'active' : '' }}" title="ایجاد پست">
        <span class="nav-create"></span>
    </a>
    <a href="{{ route('follow.requests') }}" class="{{ request()->routeIs('follow.requests') ? 'active' : '' }}" title="درخواست‌ها">
        <span class="fe fe-heart"></span>
    </a>
    <a href="{{ route('profile') }}" class="{{ request()->routeIs('profile') ? 'active' : '' }}" title="پروفایل">
        <img src="{{ asset('img/profile.jpg') }}" alt="profile" class="nav-avatar">
    </a>
</nav>

<script src="{{asset("admin/js/dropzone.min.js")}}"></script>
@yield('js')

<script type="module">
    // Import the functions you need from the SDKs you need
    import { initializeApp } from "{{asset('js/firebase/firebase-app.js')}}";
    import { getAnalytics } from "{{asset('js/firebase/firebase-analytics.js')}}";
    // TODO: Add SDKs for Firebase products that you want to use
    // https://firebase.google.com/docs/web/setup#available-libraries

    // Your web app's Firebase configuration
    // For Firebase JS SDK v7.20.0 and later, measurementId is optional
    const firebaseConfig = {
        apiKey: "«reda...…»",
        authDomain: "unista-599bf.firebaseapp.com",
        projectId: "unista-599bf",
        storageBucket: "unista-599bf.firebasestorage.app",
        messagingSenderId: "833125471013",
        appId: "1:833125471013:web:16c0c6f9882a15b1a9c0cc",
        measurementId: "G-E0VJKKV9MG"
    };

    // Initialize Firebase
    const app = initializeApp(firebaseConfig);
    const analytics = getAnalytics(app);
</script>


<script type="module">

    import { initializeApp }
        from "{{asset('js/firebase/firebase-app.js')}}";

    import { getMessaging, getToken, onMessage }
        from "{{asset('js/firebase/firebase-messaging.js')}}";


    const firebaseConfig = {
        apiKey: "«reda...…»",
        authDomain: "unista-599bf.firebaseapp.com",
        projectId: "unista-599bf",
        storageBucket: "unista-599bf.firebasestorage.app",
        messagingSenderId: "833125471013",
        appId: "1:833125471013:web:16c0c6f9882a15b1a9c0cc"
    };


    const app = initializeApp(firebaseConfig);

    const messaging = getMessaging(app);


    // گرفتن Permission
    Notification.requestPermission()
        .then(permission => {

            if(permission === "granted"){

                console.log("Notification permission granted");

                getToken(messaging,{
                    vapidKey:"BJb-Dfp6nYJ9sWkOSGnvfTgBcfEAjqyK6M7SKNXQdiIRQJWXYyGPghVhEmvfgDPrA8bFl2hRUHJzFo1JExqUdNg"
                })
                    .then(token=>{

                        console.log("FCM TOKEN:",token);

                        // اینجا token رو بفرست Laravel
                        // Ajax -> /save-token

                    });

            }

        });


    // وقتی صفحه بازه و نوتیف میاد
    onMessage(messaging,(payload)=>{

        console.log("Message received:",payload);


        new Notification(
            payload.notification.title,
            {
                body:payload.notification.body,
                icon:"/img/logo.png"
            }
        );

    });


</script>


</body>

</html>
