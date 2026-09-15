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
                        <h3 class="card-title mb-0">مدیریت پست‌ها</h3>
                        <span class="badge badge-primary px-3 py-2">مجموع: {{ $posts->total() }} پست</span>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-striped mt-3">
                            <thead>
                            <tr>
                                <th class="text-center" width="5%">شناسه</th>
                                <th class="text-center" width="10%">مدیا</th>
                                <th class="text-center" width="15%">کاربر</th>
                                <th class="text-center" width="25%">کپشن</th>
                                <th class="text-center" width="8%">لایک‌ها</th>
                                <th class="text-center" width="8%">دیدگاه‌ها</th>
                                <th class="text-center" width="10%">وضعیت دیدگاه</th>
                                <th class="text-center" width="10%">تاریخ ثبت</th>
                                <th class="text-center" width="14%">عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($posts as $post)
                                @php
                                    $firstMedia = $post->first_media;
                                @endphp
                                <tr>
                                    <td class="text-center align-middle font-weight-bold">{{ $post->id }}</td>
                                    <td class="text-center align-middle">
                                        @if($firstMedia)
                                            @if(in_array(strtolower($firstMedia->type), ['mp4', 'mov', 'webm']))
                                                <div class="position-relative d-inline-block">
                                                    <video src="{{ asset('storage/posts/' . $firstMedia->name) }}" class="rounded shadow-sm" style="width: 54px; height: 54px; object-fit: cover;"></video>
                                                    <span class="badge badge-dark position-absolute" style="bottom: 2px; right: 2px; font-size: 10px;"><i class="fe fe-video"></i></span>
                                                </div>
                                            @else
                                                <img src="{{ asset('storage/posts/' . $firstMedia->name) }}" alt="Post thumbnail" class="rounded shadow-sm" style="width: 54px; height: 54px; object-fit: cover;">
                                            @endif
                                        @else
                                            <span class="badge badge-secondary p-2"><i class="fe fe-image"></i> بدون مدیا</span>
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">
                                        @if($post->user)
                                            <div class="font-weight-bold text-dark">{{ $post->user->username }}</div>
                                            <small class="text-muted">{{ $post->user->name }} {{ $post->user->family }}</small>
                                        @else
                                            <span class="text-muted">کاربر حذف شده</span>
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">
                                        <div class="text-truncate mx-auto" style="max-width: 250px;" title="{{ $post->content }}">
                                            {{ $post->content ? \Illuminate\Support\Str::limit($post->content, 45) : '—' }}
                                        </div>
                                    </td>
                                    <td class="text-center align-middle">
                                        <span class="badge badge-danger px-2 py-1">
                                            <i class="fe fe-heart"></i> {{ $post->likes_count }}
                                        </span>
                                    </td>
                                    <td class="text-center align-middle">
                                        <span class="badge badge-info px-2 py-1">
                                            <i class="fe fe-message-square"></i> {{ $post->comments_count }}
                                        </span>
                                    </td>
                                    <td class="text-center align-middle">
                                        @if($post->have_comment)
                                            <span class="badge badge-success">فعال</span>
                                        @else
                                            <span class="badge badge-secondary">غیرفعال</span>
                                        @endif
                                    </td>
                                    <td class="text-center align-middle text-muted small" dir="ltr">
                                        {{ $post->created_at ? $post->created_at->format('Y-m-d H:i') : '—' }}
                                    </td>
                                    <td class="text-center align-middle">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <a href="{{ route('admin.posts.show', ['post' => $post->id]) }}" class="btn btn-sm btn-outline-primary d-flex align-items-center" title="مشاهده جزئیات">
                                                <span class="fe fe-eye"></span>
                                                <span class="ml-1 d-none d-lg-inline">نمایش</span>
                                            </a>
                                            <form action="{{ route('admin.posts.destroy', ['post' => $post->id]) }}" method="post" class="m-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-outline-danger ml-2 delete-confirm d-flex align-items-center" data-title="این پست" title="حذف پست">
                                                    <span class="fe fe-trash"></span>
                                                    <span class="ml-1 d-none d-lg-inline">حذف</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-5 text-muted">
                                        <i class="fe fe-image fe-32 d-block mb-2"></i>
                                        هیچ پستی یافت نشد.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="d-flex justify-content-center mt-4">
                        {{ $posts->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        $(document).ready(function (){
            $(".delete-confirm").on("click", function (){
                const title = $(this).data('title') || 'این مورد';
                if (confirm("آیا از حذف " + title + " اطمینان دارید؟ تمامی دیدگاه‌ها و لایک‌های وابسته نیز حذف خواهند شد.")) {
                    $(this).closest('form').submit();
                }
            });
        });
    </script>
@endsection
