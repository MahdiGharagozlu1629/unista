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
        <a href="{{route("follow.requests")}}" class="w-100 btn text-white border-white d-flex align-items-center justify-content-center btn-outline-info ">
            <i class="fe fe-bell mr-1"></i>
            درخواست ها
        </a>
        <a href="#" class="w-100 btn text-white border-white d-flex align-items-center justify-content-center btn-outline-info ml-2">
            <i class="fe fe-edit-2 mr-1"></i>
            ویرایش پروفایل
        </a>
    </div>
</div>

@if(count($user->posts) > 0)
    <div class="mt-5 text-white border">
        <div class="d-flex justify-content-start flex-wrap">
            @foreach($user->posts as $post)
                <a href="" class="h-50 w-25">
                    <img class="h-100 w-100 border p-1 object-fit-contain"
                         src="{{asset("storage/posts/"  . $post->media->name)}}" alt="">
                </a>
            @endforeach
        </div>
    </div>
@endif


@section('js')

@endsection
