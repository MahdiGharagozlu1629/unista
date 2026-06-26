@extends('client.layout')
@section('main')

    <div class="row">
        <div class="col-12 p-0">

            <form action="{{ route('post.store') }}" method="post">
                @csrf

                <div class="dropzone" id="dropzone">
                    <div class="dz-message" data-dz-message><span>فایل خود را آپلود کنید</span></div>
                </div>
                <div class="input-media"></div>

                <div class="mt-5">
                    <textarea rows="3" name="content" class="form-control rounded-10" placeholder="توضیحات"></textarea>
                </div>

                <div class="mt-5">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" name="have_comment" value="1" checked class="custom-control-input"
                               id="customSwitch1">
                        <label class="custom-control-label text-white rounded-10" for="customSwitch1">کامنت ها</label>
                    </div>
                </div>

                <div class="d-flex justify-content-start mt-5">
                    <button type="submit" class="btn btn-success rounded-10">ثبت</button>
                </div>

            </form>

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
            thumbnailWidth: 60,
            thumbnailHeight: 60,
            success: function (file, result) {
                console.log(result)
                $(".input-media").append("<input type='hidden' value='" + result + "' name='media[]'/>")
            }
        };
    </script>
@endsection
