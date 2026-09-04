@extends('client.layout')
@section('main')

    <style>
        .create-wrap {
            max-width: 560px;
            margin: 1.5rem auto;
        }

        .create-card {
            background: #000;
            border: 1px solid #262626;
            border-radius: 12px;
            padding: 1.5rem;
        }

        .create-title {
            text-align: center;
            color: #fafafa;
            font-size: 17px;
            font-weight: 700;
            margin-bottom: 1.4rem;
        }

        /* Instagram-style dropzone */
        .ig-dropzone {
            background: #0a0a0a !important;
            border: 2px dashed #363636 !important;
            border-radius: 12px !important;
            min-height: 220px !important;
            display: flex !important;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            color: #a8a8a8;
            transition: border-color .2s ease, background .2s ease;
        }

        .ig-dropzone:hover {
            border-color: #d6249f !important;
            background: #0e0a0d !important;
        }

        .ig-dropzone .dz-message span {
            font-size: 14px;
            color: #a8a8a8;
        }

        /* Uploaded thumbnails preview */
        .ig-dropzone .dz-preview {
            background: transparent;
            border: none;
            margin: 8px;
        }

        .ig-dropzone .dz-preview .dz-image {
            border-radius: 8px;
            border: 1px solid #262626;
            overflow: hidden;
        }

        .ig-dropzone .dz-preview .dz-image img {
            width: 80px;
            height: 80px;
            object-fit: cover;
        }

        .ig-dropzone .dz-remove {
            color: #ed4956;
            font-size: 12px;
            margin-top: 4px;
        }

        /* Caption field */
        .ig-textarea {
            background: #0a0a0a !important;
            border: 1px solid #262626 !important;
            border-radius: 10px !important;
            color: #fafafa !important;
            resize: none;
            padding: .8rem 1rem !important;
        }

        .ig-textarea::placeholder {
            color: #8e8e8e;
        }

        .ig-textarea:focus {
            border-color: #363636 !important;
            box-shadow: none !important;
            outline: none;
        }

        /* Toggle */
        .ig-switch {
            display: flex;
            align-items: center;
            gap: .6rem;
            color: #fafafa;
            font-size: 14px;
        }

        .ig-switch input {
            width: 38px;
            height: 22px;
            cursor: pointer;
            accent-color: #0095f6;
        }

        /* Submit */
        .ig-submit {
            background: #0095f6;
            border: none;
            color: #fff;
            font-weight: 700;
            border-radius: 10px;
            padding: .6rem 1.4rem;
            transition: background .2s ease, transform .1s ease;
        }

        .ig-submit:hover {
            background: #1aa3ff;
        }

        .ig-submit:active {
            transform: scale(.97);
        }
    </style>

    <div class="create-wrap">
        <div class="create-card">
            <div class="create-title">پست جدید</div>

            <form action="{{ route('post.store') }}" method="post">
                @csrf

                <div class="dropzone ig-dropzone" id="dropzone">
                    <div class="dz-message" data-dz-message><span>فایل خود را اینجا رها کنید</span></div>
                </div>
                <div class="input-media"></div>

                <div class="mt-4">
                    <textarea rows="3" name="content" class="form-control ig-textarea"
                              placeholder="توضیحات را بنویسید..."></textarea>
                </div>

                <div class="mt-4">
                    <label class="ig-switch">
                        <input type="checkbox" name="have_comment" value="1" checked>
                        <span>اجازه کامنت</span>
                    </label>
                </div>

                <div class="d-flex justify-content-start mt-4">
                    <button type="submit" class="ig-submit">اشتراک‌گذاری</button>
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
            thumbnailWidth: 80,
            thumbnailHeight: 80,
            success: function (file, result) {
                console.log(result)
                $(".input-media").append("<input type='hidden' value='" + result + "' name='media[]'/>")
            }
        };
    </script>
@endsection
