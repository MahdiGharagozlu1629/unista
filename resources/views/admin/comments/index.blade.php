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
                        <h3 class="card-title mb-0">مدیریت دیدگاه‌ها</h3>
                        <span class="badge badge-primary px-3 py-2">مجموع: {{ $comments->total() }} دیدگاه</span>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-striped mt-3">
                            <thead>
                            <tr>
                                <th class="text-center" width="6%">شناسه</th>
                                <th class="text-center" width="18%">نویسنده نظر</th>
                                <th class="text-center" width="16%">پست مربوطه</th>
                                <th class="text-center" width="36%">متن دیدگاه</th>
                                <th class="text-center" width="14%">تاریخ ارسال</th>
                                <th class="text-center" width="10%">عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($comments as $comment)
                                <tr>
                                    <td class="text-center align-middle font-weight-bold">{{ $comment->id }}</td>
                                    <td class="text-center align-middle">
                                        @if($comment->user)
                                            <div class="font-weight-bold text-dark">{{ $comment->user->username }}</div>
                                            <small class="text-muted">{{ $comment->user->name }} {{ $comment->user->family }}</small>
                                        @else
                                            <span class="text-muted">کاربر حذف شده</span>
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">
                                        @if($comment->post)
                                            <a href="{{ route('admin.posts.show', ['post' => $comment->post->id]) }}" class="btn btn-sm btn-outline-info">
                                                <i class="fe fe-file-text"></i> پست #{{ $comment->post->id }}
                                            </a>
                                            @if($comment->post->user)
                                                <div class="small text-muted mt-1">توسط {{ $comment->post->user->username }}</div>
                                            @endif
                                        @else
                                            <span class="badge badge-secondary">پست حذف شده</span>
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">
                                        <div class="p-2 bg-light rounded text-dark text-right mx-auto" style="max-width: 400px; word-break: break-word;">
                                            {{ $comment->text }}
                                        </div>
                                    </td>
                                    <td class="text-center align-middle text-muted small" dir="ltr">
                                        {{ $comment->created_at ? $comment->created_at->format('Y-m-d H:i') : '—' }}
                                    </td>
                                    <td class="text-center align-middle">
                                        <form action="{{ route('admin.comments.destroy', ['comment' => $comment->id]) }}" method="post" class="m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-outline-danger delete-comment-btn d-flex align-items-center mx-auto" title="حذف دیدگاه">
                                                <span class="fe fe-trash"></span>
                                                <span class="ml-1 d-none d-lg-inline">حذف</span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="fe fe-message-square fe-32 d-block mb-2"></i>
                                        هیچ دیدگاهی یافت نشد.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="d-flex justify-content-center mt-4">
                        {{ $comments->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        $(document).ready(function (){
            $(".delete-comment-btn").on("click", function (){
                if (confirm("آیا از حذف این دیدگاه اطمینان دارید؟")) {
                    $(this).closest('form').submit();
                }
            });
        });
    </script>
@endsection
