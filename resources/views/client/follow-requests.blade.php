@extends('client.layout')
@section('main')

    <style>
        .fr-wrap {
            max-width: 580px;
            margin: 1.5rem auto;
            padding: 0 1rem;
        }

        .fr-card {
            background: #000;
            border: 1px solid var(--ig-border, #262626);
            border-radius: 12px;
            overflow: hidden;
        }

        .fr-header {
            padding: 1.1rem 1.25rem;
            border-bottom: 1px solid var(--ig-border, #262626);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .fr-title {
            color: #fafafa;
            font-size: 16px;
            font-weight: 700;
            margin: 0;
            text-align: center;
        }

        .fr-list {
            background: #000;
        }

        .fr-item {
            display: flex;
            align-items: center;
            gap: .9rem;
            padding: .9rem 1.25rem;
            border-bottom: 1px solid var(--ig-border-subtle, #1a1a1a);
            transition: background .15s ease;
        }

        .fr-item:last-child {
            border-bottom: none;
        }

        .fr-item:hover {
            background: rgba(255, 255, 255, 0.02);
        }

        .fr-avatar {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid var(--ig-border, #262626);
            flex: 0 0 auto;
        }

        .fr-content {
            flex: 1 1 auto;
            min-width: 0;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .fr-username {
            color: #fafafa;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .fr-username:hover {
            color: #fff;
            text-decoration: underline;
        }

        .fr-subtext {
            font-size: 12px;
            color: #737373;
        }

        .fr-actions {
            display: flex;
            align-items: center;
            gap: .5rem;
            flex: 0 0 auto;
        }

        .fr-btn {
            border-radius: 8px;
            padding: .45rem .95rem;
            font-size: 13px;
            font-weight: 600;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .35rem;
            cursor: pointer;
            transition: background .18s ease, transform .1s ease, opacity .18s ease;
            text-decoration: none;
            white-space: nowrap;
        }

        .fr-btn:active {
            transform: scale(.96);
        }

        .fr-accept {
            background: var(--ig-blue, #0095f6);
            color: #fff;
        }

        .fr-accept:hover {
            background: var(--ig-blue-hover, #1877f2);
            color: #fff;
            text-decoration: none;
        }

        .fr-followback {
            background: #262626;
            color: #fafafa;
        }

        .fr-followback:hover {
            background: #363636;
            color: #fafafa;
            text-decoration: none;
        }

        .fr-reject {
            background: #262626;
            color: #fafafa;
        }

        .fr-reject:hover {
            background: #363636;
            color: #ed4956;
            text-decoration: none;
        }

        .fr-empty {
            text-align: center;
            color: #a8a8a8;
            padding: 4.5rem 1.5rem;
        }

        .fr-empty .fe {
            font-size: 2.8rem;
            color: #d6249f;
            opacity: .8;
        }

        /* Mobile (< 576px) */
        @media (max-width: 575.98px) {
            .fr-wrap {
                padding: 0;
                margin: 0;
            }

            .fr-card {
                border-radius: 0;
                border-left: none;
                border-right: none;
            }

            .fr-item {
                padding: .8rem 1rem;
            }

            .fr-avatar {
                width: 42px;
                height: 42px;
            }

            .fr-btn {
                padding: .4rem .75rem;
                font-size: 12.5px;
            }
        }
    </style>

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
