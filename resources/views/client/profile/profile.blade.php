@extends('client.layout')
@section('main')



    <div class="ig-profile">

        {{-- Profile Header --}}
        <header class="profile-header">

            {{-- Mobile Layout (< 768px) --}}
            <div class="d-md-none">
                <div class="profile-top-mobile">
                    <div class="avatar-wrap">
                        @if(!empty($hasActiveStory) && $hasActiveStory)
                            <a href="{{ route('story.show', ['userId' => $user->id]) }}" class="story-ring has-story d-inline-block" style="width: 82px; height: 82px; padding: 2.5px;" title="مشاهده استوری">
                                <img class="profile-avatar" src="{{ asset('img/profile.jpg') }}" alt="{{ $user->username }}" style="width: 100%; height: 100%;">
                            </a>
                        @else
                            <img class="profile-avatar" src="{{ asset('img/profile.jpg') }}" alt="{{ $user->username }}">
                        @endif
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
                    <a href="{{ route('follow.requests') }}" class="ig-btn ig-btn-dark">
                        <i class="fe fe-bell"></i>
                        درخواست‌ها
                    </a>
                    <a href="#" class="ig-btn ig-btn-dark">
                        <i class="fe fe-edit-2"></i>
                        ویرایش پروفایل
                    </a>
                    <a href="{{route("saved.posts")}}" class="ig-btn ig-btn-dark">
                        <i class="fe fe-bookmark"></i>
                        پست های ذخیره شده
                    </a>
                </div>
            </div>

            {{-- Desktop Layout (>= 768px) --}}
            <div class="avatar-wrap d-none d-md-flex">
                @if(!empty($hasActiveStory) && $hasActiveStory)
                    <a href="{{ route('story.show', ['userId' => $user->id]) }}" class="story-ring has-story d-inline-block" style="width: 148px; height: 148px; padding: 3.5px;" title="مشاهده استوری">
                        <img class="profile-avatar" src="{{ asset('img/profile.jpg') }}" alt="{{ $user->username }}" style="width: 100%; height: 100%;">
                    </a>
                @else
                    <img class="profile-avatar" src="{{ asset('img/profile.jpg') }}" alt="{{ $user->username }}">
                @endif
            </div>

            <div class="profile-info d-none d-md-flex">
                <div class="profile-title-row">
                    <h1 class="profile-username">{{ $user->username }}</h1>
                    <div class="profile-actions-inline profile-desktop-actions">
                        <a href="{{ route('follow.requests') }}" class="ig-btn ig-btn-dark">
                            <i class="fe fe-bell"></i>
                            درخواست‌ها
                        </a>
                        <a href="#" class="ig-btn ig-btn-dark">
                            <i class="fe fe-edit-2"></i>
                            ویرایش پروفایل
                        </a>
                        <a href="{{route("saved.posts")}}" class="ig-btn ig-btn-dark">
                            <i class="fe fe-bookmark"></i>
                            پست های ذخیره شده
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
                    <span>دانشجوی فعال دانشگاه • پلتفرم اشتراک‌گذاری اجتماعی Unista</span>
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
                <p class="mt-3 mb-0">هنوز پستی منتشر نکرده‌اید.</p>
            </div>
        @endif

    </div>

@endsection

@section('js')

@endsection
