@extends('client.layout')
@section('main')



    <div class="fr-wrap">
        <div class="fr-card">
            <div class="fr-header">
                <h1 class="fr-title">درخواست‌های دنبال کردن</h1>
            </div>

            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            @if(count($requests) > 0)
                <div class="fr-list">
                    @foreach($requests as $request)
                        <div class="fr-item">
                            <img class="fr-avatar" src="{{ asset('img/profile.jpg') }}" alt="">
                            <div class="fr-content">
                                <a class="fr-username"
                                   href="{{ route('users.show', ['id' => $request->followers->id]) }}">
                                    {{ $request->followers->username }}
                                </a>
                                <span class="fr-subtext">درخواست دنبال کردن شما را داده است</span>
                            </div>
                            <div class="fr-actions">
                                <a class="fr-btn fr-accept accept-follow" id="{{ $request->followers->id }}">
                                    <i class="fe fe-check"></i>
                                    تایید
                                </a>
                                <a class="fr-btn fr-followback follow-back d-none" id="{{ $request->followers->id }}">
                                    <i class="fe fe-user-plus"></i>
                                    دنبال کردن
                                </a>
                                <a class="fr-btn fr-reject reject-follow" id="{{ $request->followers->id }}">
                                    <i class="fe fe-x"></i>
                                    حذف
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="fr-empty">
                    <span class="fe fe-user-check"></span>
                    <p class="mt-3 mb-0">درخواست دنبال کردن جدیدی وجود ندارد.</p>
                </div>
            @endif
        </div>
    </div>

@endsection

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
                data: {
                    follower_id: followerId,
                    user_id: {{ $user->id }}
                },
                success: function () {

                    $(".accept-follow[id='" + followerId + "']").addClass("d-none")
                    $(".reject-follow[id='" + followerId + "']").addClass("d-none")
                    $(".follow-back[id='" + followerId + "']").removeClass("d-none")

                },
                error: function () {
                    alert(333333)
                }
            })
        })

    </script>

@endsection
