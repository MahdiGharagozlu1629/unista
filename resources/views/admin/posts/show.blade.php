@extends('admin.layout')

@section('main')

    @if (session('success'))
        <div class="alert alert-success">
            <span class="fe fe-check"></span>
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="page-title mb-0">جزئیات پست #{{ $post->id }}</h3>
        <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fe fe-arrow-right"></i> بازگشت به لیست پست‌ها
        </a>
    </div>

    <div class="row">
        {{-- Post Details & Media --}}
        <div class="col-md-5">
            <div class="card shadow mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="font-weight-bold">اطلاعات و مدیا</span>
                    <form action="{{ route('admin.posts.destroy', ['post' => $post->id]) }}" method="post" class="m-0">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-sm btn-danger delete-post-btn">
                            <i class="fe fe-trash"></i> حذف این پست
                        </button>
                    </form>
                </div>
                <div class="card-body">
                    {{-- Media Gallery --}}
                    @php
                        $mediaList = $post->media_items;
                    @endphp
                    @if($mediaList->isNotEmpty())
                        <div class="row mb-3">
                            @foreach($mediaList as $m)
                                <div class="col-6 mb-2">
                                    @if(in_array(strtolower($m->type), ['mp4', 'mov', 'webm']))
                                        <video src="{{ asset('storage/posts/' . $m->name) }}" controls class="w-100 rounded border shadow-sm" style="max-height: 200px; object-fit: cover;"></video>
                                    @else
                                        <a href="{{ asset('storage/posts/' . $m->name) }}" target="_blank">
                                            <img src="{{ asset('storage/posts/' . $m->name) }}" alt="" class="w-100 rounded border shadow-sm" style="max-height: 200px; object-fit: cover;">
                                        </a>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-warning text-center">این پست فاقد فایل مدیا است.</div>
                    @endif

                    <hr>

                    {{-- Post Meta --}}
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted">ارسال‌کننده:</span>
                            @if($post->user)
                                <span class="font-weight-bold">{{ $post->user->username }} ({{ $post->user->name }} {{ $post->user->family }})</span>
                            @else
                                <span class="text-muted">کاربر حذف شده</span>
                            @endif
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted">تاریخ ایجاد:</span>
                            <span dir="ltr">{{ $post->created_at ? $post->created_at->format('Y-m-d H:i:s') : '—' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted">وضعیت دیدگاه‌ها:</span>
                            @if($post->have_comment)
                                <span class="badge badge-success">ثبت نظر فعال است</span>
                            @else
                                <span class="badge badge-secondary">ثبت نظر غیرفعال است</span>
                            @endif
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted">تعداد لایک‌ها:</span>
                            <span class="badge badge-danger px-2 py-1"><i class="fe fe-heart"></i> {{ $post->likes->count() }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted">تعداد دیدگاه‌ها:</span>
                            <span class="badge badge-info px-2 py-1"><i class="fe fe-message-square"></i> {{ $post->comments->count() }}</span>
                        </li>
                    </ul>

                    {{-- Caption Content --}}
                    <div class="mt-3">
                        <label class="font-weight-bold text-muted mb-1">کپشن / متن پست:</label>
                        <div class="p-3 bg-light rounded border text-dark" style="white-space: pre-wrap; min-height: 80px;">
                            {{ $post->content ?: 'بدون متن.' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Comments on this Post --}}
        <div class="col-md-7">
            <div class="card shadow mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="font-weight-bold">دیدگاه‌های این پست ({{ $post->comments->count() }})</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="thead-light">
                            <tr>
                                <th width="20%">کاربر</th>
                                <th width="50%">متن دیدگاه</th>
                                <th width="20%">تاریخ</th>
                                <th width="10%" class="text-center">عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($post->comments as $comment)
                                <tr>
                                    <td class="align-middle">
                                        @if($comment->user)
                                            <span class="font-weight-bold">{{ $comment->user->username }}</span>
                                        @else
                                            <span class="text-muted">نامشخص</span>
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        <div style="word-break: break-word;">{{ $comment->text }}</div>
                                    </td>
                                    <td class="align-middle small text-muted" dir="ltr">
                                        {{ $comment->created_at ? $comment->created_at->format('Y-m-d H:i') : '—' }}
                                    </td>
                                    <td class="align-middle text-center">
                                        <form action="{{ route('admin.comments.destroy', ['comment' => $comment->id]) }}" method="post" class="m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-outline-danger delete-comment-btn" title="حذف دیدگاه">
                                                <i class="fe fe-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">
                                        هنوز دیدگاهی برای این پست ثبت نشده است.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        $(document).ready(function (){
            $(".delete-post-btn").on("click", function (){
                if (confirm("آیا از حذف کامل این پست و تمام دیدگاه‌های آن اطمینان دارید؟")) {
                    $(this).closest('form').submit();
                }
            });

            $(".delete-comment-btn").on("click", function (){
                if (confirm("آیا از حذف این دیدگاه اطمینان دارید؟")) {
                    $(this).closest('form').submit();
                }
            });
        });
    </script>
@endsection
