@extends('client.layout')

@section('main')

    <div class="comments-container">

        {{-- Top Navigation Bar --}}
        <div class="comments-top-bar">
            <a href="{{ route('index') }}" class="comments-back-link">
                <span class="fe fe-arrow-right"></span>
                <span>بازگشت به خانه</span>
            </a>
            <span class="font-weight-bold text-white">نظرات</span>
            <span style="width: 24px;"></span>
        </div>

        {{-- Post Article --}}
        <article class="post-card">
            <div class="post-head">
                <img class="avatar" src="{{ asset('img/profile.jpg') }}" alt="{{ $post->user->username }}">
                <a href="{{ route('users.show', ['id' => $post->user->id]) }}" class="username">
                    {{ $post->user->username }}
                </a>
                <button type="button" class="more" title="گزینه‌ها">
                    <svg aria-label="گزینه‌ها" fill="currentColor" height="20" role="img" viewBox="0 0 24 24" width="20">
                        <circle cx="12" cy="12" r="2"></circle>
                        <circle cx="6" cy="12" r="2"></circle>
                        <circle cx="18" cy="12" r="2"></circle>
                    </svg>
                </button>
            </div>

            {{-- Post Media --}}
            @if(count($post->media) > 0)
                <div class="post-media">
                    <ul class="lightSlider">
                        @foreach($post->media as $media)
                            <li>
                                <img src="{{ asset("storage/posts/$media->name") }}" alt="Post media">
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Post Actions --}}
            <div class="post-actions">
                <button type="button" class="act like-btn {{ !empty($post->liked) && $post->liked ? 'is-liked' : '' }}" data-post-id="{{ $post->id }}" title="{{ !empty($post->liked) && $post->liked ? 'نپسندیدن' : 'پسندیدن' }}">
                    <svg class="post-icon icon-heart" aria-label="پسندیدن" fill="none" height="24" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" width="24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                    </svg>
                    <svg class="post-icon icon-heart-filled" aria-label="نپسندیدن" fill="#ed4956" height="24" stroke="#ed4956" stroke-width="0" viewBox="0 0 24 24" width="24">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"></path>
                    </svg>
                </button>

                <button type="button" class="act comment-btn" title="نظرات">
                    <svg class="post-icon icon-comment" aria-label="نظر" fill="none" height="24" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" width="24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
                    </svg>
                </button>

                <button type="button" class="act share-btn" title="ارسال">
                    <svg class="post-icon icon-share" aria-label="ارسال" fill="none" height="24" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" width="24">
                        <line x1="22" y1="2" x2="11" y2="13"></line>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                    </svg>
                </button>

                <button type="button" class="act save save-btn {{ !empty($post->saved) && $post->saved ? 'is-saved' : '' }}" data-post-id="{{ $post->id }}" title="{{ !empty($post->saved) && $post->saved ? 'حذف از ذخیره‌ها' : 'ذخیره' }}">
                    <svg class="post-icon icon-save" aria-label="ذخیره" fill="none" height="24" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" width="24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                    </svg>
                    <svg class="post-icon icon-save-filled" aria-label="حذف از ذخیره‌ها" fill="currentColor" height="24" stroke="currentColor" stroke-width="0" viewBox="0 0 24 24" width="24">
                        <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                    </svg>
                </button>
            </div>

            <div class="post-likes">
                <span class="post-likes-count" data-count="{{ $post->likes ? $post->likes->count() : 0 }}">
                    {{ $post->likes && $post->likes->count() > 0 ? number_format($post->likes->count()) : '۰' }}
                </span>
                پسند
            </div>

            {{-- Post Caption --}}
            <div class="post-caption border-bottom pb-3">
                <span class="username-inline">{{ $post->user->username }}</span>
                {{ $post->content }}
                <div class="mt-1 text-muted" style="font-size: 11.5px;">
                    {{ $post->created_at ? $post->created_at->diffForHumans() : 'چند لحظه پیش' }}
                </div>
            </div>

            {{-- Comments Section --}}
            <div class="comments-list-section">
                <div class="comments-header-title">
                    <span>
                        <i class="fe fe-message-circle mr-1"></i>
                        نظرات کاربران
                    </span>
                    <span class="comments-count-badge" id="commentsCountBadge">
                        {{ count($post->comments) }} نظر
                    </span>
                </div>

                {{-- Comments List --}}
                <div class="comments-list" id="commentsList">
                    @forelse($post->comments as $comment)
                        <div class="comment-item" id="comment-{{ $comment->id }}">
                            <img src="{{ asset('img/profile.jpg') }}" alt="{{ $comment->user->username }}" class="comment-avatar">
                            <div class="comment-body">
                                <div class="comment-content">
                                    <a href="{{ route('users.show', ['id' => $comment->user->id]) }}" class="comment-username">
                                        {{ $comment->user->username }}
                                    </a>
                                    {{ $comment->text }}
                                </div>
                                <div class="comment-meta">
                                    <span>{{ $comment->created_at ? $comment->created_at->diffForHumans() : 'چند لحظه پیش' }}</span>
                                    @if(auth()->id() == $comment->user_id || auth()->id() == $post->user_id)
                                        <button type="button" class="comment-delete-btn" data-url="{{ route('comment.destroy', ['id' => $comment->id]) }}">
                                            حذف
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="comments-empty" id="commentsEmpty">
                            <div class="comments-empty-icon">
                                <span class="fe fe-message-circle"></span>
                            </div>
                            <div class="comments-empty-title">هنوز نظری ثبت نشده است</div>
                            <div class="comments-empty-desc">اولین نفری باشید که برای این پست دیدگاه خود را می‌نویسد.</div>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Add Comment Form --}}
            @if($post->have_comment)
                <div class="comment-form-wrap">
                    <form action="{{ route('comment.store', ['postId' => $post->id]) }}" method="post" class="comment-form" id="commentForm">
                        @csrf
                        <img src="{{ asset('img/profile.jpg') }}" alt="شما" class="comment-form-avatar">
                        <div class="comment-input-wrap">
                            <input
                                type="text"
                                name="text"
                                id="commentInput"
                                class="comment-input"
                                placeholder="افزودن نظر به عنوان {{ auth()->user()->username }}..."
                                autocomplete="off"
                                required
                            >
                        </div>
                        <button type="submit" class="comment-submit-btn" id="commentSubmitBtn" disabled>
                            ارسال
                        </button>
                    </form>
                </div>
            @else
                <div class="comments-disabled-banner">
                    <span class="fe fe-lock mr-1"></span>
                    امکان ثبت نظر برای این پست غیرفعال است.
                </div>
            @endif

        </article>
    </div>

