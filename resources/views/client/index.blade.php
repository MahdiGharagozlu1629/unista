@extends('client.layout')
@section('main')

    <style>
        /* ===================== Instagram-style UI ===================== */

        /* ----- Story / highlights bar (IG gradient rings) ----- */
        .story-bar {
            display: flex;
            gap: 1.1rem;
            overflow-x: auto;
            padding: .4rem .2rem 1.2rem;
            scrollbar-width: thin;
        }

        .story {
            flex: 0 0 auto;
            text-align: center;
            cursor: pointer;
        }

        .story-ring {
            width: 66px;
            height: 66px;
            border-radius: 50%;
            padding: 3px;
            /* Classic Instagram gradient */
            background: radial-gradient(circle at 30% 107%,
                #fdf497 0%, #fdf497 5%, #fd5949 45%, #d6249f 60%, #285aeb 90%);
            transition: transform .25s ease;
        }

        .story-ring img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #08181c;
            display: block;
        }

        .story:hover .story-ring {
            transform: scale(1.06);
        }

        .story-name {
            margin-top: .45rem;
            font-size: 12px;
            color: #a8a8a8;
            max-width: 66px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* ----- Centered single-column feed ----- */
        .feed {
            max-width: 600px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 1.6rem;
        }

        .post-card {
            background: #000;
            border: 1px solid #262626;
            border-radius: 10px;
            overflow: hidden;
        }

        .post-head {
            display: flex;
            align-items: center;
            gap: .7rem;
            padding: .8rem 1rem;
        }

        .post-head .avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid #262626;
        }

        .post-head .username {
            font-weight: 600;
            color: #fafafa;
            font-size: 14px;
        }

        .post-head .username:hover {
            color: #fff;
            text-decoration: none;
        }

        .post-head .more {
            margin-inline-start: auto;
            color: #fafafa;
            font-size: 22px;
            line-height: 1;
            cursor: pointer;
            padding: 0 .2rem;
        }

        .post-media {
            background: #000;
            border-top: 1px solid #262626;
            border-bottom: 1px solid #262626;
        }

        .post-media .lightSlider {
            background: #000;
        }

        .post-media .lSSlideOuter .lightSlider,
        .post-media .lSSlideOuter {
            border-radius: 0;
        }

        .post-media img {
            width: 100%;
            aspect-ratio: 1 / 1;
            object-fit: cover;
            display: block;
        }

        .post-actions {
            display: flex;
            align-items: center;
            gap: 1.1rem;
            padding: .7rem 1rem .2rem;
        }

        .act {
            font-size: 24px;
            cursor: pointer;
            transition: transform .2s ease, opacity .2s ease;
            line-height: 1;
            user-select: none;
        }

        .act:hover {
            opacity: .65;
        }

        .act.liked {
            animation: ig-pop .35s ease;
        }

        @keyframes ig-pop {
            0% { transform: scale(1); }
            45% { transform: scale(1.3); }
            100% { transform: scale(1); }
        }

        .act.save {
            margin-inline-start: auto;
        }

        .post-likes {
            padding: .2rem 1rem 0;
            color: #fafafa;
            font-weight: 600;
            font-size: 14px;
        }

        .post-caption {
            padding: .4rem 1rem 1.1rem;
            color: #ededed;
            font-size: 14px;
            line-height: 1.5;
            word-break: break-word;
        }

        .post-caption .username-inline {
            font-weight: 600;
            color: #fafafa;
            margin-inline-end: .4rem;
        }

        .empty-feed {
            text-align: center;
            padding: 4rem 1rem;
            color: #a8a8a8;
        }

        .empty-feed .fe {
            font-size: 2.6rem;
            color: #d6249f;
            opacity: .8;
        }
    </style>

    {{-- Story / highlights bar --}}
    <div class="story-bar">
        <div class="story">
            <div class="story-ring">
                <img src="{{ asset('img/profile.jpg') }}" alt="">
            </div>
            <div class="story-name">شما</div>
        </div>
        @foreach($posts as $post)
            <div class="story">
                <div class="story-ring">
                    <img src="{{ asset('img/profile.jpg') }}" alt="">
                </div>
                <div class="story-name">{{ $post->user->username }}</div>
            </div>
        @endforeach
    </div>

    {{-- Feed --}}
    <div class="feed">
        @forelse($posts as $post)
            <div class="post-card">
                <div class="post-head">
                    <img class="avatar" src="{{ asset('img/profile.jpg') }}" alt="">
                    <a href="{{ route('users.show', ['id' => $post->user->id]) }}" class="username">
                        {{ $post->user->username }}
                    </a>
                    <span class="more">⋮</span>
                </div>

                <div class="post-media">
                    <ul class="lightSlider">
                        @foreach($post->media as $media)
                            <li>
                                <img src="{{ asset("storage/posts/$media->name") }}" alt="">
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="post-actions">
                    <span class="act like-btn">🤍</span>
                    <a href="#" class="act comment-btn">💬</a>
                    <span class="act share-btn">📨</span>
                    <span class="act save save-btn">🔖</span>
                </div>

                <div class="post-likes">{{ count($post->media) > 0 ? '۱٬۲۳۴' : '۰' }} لایک</div>

                <div class="post-caption">
                    <span class="username-inline">{{ $post->user->username }}</span>
                    {{ $post->content }}
                </div>
            </div>
        @empty
            <div class="empty-feed">
                <span class="fe fe-inbox"></span>
                <p class="mt-3 mb-0">هنوز پستی منتشر نشده است.</p>
            </div>
        @endforelse
    </div>

@endsection

@section('js')
    <script>
        // Slider
        $(document).ready(function () {
            $(".lightSlider").lightSlider({
                item: 1,
                autoWidth: false,
                slideMove: 1,
                slideMargin: 0,
                mode: "slide",
                useCSS: true,
                cssEasing: 'ease',
                easing: 'linear',
                speed: 400,
                auto: false,
                loop: false,
                slideEndAnimation: true,
                pause: 2000,
                keyPress: false,
                controls: true,
                prevHtml: '',
                nextHtml: '',
                rtl: true,
                adaptiveHeight: false,
                vertical: false,
                thumbItem: 10,
                pager: true,
                gallery: false,
                enableTouch: true,
                enableDrag: true,
                freeMove: true,
                swipeThreshold: 40
            });
        });

        // Like / unlike toggle
        $(document).ready(function () {
            $("body").on("click", ".like-btn", function () {
                var $btn = $(this);
                if ($btn.hasClass("is-liked")) {
                    $btn.removeClass("is-liked").text("🤍");
                } else {
                    $btn.addClass("is-liked liked").text("❤️");
                    setTimeout(function () { $btn.removeClass("liked"); }, 350);
                }
            });
        });
    </script>
@endsection
