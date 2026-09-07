@extends('client.layout')
@section('main')



    <div class="feed-container">
        {{-- Story / highlights bar --}}
        <div class="story-bar-card">
            <div class="story-bar">
                {{-- Current User Story --}}
                <div class="story my-story" data-user-id="{{ auth()->id() }}" @if(!empty($myStories) && $myStories->isNotEmpty()) onclick="openStoryViewer({{ auth()->id() }})" @endif>
                    <div class="story-ring position-relative {{ (!empty($myStories) && $myStories->isNotEmpty()) ? 'has-story' : 'no-story' }}" title="{{ (!empty($myStories) && $myStories->isNotEmpty()) ? 'مشاهده استوری شما' : 'افزودن استوری' }}">
                        <img src="{{ asset('img/profile.jpg') }}" alt="استوری شما">
                        <a href="{{ route('add.story') }}" class="add-story" title="افزودن استوری" onclick="event.stopPropagation();">
                            <span class="fe fe-plus"></span>
                        </a>
                    </div>
                    <div class="story-name">استوری شما</div>
                </div>

                {{-- Other Users Stories --}}
                @if(!empty($groupedStories))
                    @foreach($groupedStories as $storyUserId => $stories)
                        @php
                            $storyUser = $stories->first()->user ?? null;
                        @endphp
                        @if($storyUser)
                            <div class="story user-story" data-user-id="{{ $storyUser->id }}" onclick="openStoryViewer({{ $storyUser->id }})" title="استوری {{ $storyUser->username }}">
                                <div class="story-ring has-story">
                                    <img src="{{ asset('img/profile.jpg') }}" alt="{{ $storyUser->username }}">
                                </div>
                                <div class="story-name">{{ $storyUser->username }}</div>
                            </div>
                        @endif
                    @endforeach
                @endif
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
                        <button type="button" class="more" title="گزینه‌ها">
                            <svg aria-label="گزینه‌ها" fill="currentColor" height="20" role="img" viewBox="0 0 24 24" width="20">
                                <circle cx="12" cy="12" r="2"></circle>
                                <circle cx="6" cy="12" r="2"></circle>
                                <circle cx="18" cy="12" r="2"></circle>
                            </svg>
                        </button>
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
                        <button type="button" class="act like-btn" title="پسندیدن">
                            <svg class="post-icon icon-heart" aria-label="پسندیدن" fill="none" height="24" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" width="24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                            </svg>
                            <svg class="post-icon icon-heart-filled" aria-label="نپسندیدن" fill="#ed4956" height="24" stroke="#ed4956" stroke-width="0" viewBox="0 0 24 24" width="24" style="display: none;">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"></path>
                            </svg>
                        </button>

                        @if($post->have_comment)
                            <a href="{{ route('post.comments', ['postId' => $post->id]) }}" class="act comment-btn" title="نظر">
                                <svg class="post-icon icon-comment" aria-label="نظر" fill="none" height="24" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" width="24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
                                </svg>
                            </a>
                        @endif

                        <button type="button" class="act save save-btn" title="ذخیره">
                            <svg class="post-icon icon-save" aria-label="ذخیره" fill="none" height="24" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" width="24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                            </svg>
                            <svg class="post-icon icon-save-filled" aria-label="حذف از ذخیره‌ها" fill="currentColor" height="24" stroke="currentColor" stroke-width="0" viewBox="0 0 24 24" width="24" style="display: none;">
                                <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="post-likes">{{ count($post->media) > 0 ? '۱٬۲۳۴' : '۰' }} پسند</div>

                    <div class="post-caption">
                        <span class="username-inline">{{ $post->user->username }}</span>
                        {{ $post->content }}
                    </div>

                    @if($post->have_comment)
                        <div class="px-3 pb-3">
                            <a href="{{ route('post.comments', ['postId' => $post->id]) }}" class="text-muted" style="font-size: 13px; text-decoration: none; font-weight: 500;">
                                @if(isset($post->comments) && count($post->comments) > 0)
                                    مشاهده همه {{ count($post->comments) }} نظر
                                @else
                                    افزودن نظر...
                                @endif
                            </a>
                        </div>
                    @endif
                </article>
            @empty
                <div class="empty-feed">
                    <span class="fe fe-inbox"></span>
                    <p class="mt-3 mb-0">هنوز پستی منتشر نشده است.</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Instagram Story Viewer Modal --}}
    <div class="story-viewer-modal" id="storyViewerModal" role="dialog" aria-hidden="true">
        <div class="story-viewer-inner">

            <!-- Desktop Nav Prev / Next (RTL: right=prev, left=next) -->
            <button type="button" class="story-nav-btn prev-btn" id="storyNavPrev" title="استوری قبلی">
                <span class="fe fe-chevron-right"></span>
            </button>
            <button type="button" class="story-nav-btn next-btn" id="storyNavNext" title="استوری بعدی">
                <span class="fe fe-chevron-left"></span>
            </button>

            <!-- Main Story Card -->
            <div class="story-viewer-card" id="storyViewerCard">

                <!-- Progress Segments -->
                <div class="story-progress-wrap" id="storyProgressWrap"></div>

                <!-- Story Header -->
                <div class="story-header">
                    <div class="story-user-meta">
                        <img src="{{ asset('img/profile.jpg') }}" alt="" class="story-user-avatar" id="storyUserAvatar">
                        <a href="#" class="story-user-name" id="storyUserName">کاربر</a>
                        <span class="story-time-ago" id="storyTimeAgo">همین الان</span>
                    </div>
                    <div class="story-header-actions">
                        <button type="button" class="story-action-btn" id="storyPauseBtn" title="توقف/پخش">
                            <span class="fe fe-pause" id="storyPauseIcon"></span>
                        </button>
                        <button type="button" class="story-action-btn" id="storyMuteBtn" title="صدا" style="display: none;">
                            <span class="fe fe-volume-2" id="storyMuteIcon"></span>
                        </button>
                        <button type="button" class="story-action-btn delete-btn" id="storyDeleteBtn" title="حذف این استوری" style="display: none;">
                            <span class="fe fe-trash-2"></span>
                        </button>
                        <button type="button" class="story-action-btn" id="storyCloseBtn" title="بستن (Esc)">
                            <span class="fe fe-x"></span>
                        </button>
                    </div>
                </div>

                <!-- Story Media Box -->
                <div class="story-media-box" id="storyMediaBox">
                    <img src="" alt="" class="story-media-content" id="storyImage" style="display: none;">
                    <video class="story-media-content" id="storyVideo" playsinline style="display: none;"></video>

                    <!-- Touch/Click Zones (Right=prev in RTL, Left=next in RTL) -->
                    <div class="story-touch-zone story-touch-prev" id="storyTouchPrev" title="استوری قبلی"></div>
                    <div class="story-touch-zone story-touch-next" id="storyTouchNext" title="استوری بعدی"></div>
                </div>

            </div>
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

        // Post Actions (Like, Save, Double click to like)
        $(document).ready(function () {
            // Like button toggle
            $("body").on("click", ".like-btn", function () {
                var $btn = $(this);
                $btn.toggleClass("is-liked");
                if ($btn.hasClass("is-liked")) {
                    $btn.addClass("liked");
                    setTimeout(function () { $btn.removeClass("liked"); }, 350);
                }
            });

            // Save / bookmark button toggle
            $("body").on("click", ".save-btn", function () {
                var $btn = $(this);
                $btn.toggleClass("is-saved");
            });

            // Double click / tap on post media to like
            $("body").on("dblclick", ".post-media", function () {
                var $card = $(this).closest(".post-card");
                var $likeBtn = $card.find(".like-btn");
                if (!$likeBtn.hasClass("is-liked")) {
                    $likeBtn.addClass("is-liked liked");
                    setTimeout(function () { $likeBtn.removeClass("liked"); }, 350);
                }
            });
        });

        // Instagram Story Viewer Controller
        (function () {
            const storyGroups = @json($storyGroups ?? []);
            const openStoryUserId = @json($openStoryUserId ?? null);

            let currentGroupIndex = 0;
            let currentStoryIndex = 0;
            let storyDuration = 5000; // 5 seconds for photos
            let startTime = 0;
            let elapsedTime = 0;
            let animFrameId = null;
            let isPaused = false;
            let isMuted = false;
            let isHolding = false;

            const modal = document.getElementById('storyViewerModal');
            const progressWrap = document.getElementById('storyProgressWrap');
            const userAvatar = document.getElementById('storyUserAvatar');
            const userName = document.getElementById('storyUserName');
            const timeAgo = document.getElementById('storyTimeAgo');
            const pauseBtn = document.getElementById('storyPauseBtn');
            const pauseIcon = document.getElementById('storyPauseIcon');
            const muteBtn = document.getElementById('storyMuteBtn');
            const muteIcon = document.getElementById('storyMuteIcon');
            const deleteBtn = document.getElementById('storyDeleteBtn');
            const closeBtn = document.getElementById('storyCloseBtn');
            const navPrevBtn = document.getElementById('storyNavPrev');
            const navNextBtn = document.getElementById('storyNavNext');
            const touchPrev = document.getElementById('storyTouchPrev');
            const touchNext = document.getElementById('storyTouchNext');
            const mediaBox = document.getElementById('storyMediaBox');
            const storyImg = document.getElementById('storyImage');
            const storyVid = document.getElementById('storyVideo');

            window.openStoryViewer = function (userId) {
                if (!storyGroups || storyGroups.length === 0) return;

                let groupIdx = storyGroups.findIndex(g => g.user_id == userId);
                if (groupIdx === -1) groupIdx = 0;

                currentGroupIndex = groupIdx;
                currentStoryIndex = 0;

                modal.classList.add('active');
                document.body.style.overflow = 'hidden';

                loadStory();
            };

            function closeStoryViewer() {
                clearStoryTimer();
                if (storyVid) {
                    storyVid.pause();
                    storyVid.src = '';
                }
                modal.classList.remove('active');
                document.body.style.overflow = '';
            }

            function loadStory() {
                clearStoryTimer();

                const group = storyGroups[currentGroupIndex];
                if (!group || !group.stories || group.stories.length === 0) {
                    closeStoryViewer();
                    return;
                }

                const story = group.stories[currentStoryIndex];
                if (!story) {
                    closeStoryViewer();
                    return;
                }

                // Setup User Info
                userAvatar.src = group.avatar;
                userName.textContent = group.username;
                userName.href = group.profile_url;
                timeAgo.textContent = story.created_at_human || 'چند لحظه پیش';

                // Delete button for owner only
                if (group.is_me && story.delete_url) {
                    deleteBtn.style.display = 'flex';
                } else {
                    deleteBtn.style.display = 'none';
                }

                // Render Progress Bars
                progressWrap.innerHTML = '';
                group.stories.forEach((s, idx) => {
                    const seg = document.createElement('div');
                    seg.className = 'story-progress-segment';
                    const fill = document.createElement('div');
                    fill.className = 'story-progress-fill';

                    if (idx < currentStoryIndex) {
                        fill.style.width = '100%';
                    } else {
                        fill.style.width = '0%';
                    }

                    seg.appendChild(fill);
                    progressWrap.appendChild(seg);
                });

                isPaused = false;
                elapsedTime = 0;
                updatePauseButton();

                // Media Loading
                if (story.is_video) {
                    storyImg.style.display = 'none';
                    storyVid.style.display = 'block';
                    muteBtn.style.display = 'flex';
                    storyVid.src = story.media_url;
                    storyVid.muted = isMuted;
                    storyVid.currentTime = 0;

                    const onMetadata = function () {
                        storyDuration = (storyVid.duration || 5) * 1000;
                        storyVid.play().catch(e => console.log(e));
                        startStoryTimer();
                        storyVid.removeEventListener('loadedmetadata', onMetadata);
                    };

                    if (storyVid.readyState >= 1) {
                        onMetadata();
                    } else {
                        storyVid.addEventListener('loadedmetadata', onMetadata);
                    }
                } else {
                    storyVid.style.display = 'none';
                    if (storyVid) storyVid.pause();
                    muteBtn.style.display = 'none';
                    storyImg.style.display = 'block';
                    storyImg.src = story.media_url;

                    storyDuration = 5000;
                    startStoryTimer();
                }
            }

            function startStoryTimer() {
                startTime = performance.now() - elapsedTime;

                function tick(now) {
                    if (isPaused) return;

                    elapsedTime = now - startTime;
                    const progress = Math.min(elapsedTime / storyDuration, 1);

                    const activeFill = progressWrap.children[currentStoryIndex]?.querySelector('.story-progress-fill');
                    if (activeFill) {
                        activeFill.style.width = (progress * 100) + '%';
                    }

                    if (progress >= 1) {
                        nextStory();
                    } else {
                        animFrameId = requestAnimationFrame(tick);
                    }
                }

                animFrameId = requestAnimationFrame(tick);
            }

            function clearStoryTimer() {
                if (animFrameId) {
                    cancelAnimationFrame(animFrameId);
                    animFrameId = null;
                }
            }

            function pauseStory() {
                if (isPaused) return;
                isPaused = true;
                clearStoryTimer();
                if (storyVid && storyVid.style.display === 'block') {
                    storyVid.pause();
                }
                updatePauseButton();
            }

            function resumeStory() {
                if (!isPaused) return;
                isPaused = false;
                if (storyVid && storyVid.style.display === 'block') {
                    storyVid.play().catch(e => console.log(e));
                }
                startStoryTimer();
                updatePauseButton();
            }

            function updatePauseButton() {
                if (isPaused) {
                    pauseIcon.className = 'fe fe-play';
                } else {
                    pauseIcon.className = 'fe fe-pause';
                }
            }

            function nextStory() {
                const group = storyGroups[currentGroupIndex];
                if (!group) return;

                if (currentStoryIndex < group.stories.length - 1) {
                    currentStoryIndex++;
                    loadStory();
                } else if (currentGroupIndex < storyGroups.length - 1) {
                    currentGroupIndex++;
                    currentStoryIndex = 0;
                    loadStory();
                } else {
                    closeStoryViewer();
                }
            }

            function prevStory() {
                if (currentStoryIndex > 0) {
                    currentStoryIndex--;
                    loadStory();
                } else if (currentGroupIndex > 0) {
                    currentGroupIndex--;
                    const prevGroup = storyGroups[currentGroupIndex];
                    currentStoryIndex = prevGroup.stories.length - 1;
                    loadStory();
                } else {
                    currentStoryIndex = 0;
                    loadStory();
                }
            }

            // Click / Touch Navigation
            touchPrev.addEventListener('click', function (e) {
                e.stopPropagation();
                prevStory();
            });

            touchNext.addEventListener('click', function (e) {
                e.stopPropagation();
                nextStory();
            });

            navPrevBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                prevStory();
            });

            navNextBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                nextStory();
            });

            // Hold to pause
            mediaBox.addEventListener('mousedown', function () {
                isHolding = true;
                pauseStory();
            });
            mediaBox.addEventListener('mouseup', function () {
                if (isHolding) {
                    isHolding = false;
                    resumeStory();
                }
            });
            mediaBox.addEventListener('mouseleave', function () {
                if (isHolding) {
                    isHolding = false;
                    resumeStory();
                }
            });
            mediaBox.addEventListener('touchstart', function () {
                isHolding = true;
                pauseStory();
            }, { passive: true });
            mediaBox.addEventListener('touchend', function () {
                if (isHolding) {
                    isHolding = false;
                    resumeStory();
                }
            });

            // Action buttons
            pauseBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                if (isPaused) resumeStory(); else pauseStory();
            });

            muteBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                isMuted = !isMuted;
                if (storyVid) storyVid.muted = isMuted;
                muteIcon.className = isMuted ? 'fe fe-volume-x' : 'fe fe-volume-2';
            });

            closeBtn.addEventListener('click', closeStoryViewer);

            modal.addEventListener('click', function (e) {
                if (e.target === modal || e.target.classList.contains('story-viewer-inner')) {
                    closeStoryViewer();
                }
            });

            deleteBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                if (!confirm('آیا از حذف این استوری اطمینان دارید؟')) return;

                const group = storyGroups[currentGroupIndex];
                const story = group.stories[currentStoryIndex];
                if (!story || !story.delete_url) return;

                pauseStory();

                const token = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';

                fetch(story.delete_url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        group.stories.splice(currentStoryIndex, 1);
                        if (group.stories.length === 0) {
                            storyGroups.splice(currentGroupIndex, 1);
                            closeStoryViewer();
                            window.location.reload();
                        } else {
                            if (currentStoryIndex >= group.stories.length) {
                                currentStoryIndex = group.stories.length - 1;
                            }
                            loadStory();
                        }
                    } else {
                        alert(data.message || 'خطا در حذف استوری');
                        resumeStory();
                    }
                })
                .catch(err => {
                    console.error(err);
                    resumeStory();
                });
            });

            // Keyboard navigation
            document.addEventListener('keydown', function (e) {
                if (!modal.classList.contains('active')) return;

                if (e.key === 'Escape') {
                    closeStoryViewer();
                } else if (e.key === 'ArrowLeft') {
                    nextStory();
                } else if (e.key === 'ArrowRight') {
                    prevStory();
                } else if (e.key === ' ') {
                    e.preventDefault();
                    if (isPaused) resumeStory(); else pauseStory();
                }
            });

            // Auto-open if query param open_story provided
            if (openStoryUserId) {
                window.openStoryViewer(openStoryUserId);
            }
        })();
    </script>
@endsection
