@extends('client.layout')
@section('main')



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
