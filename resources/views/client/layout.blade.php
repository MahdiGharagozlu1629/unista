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

    <style>
        /* ===================== Instagram-style chrome ===================== */
        body {
            background: #000 !important;
            color: #fafafa;
        }

        /* Top app bar */
        .app-header {
            position: sticky;
            top: 0;
            z-index: 200;
            background: #000;
            border-bottom: 1px solid #262626;
            backdrop-filter: blur(8px);
        }

        .app-header-inner {
            max-width: 640px;
            margin: 0 auto;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 1rem;
        }

        .brand {
            font-family: "Segoe Script", "Brush Script MT", "Grand Hotel", cursive;
            font-size: 30px;
            font-weight: 700;
            letter-spacing: .5px;
            color: #fafafa;
            line-height: 1;
            user-select: none;
        }

        /* Bottom tab bar (Instagram dark) */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            right: 0;
            left: 0;
            z-index: 200;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: space-around;
            background: #000;
            border-top: 1px solid #262626;
        }

        .bottom-nav a {
            color: #fafafa;
            font-size: 24px;
            line-height: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform .2s ease, opacity .2s ease;
        }

        .bottom-nav a:hover {
            opacity: .6;
            text-decoration: none;
        }

        .bottom-nav a:active {
            transform: scale(.9);
        }

        /* Center create button (IG-style square +) */
        .nav-create {
            width: 44px;
            height: 30px;
            border: 2px solid #fafafa;
            border-radius: 8px;
            position: relative;
        }

        .nav-create::before,
        .nav-create::after {
            content: "";
            position: absolute;
            background: #fafafa;
            border-radius: 2px;
        }

        .nav-create::before {
            width: 14px;
            height: 2px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .nav-create::after {
            width: 2px;
            height: 14px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .nav-avatar {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid #fafafa;
        }

        .bottom-nav a.active .nav-avatar {
            box-shadow: 0 0 0 2px #000, 0 0 0 3px #fafafa;
        }
    </style>

    <!-- jQuery and JS bundle w/ Popper.js -->
    <script src="{{asset('js/jquery-3.7.1.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('js/lightslider.js')}}"></script>

    <!-- Meta tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{csrf_field()}}

</head>

<body dir="rtl" class="p-0 m-0">

<!-- Top app bar -->
<header class="app-header">
    <div class="app-header-inner">
        <span class="brand">Unista</span>
    </div>
</header>

<div class="container-fluid pt-3 pb-5" style="max-width: 640px; margin: 0 auto;">

    @yield('main')


    <!-- Bottom tab bar -->
    <nav class="bottom-nav">
        <a href="{{route('index')}}" title="خانه">
            <span class="fe fe-home"></span>
        </a>
        <a href="#" title="جستجو">
            <span class="fe fe-search"></span>
        </a>
        <a href="{{route('post.create')}}" title="ایجاد پست">
            <span class="nav-create"></span>
        </a>
        <a href="#" title="فعالیت">
            <span class="fe fe-heart"></span>
        </a>
        <a href="{{route('profile')}}" title="پروفایل">
            <img src="{{asset('img/profile.jpg')}}" alt="profile" class="nav-avatar">
        </a>
    </nav>

</div>

<script src="{{asset("admin/js/dropzone.min.js")}}"></script>
@yield('js')

<script type="module">
    // Import the functions you need from the SDKs you need
    import { initializeApp } from "https://www.gstatic.com/firebasejs/12.15.0/firebase-app.js";
    import { getAnalytics } from "https://www.gstatic.com/firebasejs/12.15.0/firebase-analytics.js";
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
        from "https://www.gstatic.com/firebasejs/12.15.0/firebase-app.js";

    import { getMessaging, getToken, onMessage }
        from "https://www.gstatic.com/firebasejs/12.15.0/firebase-messaging.js";


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
