@extends('client.layout')

<table class="w-100">
    <thead>
    <tr>
        <th class="text-center" width="50%">نام کاربری</th>
        <th class="text-center" width="50%">عملیات</th>
    </tr>
    </thead>
    <tbody>
    @foreach($requests as $request)
        <tr>
            <td class="text-center">
                <a class="text-white" href="{{route("users.show" , ['id' => $request->followers->id])}}">
                    {{$request->followers->username}}
                </a>
            </td>
            <td class="text-center">
                <div class="d-flex justify-content-center">
                    <a class="btn btn-sm btn-outline-success text-white accept-follow" id="{{$request->followers->id}}">
                        <i class="fe fe-check"></i>
                    </a>
                    <a class="btn btn-sm btn-outline-success text-white follow-back d-none" id="{{$request->followers->id}}">
                        <i class="fe fe-user-plus"></i>
                    </a>
                    <a class="btn btn-sm btn-outline-danger reject-follow text-white ml-2" id="{{$request->followers->id}}">
                        <i class="fe fe-x"></i>
                    </a>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

@section('js')

    <script>

        $(".accept-follow").on("click", function () {
            var followerId = $(this).attr("id");
            var element = $(this)
            $.ajax({
                url: "{{route("accept.follow")}}",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
                },
                method: "post",
                data : {
                    follower_id : followerId,
                    user_id : {{$user->id}}
                },
                success : function (){

                    $(".accept-follow[id='" + followerId +"']").addClass("d-none")
                    $(".reject-follow[id='" + followerId +"']").addClass("d-none")
                    $(".follow-back[id='" + followerId +"']").removeClass("d-none")

                },
                error : function (){
                    alert(333333)
                }
            })
        })

    </script>

@endsection
