@extends('client.layout')
@section('main')

    <div class="ig-profile">

        <div class="profile-tabs">
            <div class="profile-tab active">
                <span class="fe fe-grid"></span>
                <span>آرشیو استوری</span>
            </div>
        </div>

    <div class="posts-grid">
        @foreach($stories as $story)
            <a href="#">
                @if($story->media && !empty($story->name))
                    <img src="{{ asset("storage/story/" . $story->name) }}" alt="Post">
                @else
                    <img src="{{ asset('img/profile.jpg') }}" alt="Post">
                @endif
            </a>
        @endforeach
    </div>
    </div>
@endsection
