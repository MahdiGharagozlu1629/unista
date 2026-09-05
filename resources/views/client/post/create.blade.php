@extends('client.layout')
@section('main')

    <style>
        .create-wrap {
            max-width: 580px;
            margin: 1.5rem auto;
            padding: 0 1rem;
        }

        .create-card {
            background: #000;
            border: 1px solid var(--ig-border, #262626);
            border-radius: 12px;
            overflow: hidden;
        }

        .create-header {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--ig-border, #262626);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .create-title {
            text-align: center;
            color: #fafafa;
            font-size: 16px;
            font-weight: 700;
            margin: 0;
        }

        .create-body {
            padding: 1.5rem;
        }

        /* Instagram-style dropzone */
        .ig-dropzone {
            background: #0a0a0a !important;
            border: 2px dashed #363636 !important;
            border-radius: 12px !important;
            min-height: 240px !important;
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 2rem 1.5rem !important;
            color: #a8a8a8;
            cursor: pointer;
            transition: border-color .2s ease, background .2s ease;
        }

        .ig-dropzone:hover {
            border-color: var(--ig-blue, #0095f6) !important;
            background: #080e14 !important;
        }

        .ig-dropzone .dz-icon {
            font-size: 42px;
            color: #a8a8a8;
            margin-bottom: .75rem;
            display: block;
        }

        .ig-dropzone .dz-message {
            margin: 0 !important;
            text-align: center;
        }

        .ig-dropzone .dz-message span {
            font-size: 14.5px;
            color: #fafafa;
            font-weight: 600;
            display: block;
        }

        .ig-dropzone .dz-submessage {
            font-size: 12px;
            color: #737373;
            margin-top: 4px;
        }

        /* Uploaded thumbnails preview */
        .ig-dropzone .dz-preview {
            background: transparent !important;
            border: none !important;
            margin: 8px !important;
        }

        .ig-dropzone .dz-preview .dz-image {
            border-radius: 8px !important;
            border: 1px solid var(--ig-border, #262626) !important;
            overflow: hidden !important;
        }

        .ig-dropzone .dz-preview .dz-image img {
            width: 80px;
            height: 80px;
            object-fit: cover;
        }

        .ig-dropzone .dz-remove {
            color: #ed4956 !important;
            font-size: 12px !important;
            margin-top: 6px !important;
            text-decoration: none !important;
            font-weight: 600;
        }

        .ig-dropzone .dz-remove:hover {
            text-decoration: underline !important;
        }

        /* Caption field */
        .ig-textarea {
            background: #0a0a0a !important;
            border: 1px solid var(--ig-border, #262626) !important;
            border-radius: 10px !important;
            color: #fafafa !important;
            resize: none;
            padding: .85rem 1rem !important;
            font-size: 14px;
            line-height: 1.5;
        }

        .ig-textarea::placeholder {
            color: #737373;
        }

        .ig-textarea:focus {
            border-color: #555555 !important;
            box-shadow: none !important;
            outline: none;
        }

        /* Toggle */
        .ig-switch-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 0;
            border-top: 1px solid var(--ig-border-subtle, #1f1f1f);
            border-bottom: 1px solid var(--ig-border-subtle, #1f1f1f);
        }

        .ig-switch-label {
            color: #fafafa;
            font-size: 14px;
            font-weight: 500;
            margin: 0;
        }

        .ig-switch-desc {
            font-size: 12px;
            color: #737373;
            margin: 0;
        }

        .ig-switch {
            position: relative;
            display: inline-block;
            width: 44px;
            height: 24px;
            margin: 0;
        }

        .ig-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .ig-slider {
            position: absolute;
            cursor: pointer;
            inset: 0;
            background-color: #363636;
            transition: .25s ease;
            border-radius: 24px;
        }

        .ig-slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            right: 3px;
            bottom: 3px;
            background-color: #fff;
            transition: .25s ease;
            border-radius: 50%;
        }

        .ig-switch input:checked + .ig-slider {
            background-color: var(--ig-blue, #0095f6);
        }

        .ig-switch input:checked + .ig-slider:before {
            transform: translateX(-20px);
        }

        /* Submit */
        .ig-submit {
            background: var(--ig-blue, #0095f6);
            border: none;
            color: #fff;
            font-weight: 700;
            border-radius: 8px;
            padding: .65rem 1.6rem;
            font-size: 14px;
            transition: background .18s ease, transform .1s ease;
            cursor: pointer;
        }

        .ig-submit:hover {
            background: var(--ig-blue-hover, #1877f2);
        }

        .ig-submit:active {
            transform: scale(.97);
        }

        /* Mobile (< 576px) */
        @media (max-width: 575.98px) {
            .create-wrap {
                padding: 0;
                margin: 0;
            }

            .create-card {
                border-radius: 0;
                border-left: none;
                border-right: none;
            }

            .create-body {
                padding: 1.25rem 1rem;
            }

            .ig-submit {
                width: 100%;
                padding: .75rem;
            }
        }
    </style>

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
