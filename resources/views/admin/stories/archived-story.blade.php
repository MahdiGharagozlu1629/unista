@extends('admin.layout')

@section('main')

    @if (session('success'))
        <div class="alert alert-success">
            <span class="fe fe-check"></span>
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="card-title mb-0">مدیریت استوری‌ها</h3>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-striped mt-3">
                            <thead>
                            <tr>
                                <th class="text-center" width="8%">شناسه</th>
                                <th class="text-center" width="15%">پیش‌نمایش</th>
                                <th class="text-center" width="20%">کاربر</th>
                                <th class="text-center" width="12%">نوع مدیا</th>
                                <th class="text-center" width="15%">وضعیت زمان</th>
                                <th class="text-center" width="15%">تاریخ انتشار</th>
                                <th class="text-center" width="15%">عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($stories as $story)
                                @php
                                    $mediaUrl = $story->media_url;
                                    $isVideo = $story->is_video;
                                    $isExpired = $story->created_at ? $story->created_at->lt(now()->subHours(24)) : false;
                                @endphp
                                <tr>
                                    <td class="text-center align-middle font-weight-bold">{{ $story->id }}</td>
                                    <td class="text-center align-middle">
                                        @if($mediaUrl)
                                            @if($isVideo)
                                                <div class="position-relative d-inline-block">
                                                    <video src="{{ $mediaUrl }}" class="rounded shadow-sm border" style="width: 50px; height: 75px; object-fit: cover;"></video>
                                                    <span class="badge badge-dark position-absolute" style="bottom: 2px; right: 2px; font-size: 10px;"><i class="fe fe-video"></i></span>
                                                </div>
                                            @else
                                                <a href="{{ $mediaUrl }}" target="_blank">
                                                    <img src="{{ $mediaUrl }}" alt="Story thumbnail" class="rounded shadow-sm border" style="width: 50px; height: 75px; object-fit: cover;">
                                                </a>
                                            @endif
                                        @else
                                            <span class="badge badge-secondary p-2"><i class="fe fe-alert-circle"></i> بدون مدیا</span>
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">
                                        @if($story->user)
                                            <div class="font-weight-bold text-dark">{{ $story->user->username }}</div>
                                            <small class="text-muted">{{ $story->user->name }} {{ $story->user->family }}</small>
                                        @else
                                            <span class="text-muted">کاربر حذف شده</span>
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">
                                        @if($isVideo)
                                            <span class="badge badge-info px-2 py-1"><i class="fe fe-video"></i> ویدیو</span>
                                        @else
                                            <span class="badge badge-secondary px-2 py-1"><i class="fe fe-image"></i> تصویر</span>
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">
                                        @if($isExpired)
                                            <span class="badge badge-secondary px-2 py-1">منقضی شده (بیش از ۲۴ ساعت)</span>
                                        @else
                                            <span class="badge badge-success px-2 py-1">فعال (در ۲۴ ساعت اخیر)</span>
                                        @endif
                                    </td>
                                    <td class="text-center align-middle text-muted small" dir="ltr">
                                        {{ $story->created_at ? $story->created_at->format('Y-m-d H:i') : '—' }}
                                    </td>
                                    <td class="text-center align-middle">
                                        <div class="d-flex justify-content-center align-items-center">
                                            @if($mediaUrl)
                                                <a href="{{ $mediaUrl }}" target="_blank" class="btn btn-sm btn-outline-info d-flex align-items-center" title="مشاهده فایل اصلی">
                                                    <span class="fe fe-external-link"></span>
                                                    <span class="ml-1 d-none d-lg-inline">مشاهده</span>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="fe fe-play-circle fe-32 d-block mb-2"></i>
                                        هیچ استوری یافت نشد.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="d-flex justify-content-center mt-4">
                        {{ $stories->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        $(document).ready(function (){
            $(".delete-story-btn").on("click", function (){
                if (confirm("آیا از حذف این استوری اطمینان دارید؟")) {
                    $(this).closest('form').submit();
                }
            });
        });
    </script>
@endsection
