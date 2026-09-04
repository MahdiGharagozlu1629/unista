@extends('client.layout')
@section('main')

    <style>
        .ig-profile {
            max-width: 640px;
            margin: 0 auto;
        }

        .profile-top {
            display: flex;
            align-items: center;
            gap: 2rem;
            padding: 1.5rem 0 2rem;
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid #262626;
            flex: 0 0 auto;
        }

        .profile-meta {
            flex: 1 1 auto;
            min-width: 0;
        }

        .profile-username {
            color: #fafafa;
            font-size: 22px;
            font-weight: 400;
            margin-bottom: 1rem;
            line-height: 1;
        }

        .profile-stats {
            display: flex;
            gap: 2.5rem;
            color: #fafafa;
            font-size: 16px;
        }

        .profile-stats .stat {
            white-space: nowrap;
        }

        .profile-stats .stat b {
            font-weight: 600;
        }

        .profile-stats .stat span {
            color: #a8a8a8;
        }

        .profile-actions {
            display: flex;
            gap: .6rem;
            padding-bottom: 1.5rem;
        }

        .ig-btn {
            flex: 1 1 0;
            border-radius: 10px;
            padding: .55rem 1rem;
            font-size: 14px;
            font-weight: 700;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .4rem;
            transition: background .2s ease, transform .1s ease;
            cursor: pointer;
        }

        .ig-btn:active {
            transform: scale(.98);
        }

        .ig-btn-follow {
            background: #0095f6;
            color: #fff;
        }

        .ig-btn-follow:hover {
            background: #1aa3ff;
        }

        .ig-btn-unfollow {
            background: #262626;
            color: #fafafa;
        }

        .ig-btn-unfollow:hover {
            background: #363636;
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

        .profile-divider {
            border-top: 1px solid #262626;
            margin: 0 -1rem;
        }

        .posts-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 4px;
            margin-top: 1rem;
        }

        .posts-grid a {
            position: relative;
            aspect-ratio: 1 / 1;
            overflow: hidden;
            display: block;
        }

        .posts-grid img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .posts-grid a::after {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, .25);
            opacity: 0;
            transition: opacity .2s ease;
        }

        .posts-grid a:hover::after {
            opacity: 1;
        }

        .empty-posts {
            text-align: center;
            color: #a8a8a8;
            padding: 4rem 1rem;
        }

        .empty-posts .fe {
            font-size: 2.6rem;
            color: #d6249f;
            opacity: .8;
        }
    </style>

    <div class="ig-profile">

        {{-- Header --}}
        <div class="profile-top">
            <img class="profile-avatar" src="{{ asset('img/profile.jpg') }}" alt="">
            <div class="profile-meta">
                <div class="profile-username">{{ $user->username }}</div>
                <div class="profile-stats">
                    <div class="stat"><b>{{ count($user->posts) }}</b> <span>پست</span></div>
                    <div class="stat"><b>100</b> <span>دنبال کننده</span></div>
                    <div class="stat"><b>5000</b> <span>دنبال شونده</span></div>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="profile-actions">
            @if($hasFollowing)
                <form action="{{ route('unfollow') }}" method="post" class="m-0 w-100">
                    @csrf
                    <input type="hidden" name="following_id" value="{{ $user->id }}">
                    <button type="submit" class="ig-btn ig-btn-unfollow">
                        <i class="fe fe-user-minus"></i>
                        لغو دنبال کردن
                    </button>
                </form>
            @else
                <form action="{{ route('follow') }}" method="post" class="m-0 w-100">
                    @csrf
                    <input type="hidden" name="following_id" value="{{ $user->id }}">
                    <button type="submit" class="ig-btn ig-btn-follow">
                        <i class="fe fe-user-plus"></i>
                        دنبال کردن
                    </button>
                </form>
            @endif
            <a class="ig-btn ig-btn-message">
                <i class="fe fe-message-square"></i>
                پیام
            </a>
        </div>

        <div class="profile-divider"></div>

        {{-- Posts grid --}}
        @if(count($user->posts) > 0)
            <div class="posts-grid">
                @foreach($user->posts as $post)
                    <a href="#">
                        <img src="{{ asset("storage/posts/" . $post->media->name) }}" alt="">
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
