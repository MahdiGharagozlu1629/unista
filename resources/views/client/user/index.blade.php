@extends('client.layout')

<div class="d-flex">
    <img class="profile-user" src="{{asset("img/profile.jpg")}}" alt="">
    <div class="d-flex flex-column justify-content-center ml-3 w-100 mt-2">
        <span class="text-white ml-3">{{$user->username}}</span>
        <table class="text-white">
            <thead>
            <tr>
                <th width="25%" class="text-center">پست ها</th>
                <th width="25%" class="text-center">دنبال کننده</th>
                <th width="25%" class="text-center">دنبال شونده</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td width="25%" class="text-center">{{count($user->posts)}}</td>
                <td width="25%" class="text-center">100</td>
                <td width="25%" class="text-center">5000</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="mt-5">
    <div class="d-flex justify-content-between">
        <a class="btn text-white border-white d-flex align-items-center justify-content-center btn-outline-info w-100 ml-2">
            <i class="fe fe-user-plus mr-1"></i>
            دنبال کردن
        </a>
        <a class="btn text-white border-white d-flex align-items-center justify-content-center btn-outline-info w-100 ml-2">
            <i class="fe fe-message-square mr-1"></i>
            پیام
        </a>
    </div>
</div>

@if(count($user->posts) > 0)
    <div class="mt-5 text-white border">
        <div class="d-flex justify-content-start flex-wrap">
            @foreach($user->posts as $post)
                <a href="" class="h-50 w-25">
                    <img class="h-100 w-100 border p-1 object-fit-contain" src="{{asset("storage/posts/"  . $post->media->name)}}" alt="">
                </a>
            @endforeach
        </div>
    </div>
@endif


@section('js')

@endsection
