@extends('client.layout')
@section('main')

    <style>
        .fr-wrap {
            max-width: 560px;
            margin: 1.5rem auto;
        }

        .fr-title {
            color: #fafafa;
            font-size: 18px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 1.4rem;
        }

        .fr-list {
            background: #000;
            border: 1px solid #262626;
            border-radius: 12px;
            overflow: hidden;
        }

        .fr-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 1.1rem;
            border-bottom: 1px solid #262626;
        }

        .fr-item:last-child {
            border-bottom: none;
        }

        .fr-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid #262626;
            flex: 0 0 auto;
        }

        .fr-username {
            flex: 1 1 auto;
            min-width: 0;
            color: #fafafa;
            font-weight: 600;
            font-size: 15px;
        }

        .fr-username:hover {
            color: #fff;
            text-decoration: none;
        }

        .fr-actions {
            display: flex;
            align-items: center;
            gap: .5rem;
            flex: 0 0 auto;
        }

        .fr-btn {
            border-radius: 9px;
            padding: .45rem 1rem;
            font-size: 13px;
            font-weight: 700;
            border: none;
            display: flex;
            align-items: center;
            gap: .35rem;
            cursor: pointer;
            transition: background .2s ease, transform .1s ease, opacity .2s ease;
        }

        .fr-btn:active {
            transform: scale(.97);
        }

        .fr-accept {
            background: #0095f6;
            color: #fff;
        }

        .fr-accept:hover {
            background: #1aa3ff;
        }

        .fr-followback {
            background: #262626;
            color: #fafafa;
        }

        .fr-followback:hover {
            background: #363636;
        }

        .fr-reject {
            background: transparent;
            color: #ed4956;
            border: 1px solid #363636;
        }

        .fr-reject:hover {
            background: #1a0d0f;
            opacity: .85;
        }

        .fr-empty {
            text-align: center;
            color: #a8a8a8;
            padding: 4rem 1rem;
        }

        .fr-empty .fe {
            font-size: 2.6rem;
            color: #d6249f;
            opacity: .8;
        }
    </style>

    <div class="fr-wrap">
        <div class="fr-title">درخواست های دنبال کردن</div>

        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        @if(count($requests) > 0)
            <div class="fr-list">
                @foreach($requests as $request)
                    <div class="fr-item">
                        <img class="fr-avatar" src="{{ asset('img/profile.jpg') }}" alt="">
                        <a class="fr-username"
                           href="{{ route('users.show', ['id' => $request->followers->id]) }}">
                            {{ $request->followers->username }}
                        </a>
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
                                رد
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="fr-empty">
                <span class="fe fe-user-check"></span>
                <p class="mt-3 mb-0">درخواست دنبال کردن جدیدی نیست.</p>
            </div>
        @endif
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
