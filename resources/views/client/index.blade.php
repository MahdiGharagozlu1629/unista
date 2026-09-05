@extends('client.layout')
@section('main')

    <style>
        /* ===================== Instagram-style Feed UI ===================== */

        .feed-container {
            max-width: 630px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }

        /* ----- Story / Highlights Bar ----- */
        .story-bar-card {
            background: #000;
            border: 1px solid var(--ig-border, #262626);
            border-radius: 12px;
            padding: 1rem .8rem .8rem;
            margin-bottom: .5rem;
        }

        .story-bar {
            display: flex;
            gap: 1.2rem;
            overflow-x: auto;
            padding: 0 .2rem .4rem;
            scrollbar-width: none;
            -ms-overflow-style: none;
            -webkit-overflow-scrolling: touch;
        }

        .story-bar::-webkit-scrollbar {
            display: none;
        }

        .story {
            flex: 0 0 auto;
            text-align: center;
            cursor: pointer;
            width: 72px;
        }

        .story-ring {
            width: 66px;
            height: 66px;
            margin: 0 auto;
            border-radius: 50%;
            padding: 2.5px;
            /* Classic Instagram gradient */
            background: radial-gradient(circle at 30% 107%,
                #fdf497 0%, #fdf497 5%, #fd5949 45%, #d6249f 60%, #285aeb 90%);
            transition: transform .2s ease;
        }

        .story-ring img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #000;
            display: block;
        }

        .story:hover .story-ring {
            transform: scale(1.05);
        }

        .story-name {
            margin-top: .4rem;
            font-size: 12px;
            color: #a8a8a8;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* ----- Centered Single-Column Feed ----- */
        .feed {
            width: 100%;
            max-width: 480px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }

        .post-card {
            background: #000;
            border: 1px solid var(--ig-border, #262626);
            border-radius: 12px;
            overflow: hidden;
        }

        .post-head {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .75rem 1rem;
        }

        .post-head .avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid var(--ig-border, #262626);
            flex-shrink: 0;
        }

        .post-head .username {
            font-weight: 600;
            color: #fafafa;
            font-size: 14px;
            text-decoration: none;
        }

        .post-head .username:hover {
            color: #fff;
            text-decoration: none;
        }

        .post-head .more {
            margin-inline-start: auto;
            color: #fafafa;
            font-size: 20px;
            line-height: 1;
            cursor: pointer;
            padding: 4px;
            opacity: .8;
        }

        .post-head .more:hover {
            opacity: 1;
        }

        .post-media {
            background: #000;
            border-top: 1px solid var(--ig-border, #262626);
            border-bottom: 1px solid var(--ig-border, #262626);
            position: relative;
            width: 100%;
        }

        .post-media .lightSlider {
            background: #000;
            margin: 0;
            padding: 0;
        }

        .post-media .lSSlideOuter .lightSlider,
        .post-media .lSSlideOuter {
            border-radius: 0;
            margin-bottom: 0 !important;
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
            padding: .75rem 1rem .25rem;
        }

        .act {
            font-size: 22px;
            cursor: pointer;
            transition: transform .18s ease, opacity .18s ease;
            line-height: 1;
            user-select: none;
            display: inline-flex;
            align-items: center;
            color: #fafafa;
            text-decoration: none;
        }

        .act:hover {
            opacity: .65;
            color: #fff;
            text-decoration: none;
        }

        .act:active {
            transform: scale(.88);
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
            padding: .35rem 1rem 0;
            color: #fafafa;
            font-weight: 600;
            font-size: 13.5px;
        }

        .post-caption {
            padding: .4rem 1rem 1rem;
            color: #ededed;
            font-size: 13.5px;
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

        /* Mobile Adjustments (< 576px) -> Edge-to-edge */
        @media (max-width: 575.98px) {
            .feed-container {
                gap: .75rem;
            }

            .story-bar-card {
                border-radius: 0;
                border-left: none;
                border-right: none;
                border-top: none;
                padding: .6rem .2rem;
                margin-bottom: 0;
            }

            .story {
                width: 66px;
            }

            .story-ring {
                width: 60px;
                height: 60px;
            }

            .feed {
                max-width: 100%;
                gap: 1rem;
            }

            .post-card {
                border-radius: 0;
                border-left: none;
                border-right: none;
            }

            .post-head,
            .post-actions,
            .post-likes,
            .post-caption {
                padding-left: .85rem;
                padding-right: .85rem;
            }
        }
    </style>

    <div class="feed-container">
        {{-- Story / highlights bar --}}
        <div class="story-bar-card">
            <div class="story-bar">
                <div class="story">
                    <div class="story-ring">
                        <img src="{{ asset('img/profile.jpg') }}" alt="">
                    </div>
                    <div class="story-name">استوری شما</div>
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
        </div>

        {{-- Feed --}}
        <div class="feed">
            @forelse($posts as $post)
                <article class="post-card">
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
                        <span class="act like-btn" title="پسندیدن">🤍</span>
                        <a href="#" class="act comment-btn" title="نظر">💬</a>
                        <span class="act share-btn" title="ارسال">📨</span>
                        <span class="act save save-btn" title="ذخیره">🔖</span>
                    </div>

                    <div class="post-likes">{{ count($post->media) > 0 ? '۱٬۲۳۴' : '۰' }} پسند</div>

                    <div class="post-caption">
                        <span class="username-inline">{{ $post->user->username }}</span>
                        {{ $post->content }}
                    </div>
                </article>
            @empty
                <div class="empty-feed">
                    <span class="fe fe-inbox"></span>
                    <p class="mt-3 mb-0">هنوز پستی منتشر نشده است.</p>
                </div>
            @endforelse
        </div>
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
