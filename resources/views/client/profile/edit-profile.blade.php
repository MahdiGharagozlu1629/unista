@extends('client.layout')
@section('main')

    <div class="create-wrap">
        <div class="create-card">
            <div class="create-header">
                <h1 class="create-title">ویرایش پروفایل</h1>
            </div>

            <div class="create-body">
                @if (session('success'))
                    <div class="alert alert-success d-flex align-items-center mb-4">
                        <span class="fe fe-check mr-2"></span>
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Instagram-Style Profile Photo Header --}}
                <div class="edit-profile-photo-box mb-4 p-3 rounded" style="background: #121212; border: 1px solid #262626;">
                    <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap: 12px;">
                        <div class="d-flex align-items-center">
                            <div class="position-relative" style="width: 68px; height: 68px; flex-shrink: 0;">
                                <img id="profileAvatarPreview" src="{{ $user->avatar_url }}" alt="{{ $user->username }}" class="rounded-circle border" style="width: 100%; height: 100%; object-fit: cover; border-color: #363636 !important;">
                                <label for="profileImageFileInput" class="position-absolute d-flex align-items-center justify-content-center bg-primary text-white rounded-circle shadow" style="bottom: 0; right: 0; width: 24px; height: 24px; margin: 0; cursor: pointer;" title="تغییر عکس">
                                    <i class="fe fe-camera" style="font-size: 12px;"></i>
                                </label>
                            </div>
                            <div class="mr-3">
                                <div class="font-weight-bold text-white" style="font-size: 15px;">{{ $user->username }}</div>
                                <div class="text-muted small">{{ $user->name }} {{ $user->family }}</div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center" style="gap: 8px;">
                            <label for="profileImageFileInput" class="btn btn-sm btn-primary mb-0" style="font-size: 13px; font-weight: 600; border-radius: 8px; cursor: pointer; padding: 6px 14px;">
                                <i class="fe fe-upload mr-1"></i> تغییر عکس
                            </label>
                            <button type="button" id="removePhotoBtn" class="btn btn-sm btn-outline-danger mb-0" style="font-size: 13px; font-weight: 600; border-radius: 8px; padding: 6px 14px; {{ $user->profile_id ? '' : 'display: none;' }}">
                                <i class="fe fe-trash mr-1"></i> حذف عکس
                            </button>
                        </div>
                    </div>
                </div>

                <form action="{{ route('update.profile') }}" method="post" enctype="multipart/form-data" id="editProfileForm">
                    @csrf
                    @method('PUT')

                    {{-- Hidden file input for photo --}}
                    <input type="file" id="profileImageFileInput" name="profile_image" accept="image/png, image/jpeg, image/jpg, image/webp" style="display: none;">
                    <input type="hidden" id="profileMediaIdInput" name="media" value="{{ $user->profile_id }}">

                    {{-- Drag & Drop Dropzone --}}
                    <div class="dropzone ig-dropzone mb-3" id="dropzone">
                        <span class="fe fe-image dz-icon"></span>
                        <div class="dz-message" data-dz-message>
                            <span>برای تغییر عکس، تصویر جدید را اینجا بکشید یا کلیک کنید</span>
                        </div>
                    </div>
                    <div class="input-media"></div>

                    <div class="mt-4">
                        <label class="text-muted small mb-1">نام</label>
                        <input type="text" class="form-control ig-input" name="name" placeholder="نام" value="{{ old('name', $user->name) }}" required>
                    </div>

                    <div class="mt-4">
                        <label class="text-muted small mb-1">نام خانوادگی</label>
                        <input type="text" class="form-control ig-input" name="family" placeholder="نام خانوادگی" value="{{ old('family', $user->family) }}" required>
                    </div>

                    <div class="mt-4">
                        <label class="text-muted small mb-1">نام کاربری</label>
                        <input type="text" class="form-control ig-input" name="username" placeholder="نام کاربری" value="{{ old('username', $user->username) }}" required>
                    </div>

                    <div class="mt-4">
                        <label class="text-muted small mb-1">شماره تلفن</label>
                        <input type="text" class="form-control ig-input" name="phone" placeholder="شماره تلفن" value="{{ old('phone', $user->phone) }}" required>
                    </div>

                    <div class="mt-4">
                        <label class="text-muted small mb-1">کد ملی</label>
                        <input type="text" class="form-control ig-input" name="national_code" disabled placeholder="کدملی" value="{{ $user->national_code }}">
                    </div>

                    <div class="mt-4">
                        <label class="text-muted small mb-1">شماره دانشجویی</label>
                        <input type="text" class="form-control ig-input" name="student_code" disabled placeholder="شماره دانشجویی" value="{{ $user->student_code }}">
                    </div>

                    <div class="mt-4">
                        @if ($errors->any())
                            <ul class="p-0" style="list-style: none;">
                                @foreach ($errors->all() as $error)
                                    <li><div class="alert alert-danger py-2 mb-2">{{ $error }}</div></li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    <div class="d-flex justify-content-start mt-4">
                        <button type="submit" class="ig-submit">ذخیره تغییرات</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        $(document).ready(function () {
            // Instant Image Selection Preview & Background Upload
            $('#profileImageFileInput').on('change', function (e) {
                const file = this.files[0];
                if (!file) return;

                // 1. Show immediate local preview
                const reader = new FileReader();
                reader.onload = function (event) {
                    $('#profileAvatarPreview').attr('src', event.target.result);
                };
                reader.readAsDataURL(file);

                // 2. Upload via AJAX directly for instant feedback
                const formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('file', file);

                $.ajax({
                    url: '{{ route("media.profile") }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (res) {
                        if (res && res.url) {
                            $('#profileAvatarPreview').attr('src', res.url);
                            $('#profileMediaIdInput').val(res.id);
                            $('#removePhotoBtn').show();
                        }
                    },
                    error: function (xhr) {
                        console.error('Upload failed:', xhr);
                    }
                });
            });

            // Remove Profile Photo Action
            $('#removePhotoBtn').on('click', function () {
                if (confirm('آیا از حذف عکس پروفایل اطمینان دارید؟')) {
                    $.ajax({
                        url: '{{ route("profile.photo.remove") }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (res) {
                            $('#profileAvatarPreview').attr('src', '{{ asset("img/profile.jpg") }}');
                            $('#profileMediaIdInput').val('');
                            $('#profileImageFileInput').val('');
                            $('#removePhotoBtn').hide();
                        },
                        error: function () {
                            alert('خطا در حذف عکس پروفایل.');
                        }
                    });
                }
            });
        });

        // Dropzone configuration for profile image
        Dropzone.options.dropzone = {
            url: "{{ route('media.profile') }}",
            paramName: "file",
            acceptedFiles: ".png, .jpg, .jpeg, .webp",
            sending: function (file, xhr, formData) {
                formData.append("_token", "{{ csrf_token() }}");
            },
            maxFiles: 1,
            maxFilesize: "{{ ini_get('upload_max_filesize') }}",
            thumbnailWidth: 90,
            thumbnailHeight: 90,
            dictDefaultMessage: "برای تغییر عکس، تصویر جدید را اینجا بکشید یا کلیک کنید",
            success: function (file, result) {
                if (result && result.url) {
                    $('#profileAvatarPreview').attr('src', result.url);
                    $('#profileMediaIdInput').val(result.id);
                    $('#removePhotoBtn').show();
                }
            }
        };
    </script>
@endsection
