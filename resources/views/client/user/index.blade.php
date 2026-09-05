@extends('client.layout')
@section('main')

    <style>
        .ig-profile {
            max-width: 935px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        /* ----------------- Profile Header ----------------- */
        .profile-header {
            display: flex;
            align-items: center;
            gap: 2.5rem;
            padding: 1.5rem 0 2.5rem;
        }

        .avatar-wrap {
            flex: 0 0 auto;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .profile-avatar {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid var(--ig-border, #262626);
            padding: 2px;
            background: #000;
        }

        .profile-info {
            flex: 1 1 auto;
            min-width: 0;
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }

        .profile-title-row {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            flex-wrap: wrap;
        }

        .profile-username {
            color: #fafafa;
            font-size: 20px;
            font-weight: 400;
            margin: 0;
            line-height: 1;
        }

        .profile-actions-inline {
            display: flex;
            align-items: center;
            gap: .6rem;
            flex-wrap: wrap;
        }

        .ig-btn {
            border-radius: 8px;
            padding: .5rem 1.1rem;
            font-size: 13.5px;
            font-weight: 600;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .4rem;
            transition: background .18s ease, transform .1s ease, opacity .18s ease;
            cursor: pointer;
            text-decoration: none;
            color: #fafafa;
            white-space: nowrap;
        }

        .ig-btn:active {
            transform: scale(.97);
        }

        .ig-btn-follow {
            background: var(--ig-blue, #0095f6);
            color: #fff;
        }

        .ig-btn-follow:hover {
            background: var(--ig-blue-hover, #1877f2);
            color: #fff;
            text-decoration: none;
        }

        .ig-btn-unfollow {
            background: #262626;
            color: #fafafa;
        }

        .ig-btn-unfollow:hover {
            background: #363636;
            color: #fafafa;
            text-decoration: none;
        }

        .ig-btn-message {
            background: #262626;
            color: #fafafa;
            text-decoration: none;
        }

        .ig-btn-message:hover {
            background: #363636;
            color: #fafafa;
            text-decoration: none;
        }

        .profile-stats {
            display: flex;
            align-items: center;
            gap: 2.5rem;
            color: #fafafa;
            font-size: 15px;
        }

        .profile-stats .stat {
            white-space: nowrap;
        }

        .profile-stats .stat b {
            font-weight: 700;
            font-size: 16px;
        }

        .profile-stats .stat span {
            color: #ededed;
            margin-inline-start: 4px;
        }

        .profile-bio {
            color: #fafafa;
            font-size: 14px;
            line-height: 1.5;
        }

        .profile-bio .bio-name {
            font-weight: 700;
            display: block;
            margin-bottom: 2px;
        }

        /* ----------------- Profile Tabs ----------------- */
        .profile-tabs {
            border-top: 1px solid var(--ig-border, #262626);
            display: flex;
            justify-content: center;
            gap: 3rem;
            margin-top: .5rem;
        }

        .profile-tab {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            padding: 1rem 0;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 1px;
            color: #a8a8a8;
            text-decoration: none;
            border-top: 1px solid transparent;
            margin-top: -1px;
            cursor: pointer;
        }

        .profile-tab.active {
            color: #fafafa;
            border-top-color: #fafafa;
        }

        .profile-tab:hover {
            color: #fff;
            text-decoration: none;
        }

        /* ----------------- Posts Grid ----------------- */
        .posts-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 1rem;
            margin-bottom: 2rem;
        }

        .posts-grid a {
            position: relative;
            aspect-ratio: 1 / 1;
            overflow: hidden;
            display: block;
            background: #121212;
            border-radius: 4px;
        }

        .posts-grid img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform .25s ease;
        }

        .posts-grid a:hover img {
            transform: scale(1.02);
        }

        .posts-grid a .grid-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, .35);
            opacity: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1.5rem;
            color: #fff;
            font-weight: 700;
            font-size: 15px;
            transition: opacity .2s ease;
        }

        .posts-grid a:hover .grid-overlay {
            opacity: 1;
        }

        .empty-posts {
            text-align: center;
            color: #a8a8a8;
            padding: 4rem 1rem;
        }

        .empty-posts .fe {
            font-size: 2.8rem;
            color: #d6249f;
            opacity: .8;
        }

        /* ----------------- Mobile Adjustments (< 768px) ----------------- */
        @media (max-width: 767.98px) {
            .ig-profile {
                padding: 0;
            }

            .profile-header {
                display: block;
                padding: 1rem 1rem 0;
            }

            .profile-top-mobile {
                display: flex;
                align-items: center;
                gap: 1.5rem;
                margin-bottom: 1rem;
            }

            .profile-avatar {
                width: 77px;
                height: 77px;
            }

            .profile-stats-mobile {
                flex: 1 1 auto;
                display: flex;
                justify-content: space-around;
                align-items: center;
                text-align: center;
            }

            .profile-stats-mobile .stat {
                display: flex;
                flex-direction: column;
            }

            .profile-stats-mobile .stat b {
                font-size: 17px;
                line-height: 1.2;
            }

            .profile-stats-mobile .stat span {
                font-size: 13px;
                color: #a8a8a8;
                margin-inline-start: 0;
            }

            .profile-desktop-stats {
                display: none !important;
            }

            .profile-desktop-actions {
                display: none !important;
            }

            .profile-bio-mobile {
                margin-bottom: 1rem;
            }

            .profile-actions-mobile {
                display: flex;
                gap: .5rem;
                margin-bottom: 1rem;
            }

            .profile-actions-mobile form,
            .profile-actions-mobile a {
                flex: 1 1 0;
            }

            .profile-actions-mobile .ig-btn {
                width: 100%;
                padding: .5rem;
                font-size: 13px;
            }

            .profile-tabs {
                gap: 0;
            }

            .profile-tab {
                flex: 1 1 0;
                justify-content: center;
                font-size: 11px;
                padding: .75rem 0;
            }

            .posts-grid {
                gap: 3px;
                margin-top: 0;
                margin-bottom: 1rem;
            }

            .posts-grid a {
                border-radius: 0;
            }

            .posts-grid a .grid-overlay {
                display: none;
            }
        }
    </style>

    <div class="ig-profile">

        {{-- Profile Header --}}
        <header class="profile-header">

            {{-- Mobile Layout (< 768px) --}}
            <div class="d-md-none">
                <div class="profile-top-mobile">
                    <div class="avatar-wrap">
                        <img class="profile-avatar" src="{{ asset('img/profile.jpg') }}" alt="{{ $user->username }}">
                    </div>
                    <div class="profile-stats-mobile">
                        <div class="stat">
                            <b>{{ count($user->posts) }}</b>
                            <span>پست‌ها</span>
                        </div>
                        <div class="stat">
                            <b>100</b>
                            <span>دنبال‌کننده</span>
                        </div>
                        <div class="stat">
                            <b>5,000</b>
                            <span>دنبال‌شونده</span>
                        </div>
                    </div>
                </div>

                <div class="profile-bio-mobile">
                    <div class="profile-username font-weight-bold mb-1">{{ $user->username }}</div>
                    <div class="profile-bio text-muted">دانشجوی فعال دانشگاه • پلتفرم Unista</div>
                </div>

                <div class="profile-actions-mobile">
                    @if($hasFollowing)
                        <form action="{{ route('unfollow') }}" method="post" class="m-0">
                            @csrf
                            <input type="hidden" name="following_id" value="{{ $user->id }}">
                            <button type="submit" class="ig-btn ig-btn-unfollow">
                                <i class="fe fe-user-minus"></i>
                                لغو دنبال کردن
                            </button>
                        </form>
                    @else
                        <form action="{{ route('follow') }}" method="post" class="m-0">
                            @csrf
                            <input type="hidden" name="following_id" value="{{ $user->id }}">
                            <button type="submit" class="ig-btn ig-btn-follow">
                                <i class="fe fe-user-plus"></i>
                                دنبال کردن
                            </button>
                        </form>
                    @endif
                    <a class="ig-btn ig-btn-message" href="#">
                        <i class="fe fe-message-square"></i>
                        پیام
                    </a>
                </div>
            </div>

            {{-- Desktop Layout (>= 768px) --}}
            <div class="avatar-wrap d-none d-md-flex">
                <img class="profile-avatar" src="{{ asset('img/profile.jpg') }}" alt="{{ $user->username }}">
            </div>

            <div class="profile-info d-none d-md-flex">
                <div class="profile-title-row">
                    <h1 class="profile-username">{{ $user->username }}</h1>
                    <div class="profile-actions-inline profile-desktop-actions">
                        @if($hasFollowing)
                            <form action="{{ route('unfollow') }}" method="post" class="m-0">
                                @csrf
                                <input type="hidden" name="following_id" value="{{ $user->id }}">
                                <button type="submit" class="ig-btn ig-btn-unfollow">
                                    <i class="fe fe-user-minus"></i>
                                    لغو دنبال کردن
                                </button>
                            </form>
                        @else
                            <form action="{{ route('follow') }}" method="post" class="m-0">
                                @csrf
                                <input type="hidden" name="following_id" value="{{ $user->id }}">
                                <button type="submit" class="ig-btn ig-btn-follow">
                                    <i class="fe fe-user-plus"></i>
                                    دنبال کردن
                                </button>
                            </form>
                        @endif
                        <a class="ig-btn ig-btn-message" href="#">
                            <i class="fe fe-message-square"></i>
                            پیام
                        </a>
                    </div>
                </div>

                <div class="profile-stats profile-desktop-stats">
                    <div class="stat"><b>{{ count($user->posts) }}</b> <span>پست</span></div>
                    <div class="stat"><b>100</b> <span>دنبال‌کننده</span></div>
                    <div class="stat"><b>5,000</b> <span>دنبال‌شونده</span></div>
                </div>

                <div class="profile-bio">
                    <span class="bio-name">{{ $user->username }}</span>
                    <span>دانشجوی دانشگاه • پلتفرم اشتراک‌گذاری اجتماعی Unista</span>
                </div>
            </div>

        </header>

        {{-- Profile Tabs --}}
        <div class="profile-tabs">
            <div class="profile-tab active">
                <span class="fe fe-grid"></span>
                <span>پست‌ها</span>
            </div>
        </div>

        {{-- Posts grid --}}
        @if(count($user->posts) > 0)
            <div class="posts-grid">
                @foreach($user->posts as $post)
                    <a href="#">
                        @if($post->media && !empty($post->media->name))
                            <img src="{{ asset("storage/posts/" . $post->media->name) }}" alt="Post">
                        @else
                            <img src="{{ asset('img/profile.jpg') }}" alt="Post">
                        @endif
                        <div class="grid-overlay">
                            <span>❤️ ۱۲</span>
                            <span>💬 ۲</span>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="empty-posts">
                <span class="fe fe-image"></span>
                <p class="mt-3 mb-0">هنوز پستی منتشر نشده است.</p>
            </div>
        @endif

    </div>

@endsection

@section('js')

@endsection
