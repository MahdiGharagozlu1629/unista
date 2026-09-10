@extends('client.layout')
@section('main')

    <div class="ig-profile">

        <div class="profile-tabs">
            <div class="profile-tab active">
                <span class="fe fe-grid"></span>
                <span>پست‌ها</span>
            </div>
        </div>

    <div class="posts-grid">
        @foreach($posts as $post)
            <a href="{{route("post.comments" , ["postId" => $post->id])}}">
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
    </div>
@endsection
