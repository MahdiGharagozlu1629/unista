@extends('client.layout')
@section('main')



    <div class="create-wrap">
        <div class="create-card">
            <div class="create-header">
                <h1 class="create-title">ایجاد استوری جدید</h1>
            </div>

            <div class="create-body">
                <form action="{{ route('store.story') }}" method="post">
                    @csrf

                    <div class="dropzone ig-dropzone" id="dropzone">
                        <span class="fe fe-image dz-icon"></span>
                        <div class="dz-message" data-dz-message>
                            <span>عکس‌ها یا ویدیوها را اینجا بکشید</span>
                            <div class="dz-submessage">یا برای انتخاب از رایانه کلیک کنید</div>
                        </div>
                    </div>
                    <div class="input-media"></div>

                    <div class="d-flex justify-content-start mt-4">
                        <button type="submit" class="ig-submit">اشتراک‌گذاری استوری</button>
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
            url: "{{route("media.story")}}",
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