@endsection

@section('js')
    <script>
        // Media Slider
        $(document).ready(function () {
            if ($(".lightSlider").length) {
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
                    rtl: true,
                    pager: true,
                    controls: true,
                    prevHtml: '',
                    nextHtml: '',
                    enableTouch: true,
                    enableDrag: true,
                    freeMove: true,
                    swipeThreshold: 40
                });
            }

            // Like / Dislike Toggle & AJAX
            $("body").on("click", ".like-btn", function (e) {
                e.preventDefault();
                var $btn = $(this);
                var postId = $btn.data("post-id");
                if (!postId) return;

                var isLiked = $btn.hasClass("is-liked");
                var url = isLiked ? '{{ route("dislike.post") }}' : '{{ route("like.post") }}';
                var method = isLiked ? 'DELETE' : 'POST';

                // Optimistic UI update
                if (isLiked) {
                    $btn.removeClass("is-liked liked");
                    $btn.attr("title", "پسندیدن");
                } else {
                    $btn.addClass("is-liked liked");
                    $btn.attr("title", "نپسندیدن");
                    setTimeout(function () { $btn.removeClass("liked"); }, 350);
                }

                // Update like count display
                var $card = $btn.closest(".post-card");
                var $likesCountEl = $card.find(".post-likes-count");
                var currentCount = 0;
                if ($likesCountEl.length) {
                    currentCount = parseInt($likesCountEl.data("count")) || 0;
                    var newCount = isLiked ? Math.max(0, currentCount - 1) : currentCount + 1;
                    $likesCountEl.data("count", newCount).text(newCount > 0 ? newCount.toLocaleString('fa-IR') : '۰');
                }

                $.ajax({
                    url: url,
                    type: method,
                    data: {
                        'post_id': postId,
                        '_token': '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    error: function () {
                        // Revert on error
                        $btn.toggleClass("is-liked");
                        if ($likesCountEl.length) {
                            $likesCountEl.data("count", currentCount).text(currentCount > 0 ? currentCount.toLocaleString('fa-IR') : '۰');
                        }
                    }
                });
            });

            // Save / Unsave Toggle & AJAX
            $("body").on("click", ".save-btn", function (e) {
                e.preventDefault();
                var $btn = $(this);
                var postId = $btn.data("post-id");
                if (!postId) return;

                var isSaved = $btn.hasClass("is-saved");
                var url = isSaved ? '{{ route("remove.save") }}' : '{{ route("save.post") }}';
                var method = isSaved ? 'DELETE' : 'POST';

                // Optimistic UI update
                if (isSaved) {
                    $btn.removeClass("is-saved saved");
                    $btn.attr("title", "ذخیره");
                } else {
                    $btn.addClass("is-saved saved");
                    $btn.attr("title", "حذف از ذخیره‌ها");
                    setTimeout(function () { $btn.removeClass("saved"); }, 350);
                }

                $.ajax({
                    url: url,
                    type: method,
                    data: {
                        'post_id': postId,
                        '_token': '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    error: function () {
                        // Revert on error
                        $btn.toggleClass("is-saved");
                    }
                });
            });

            // Double click / tap on post media to like
            $("body").on("dblclick", ".post-media", function () {
                var $card = $(this).closest(".post-card");
                var $likeBtn = $card.find(".like-btn");
                if (!$likeBtn.hasClass("is-liked")) {
                    $likeBtn.trigger("click");
                } else {
                    $likeBtn.addClass("liked");
                    setTimeout(function () { $likeBtn.removeClass("liked"); }, 350);
                }
            });

            // Comment Input Enable/Disable Submit Button
            const $commentInput = $("#commentInput");
            const $commentSubmitBtn = $("#commentSubmitBtn");

            $commentInput.on("input", function () {
                if ($(this).val().trim().length > 0) {
                    $commentSubmitBtn.prop("disabled", false);
                } else {
                    $commentSubmitBtn.prop("disabled", true);
                }
            });

            // Delete Comment with Confirmation
            $("body").on("click", ".comment-delete-btn", function (e) {
                e.stopPropagation();
                if (!confirm("آیا از حذف این دیدگاه اطمینان دارید؟")) return;

                var $btn = $(this);
                var deleteUrl = $btn.data("url");
                var $commentItem = $btn.closest(".comment-item");

                $.ajax({
                    url: deleteUrl,
                    method: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') || '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    success: function (res) {
                        if (res.success) {
                            $commentItem.fadeOut(250, function () {
                                $(this).remove();
                                updateCommentsCount(-1);
                            });
                        } else {
                            alert(res.message || "خطا در حذف نظر");
                        }
                    },
                    error: function () {
                        alert("خطا در برقراری ارتباط با سرور");
                    }
                });
            });

            function updateCommentsCount(delta) {
                var currentCount = parseInt($("#commentsCountBadge").text()) || 0;
                var newCount = Math.max(0, currentCount + delta);
                $("#commentsCountBadge").text(newCount + " نظر");

                if (newCount === 0 && $("#commentsList").children().length === 0) {
                    $("#commentsList").html(`
                        <div class="comments-empty" id="commentsEmpty">
                            <div class="comments-empty-icon">
                                <span class="fe fe-message-circle"></span>
                            </div>
                            <div class="comments-empty-title">هنوز نظری ثبت نشده است</div>
                            <div class="comments-empty-desc">اولین نفری باشید که برای این پست دیدگاه خود را می‌نویسد.</div>
                        </div>
                    `);
                }
            }

            function escapeHtml(str) {
                if (!str) return '';
                var div = document.createElement('div');
                div.textContent = str;
                return div.innerHTML;
            }
        });
    </script>
@endsection
