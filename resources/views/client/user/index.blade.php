@extends('client.layout')
@section('main')



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
