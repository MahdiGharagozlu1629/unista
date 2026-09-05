@extends('client.layout')
@section('main')



    <div class="create-wrap">
        <div class="create-card">
            <div class="create-header">
                <h1 class="create-title">ایجاد پست جدید</h1>
            </div>

            <div class="create-body">
                <form action="{{ route('post.store') }}" method="post">
                    @csrf

                    <div class="dropzone ig-dropzone" id="dropzone">
                        <span class="fe fe-image dz-icon"></span>
                        <div class="dz-message" data-dz-message>
                            <span>عکس‌ها یا ویدیوها را اینجا بکشید</span>
                            <div class="dz-submessage">یا برای انتخاب از رایانه کلیک کنید</div>
                        </div>
                    </div>
                    <div class="input-media"></div>

                    <div class="mt-4">
                        <textarea rows="3" name="content" class="form-control ig-textarea"
                                  placeholder="توضیحات و کپشن پست را بنویسید..."></textarea>
                    </div>

                    <div class="mt-4 ig-switch-row">
                        <div>
                            <p class="ig-switch-label">اجازه ثبت نظر (کامنت)</p>
                            <p class="ig-switch-desc">کاربران می‌توانند برای این پست نظر بگذارند</p>
                        </div>
                        <label class="ig-switch">
                            <input type="checkbox" name="have_comment" value="1" checked>
                            <span class="ig-slider"></span>
                        </label>
                    </div>

                    <div class="d-flex justify-content-start mt-4">
                        <button type="submit" class="ig-submit">اشتراک‌گذاری پست</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        // Dropzone.autoDiscover = false;

        Dropzone.options.dropzone = {
            url: "{{route("media.create")}}",
            paramName: "file",
            acceptedFiles: ".png, .jpg, .jpeg, .mp4",
            sending: function (file, xhr, formData) {
                formData.append("_token", "{{ csrf_token() }}");
            },
            // uploadMultiple : true,
            maxFilesize: "{{ini_get('upload_max_filesize')}}",
            thumbnailWidth: 80,
            thumbnailHeight: 80,
            success: function (file, result) {
                console.log(result)
                $(".input-media").append("<input type='hidden' value='" + result + "' name='media[]'/>")
            }
        };
    </script>
@endsection
