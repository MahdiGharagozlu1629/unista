@extends('client.layout')

@section('main')
<div class="search-page">

    {{-- Search Bar Header --}}
    <div class="search-header-wrap">
        <form action="{{ route('search') }}" method="GET" class="search-bar-form" id="searchForm">
            <div class="search-bar-inner">
                <span class="fe fe-search search-icon"></span>
                <input
                    type="text"
                    name="q"
                    id="searchInput"
                    class="search-input"
                    value="{{ $query ?? '' }}"
                    placeholder="جستجوی نام کاربری، دانشجو یا موضوع..."
                    autocomplete="off"
                    aria-label="جستجو"
                >
                <button type="button" class="search-clear-btn" id="searchClearBtn" title="پاک کردن جستجو" style="{{ !empty($query) ? 'display: flex;' : '' }}">
                    <span class="fe fe-x"></span>
                </button>
                <div class="search-spinner" id="searchSpinner"></div>
            </div>
        </form>
    </div>

    {{-- Category Filter Tabs --}}
    <div class="search-tabs" id="searchTabs">
        <button type="button" class="search-tab active" data-tab="all">
            همه
        </button>
        <button type="button" class="search-tab" data-tab="users" id="usersTabBtn">
            حساب‌ها (<span id="usersCountBadge">{{ count($users) }}</span>)
        </button>
        <button type="button" class="search-tab" data-tab="posts" id="postsTabBtn">
            پست‌ها و اکسپلور (<span id="postsCountBadge">{{ count($posts) }}</span>)
        </button>
    </div>

    {{-- Search Results / Explore Container --}}
    <div id="searchResultsContainer">

        {{-- 1. Accounts Section --}}
        <section class="search-section" id="searchUsersSection" style="{{ count($users) == 0 ? 'display: none;' : '' }}">
            <div class="search-section-header">
                <h2 class="search-section-title">
                    <span class="fe fe-users"></span>
                    <span id="usersSectionTitle">{{ !empty($query) ? 'حساب‌های کاربری یافت شده' : 'پیشنهادها برای شما' }}</span>
                </h2>
                <span class="search-section-badge" id="usersSectionBadge">{{ count($users) }} حساب</span>
            </div>

            <div class="search-users-card">
                <div class="search-users-list" id="usersList">
                    @forelse($users as $user)
                        <a href="{{ route('users.show', ['id' => $user->id]) }}" class="search-user-item">
                            <div class="search-user-left">
                                <img src="{{ asset('img/profile.jpg') }}" alt="{{ $user->username }}" class="search-user-avatar">
                                <div class="search-user-meta">
                                    <span class="search-user-username">{{ $user->username }}</span>
                                    <span class="search-user-fullname">{{ $user->name }} {{ $user->family }}</span>
                                </div>
                            </div>
                            <span class="search-user-btn">مشاهده</span>
                        </a>
                    @empty
                    @endforelse
                </div>
            </div>
        </section>

        {{-- 2. Explore / Posts Grid Section --}}
        <section class="search-section" id="searchPostsSection" style="{{ count($posts) == 0 ? 'display: none;' : '' }}">
            <div class="search-section-header">
                <h2 class="search-section-title">
                    <span class="fe fe-grid"></span>
                    <span id="postsSectionTitle">{{ !empty($query) ? 'پست‌های مرتبط' : 'اکسپلور دانشجویی' }}</span>
                </h2>
                <span class="search-section-badge" id="postsSectionBadge">{{ count($posts) }} پست</span>
            </div>

            <div class="explore-grid" id="postsGrid">
                @forelse($posts as $post)
                    <a href="{{ isset($post->user) ? route('users.show', ['id' => $post->user->id]) : '#' }}" class="explore-card">
                        @if($post->media_item && !empty($post->media_item->name))
                            <img src="{{ asset('storage/posts/' . $post->media_item->name) }}" alt="Post by {{ $post->user->username ?? '' }}" loading="lazy">
                        @else
                            <img src="{{ asset('img/profile.jpg') }}" alt="Post" loading="lazy">
                        @endif

                        @if(isset($post->media_count) && $post->media_count > 1)
                            <span class="explore-badge" title="چندرسانه‌ای">
                                <span class="fe fe-copy"></span>
                            </span>
                        @endif

                        <div class="explore-overlay">
                            <span class="explore-overlay-item">
                                <span class="fe fe-heart"></span> ۱۲
                            </span>
                            <span class="explore-overlay-item">
                                <span class="fe fe-message-circle"></span> ۲
                            </span>
                        </div>
                    </a>
                @empty
                @endforelse
            </div>
        </section>

        {{-- 3. Empty State --}}
        <div class="search-empty" id="searchEmptyState" style="{{ count($users) == 0 && count($posts) == 0 ? 'display: block;' : 'display: none;' }}">
            <div class="search-empty-icon">
                <span class="fe fe-search"></span>
            </div>
            <div class="search-empty-title" id="emptyTitle">
                @if(!empty($query))
                    نتیجه‌ای برای «{{ $query }}» یافت نشد
                @else
                    موردی برای نمایش یافت نشد
                @endif
            </div>
            <p class="search-empty-desc">
                از املای صحیح نام کاربری، نام دانشجو یا کلمات کلیدی اطمینان حاصل کنید و دوباره جستجو نمایید.
            </p>
        </div>

    </div>

</div>
@endsection
