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

    <style>
        /* ===================== Instagram-style Responsive Design ===================== */
        :root {
            --ig-bg: #000000;
            --ig-card-bg: #000000;
            --ig-border: #262626;
            --ig-border-subtle: #1f1f1f;
            --ig-text: #fafafa;
            --ig-muted: #a8a8a8;
            --ig-secondary: #737373;
            --ig-blue: #0095f6;
            --ig-blue-hover: #1877f2;
            --ig-hover: #121212;
            --ig-active: #1a1a1a;
            --sidebar-width-expanded: 240px;
            --sidebar-width-collapsed: 72px;
            --bottom-nav-height: 52px;
        }

        * {
            box-sizing: border-box;
            font-family: 'Vazirmatn', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }

        body {
            background: var(--ig-bg) !important;
            color: var(--ig-text);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Brand logo */
        .brand {
            font-family: "Segoe Script", "Brush Script MT", "Grand Hotel", cursive;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: .5px;
            color: var(--ig-text);
            line-height: 1;
            user-select: none;
            text-decoration: none;
        }

        .brand:hover {
            color: #fff;
            text-decoration: none;
        }

        /* ----------------- Mobile Header (< 768px) ----------------- */
        .app-header {
            position: sticky;
            top: 0;
            z-index: 200;
            background: rgba(0, 0, 0, 0.88);
            border-bottom: 1px solid var(--ig-border);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        .app-header-inner {
            max-width: 640px;
            margin: 0 auto;
            height: 52px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1rem;
        }

        .app-header-actions {
            display: flex;
            align-items: center;
            gap: 1.1rem;
        }

        .app-header-actions a {
            color: var(--ig-text);
            font-size: 22px;
            line-height: 1;
            position: relative;
            text-decoration: none;
            display: flex;
            align-items: center;
        }

        /* ----------------- Mobile Bottom Navigation (< 768px) ----------------- */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            right: 0;
            left: 0;
            z-index: 200;
            height: calc(var(--bottom-nav-height) + env(safe-area-inset-bottom, 0px));
            padding-bottom: env(safe-area-inset-bottom, 0px);
            display: flex;
            align-items: center;
            justify-content: space-around;
            background: rgba(0, 0, 0, 0.95);
            border-top: 1px solid var(--ig-border);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        .bottom-nav a {
            color: var(--ig-text);
            font-size: 24px;
            line-height: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 8px 12px;
            transition: transform .2s ease, opacity .2s ease;
            text-decoration: none;
        }

        .bottom-nav a:active {
            transform: scale(.88);
        }

        .bottom-nav a.active {
            color: #fff;
        }

        /* Create button */
        .nav-create {
            width: 24px;
            height: 24px;
            border: 2px solid var(--ig-text);
            border-radius: 7px;
            position: relative;
            display: inline-block;
        }

        .nav-create::before,
        .nav-create::after {
            content: "";
            position: absolute;
            background: var(--ig-text);
            border-radius: 1px;
        }

        .nav-create::before {
            width: 12px;
            height: 2px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .nav-create::after {
            width: 2px;
            height: 12px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .nav-avatar {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            object-fit: cover;
            border: 1.5px solid transparent;
        }

        .bottom-nav a.active .nav-avatar,
        .sidebar-item.active .sidebar-avatar {
            border-color: var(--ig-text);
            box-shadow: 0 0 0 2px #000, 0 0 0 3px var(--ig-text);
        }

        /* ----------------- Desktop & Tablet Sidebar (>= 768px) ----------------- */
        .desktop-sidebar {
            display: none;
            position: fixed;
            top: 0;
            bottom: 0;
            right: 0; /* RTL: sidebar on the right side */
            background: #000;
            border-left: 1px solid var(--ig-border);
            z-index: 250;
            flex-direction: column;
            justify-content: space-between;
            padding: 24px 12px 20px;
            overflow-y: auto;
        }

        .sidebar-brand-wrap {
            padding: 8px 14px 28px;
            display: flex;
            align-items: center;
        }

        .sidebar-brand-wrap .brand-icon {
            display: none;
            font-size: 26px;
            color: var(--ig-text);
        }

        .sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 6px;
            list-style: none;
            padding: 0;
            margin: 0;
            flex: 1 1 auto;
        }

        .sidebar-item {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 12px 14px;
            border-radius: 10px;
            color: var(--ig-text);
            text-decoration: none;
            font-size: 15px;
            font-weight: 400;
            transition: background .18s ease, transform .12s ease;
            user-select: none;
        }

        .sidebar-item:hover {
            background: var(--ig-hover);
            color: #fff;
            text-decoration: none;
        }

        .sidebar-item:active {
            transform: scale(.98);
        }

        .sidebar-item.active {
            font-weight: 700;
            color: #fff;
        }

        .sidebar-item .fe,
        .sidebar-item .sidebar-icon {
            font-size: 24px;
            line-height: 1;
            width: 28px;
            text-align: center;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .sidebar-item .sidebar-title {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar-avatar {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            object-fit: cover;
            border: 1.5px solid transparent;
            flex-shrink: 0;
        }

        .sidebar-bottom {
            margin-top: auto;
            display: flex;
            flex-direction: column;
            gap: 6px;
            padding-top: 16px;
            border-top: 1px solid var(--ig-border-subtle);
        }

        /* ----------------- Responsive App Shell ----------------- */
        .app-main {
            min-height: 100vh;
            transition: margin-right .2s ease;
        }

        /* Mobile View (< 768px) */
        @media (max-width: 767.98px) {
            .desktop-sidebar {
                display: none !important;
            }
            .app-header {
                display: block;
            }
            .bottom-nav {
                display: flex;
            }
            .app-main {
                margin-right: 0 !important;
                padding-bottom: calc(var(--bottom-nav-height) + env(safe-area-inset-bottom, 0px) + 16px);
            }
        }

        /* Tablet View (768px - 1023.98px) -> Collapsed Icon Rail */
        @media (min-width: 768px) and (max-width: 1023.98px) {
            .app-header {
                display: none !important;
            }
            .bottom-nav {
                display: none !important;
            }
            .desktop-sidebar {
                display: flex !important;
                width: var(--sidebar-width-collapsed);
                padding: 20px 8px;
                align-items: center;
            }
            .sidebar-brand-wrap {
                padding: 8px 0 24px;
                justify-content: center;
            }
            .sidebar-brand-wrap .brand-text {
                display: none;
            }
            .sidebar-brand-wrap .brand-icon {
                display: inline-block;
            }
            .sidebar-item {
                justify-content: center;
                padding: 12px;
                width: 48px;
                height: 48px;
            }
            .sidebar-item .sidebar-title {
                display: none;
            }
            .app-main {
                margin-right: var(--sidebar-width-collapsed) !important;
                padding: 24px 16px;
            }
        }

        /* Desktop View (>= 1024px) -> Full Sidebar */
        @media (min-width: 1024px) {
            .app-header {
                display: none !important;
            }
            .bottom-nav {
                display: none !important;
            }
            .desktop-sidebar {
                display: flex !important;
                width: var(--sidebar-width-expanded);
            }
            .sidebar-brand-wrap .brand-text {
                display: inline-block;
            }
            .sidebar-brand-wrap .brand-icon {
                display: none;
            }
            .app-main {
                margin-right: var(--sidebar-width-expanded) !important;
                padding: 28px 24px;
            }
        }

        /* Main Content Container */
        .app-container {
            width: 100%;
            max-width: 935px;
            margin: 0 auto;
        }
    </style>

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
                <a href="#" class="sidebar-item">
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
    <a href="#" title="جستجو">
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
