@extends('client.layout')
@section('main')

    <div class="row border-bottom border-grey pb-3 position-relative">
        <div class="col-3 pl-0 col-md-1 user-profile">
            <img class="profile-story" src="{{asset("img/profile.jpg")}}" alt="">
        </div>
        <div class="col-9 col-md-11">
            <div class="d-flex scroll-x">
                <img class="profile-story mr-3" src="{{asset("img/profile.jpg")}}" alt="">
                <img class="profile-story mr-3" src="{{asset("img/profile.jpg")}}" alt="">
                <img class="profile-story mr-3" src="{{asset("img/profile.jpg")}}" alt="">
                <img class="profile-story mr-3" src="{{asset("img/profile.jpg")}}" alt="">
            </div>
        </div>
    </div>
    <div class="row mt-3 justify-content-between">


        @foreach($posts as $post)

            <div class="col-12 col-md-6 mb-3 p-0 pr-md-3">
                <div class="card rounded-20">
                    <div class="card-header border-bottom-radius-0">
                        <div class="card-title mb-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex justify-content-end align-items-center">
                                    <img class="profile mr-2" src="{{asset("img/profile.jpg")}}" alt="">
                                    <a href="#">
                                        <span>{{$post->user->username}}</span>
                                    </a>
                                </div>
                                {{--                            <div class="h-50">--}}
                                {{--                                <button class="btn btn-sm btn-outline-dark">{{__("message.follow")}}</button>--}}
                                {{--                            </div>--}}
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        <ul class="lightSlider">
                            @foreach($post->media as $media)
                                <li>
                                    <img class="h-75 w-100 object-fit-contain" src="{{asset("storage/posts/$media->name")}}" alt="">
                                </li>
                            @endforeach
                        </ul>

                    </div>
                    <div class="card-footer border-top-radius-0 text-right px-1">
                        <div class="d-flex justify-content-end border-bottom border-grey">
                            <a href="#">
                                <span class="comment mr-3">💬</span>
                            </a>
                            <span class="like">❤️</span>
                            <span class="dislike">🤍</span>
                        </div>
                        <div class="caption mt-2 text-justify">
                        <span class="fs-13">
                            لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک است، چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است، و برای شرایط فعلی تکنولوژی مورد نیاز، و کاربردهای متنوع با هدف بهبود
                        </span>
                        </div>
                    </div>
                </div>
            </div>

        @endforeach
    </div>
@endsection

@section('js')
    <script>
        // Slider
        $(document).ready(function () {
            $(".lightSlider").lightSlider({
                item: 1,
                autoWidth: false,
                slideMove: 1, // slidemove will be 1 if loop is true
                slideMargin: 10,

                addClass: '',
                mode: "slide",
                useCSS: true,
                cssEasing: 'ease', //'cubic-bezier(0.25, 0, 0.25, 1)',//
                easing: 'linear', //'for jquery animation',////

                speed: 400, //ms'
                auto: false,
                loop: false,
                slideEndAnimation: true,
                pause: 2000,

                keyPress: false,
                controls: true,
                prevHtml: '',
                nextHtml: '',

                rtl: true,
                adaptiveHeight: false,

                vertical: false,
                verticalHeight: 500,
                vThumbWidth: 100,

                thumbItem: 10,
                pager: true,
                gallery: false,
                galleryMargin: 5,
                thumbMargin: 5,
                currentPagerPosition: 'middle',

                enableTouch: true,
                enableDrag: true,
                freeMove: true,
                swipeThreshold: 40,

                responsive: [],

                onBeforeStart: function (el) {
                },
                onSliderLoad: function (el) {
                },
                onBeforeSlide: function (el) {
                },
                onAfterSlide: function (el) {
                },
                onBeforeNextSlide: function (el) {
                },
                onBeforePrevSlide: function (el) {
                }
            });
        });

        $(document).ready(function () {
            $("body").on("click", ".like", function () {
                $(this).hide();
                var parent = $(this).parent();
                parent.children(".dislike").show();
            }).on("click", ".dislike", function () {
                $(this).hide();
                var parent = $(this).parent();
                parent.children(".like").show();
            })
        })
    </script>
@endsection
