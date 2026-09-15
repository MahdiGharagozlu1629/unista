@extends('admin.layout')

@section('main')

    @if (session('success'))
        <div class="alert alert-success">
            <span class="fe fe-check"></span>
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="page-title mb-1">تاریخچه گفتگوی #{{ $conversation->id }}</h3>
            <span class="text-muted">
                گفتگو بین: 
                <strong class="text-primary">{{ $conversation->userOne->username ?? 'کاربر ۱' }}</strong> 
                و 
                <strong class="text-info">{{ $conversation->userTwo->username ?? 'کاربر ۲' }}</strong>
            </span>
        </div>
        <div class="d-flex align-items-center">
            <form action="{{ route('admin.chats.destroy', ['chat' => $conversation->id]) }}" method="post" class="m-0 mr-2">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-sm btn-danger delete-all-btn">
                    <i class="fe fe-trash"></i> حذف کامل این گفتگو
                </button>
            </form>
            <a href="{{ route('admin.chats.index') }}" class="btn btn-outline-secondary btn-sm ml-2">
                <i class="fe fe-arrow-right"></i> بازگشت
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="font-weight-bold">پیام‌های رد و بدل شده ({{ $messages->count() }} پیام)</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0">
                            <thead class="thead-light">
                            <tr>
                                <th class="text-center" width="6%">شناسه</th>
                                <th class="text-center" width="16%">فرستنده</th>
                                <th class="text-center" width="16%">گیرنده</th>
                                <th class="text-right" width="40%">متن پیام</th>
                                <th class="text-center" width="12%">زمان ارسال</th>
                                <th class="text-center" width="10%">عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($messages as $msg)
                                @php
                                    $isUserOne = $msg->sender_id == $conversation->user_one_id;
                                @endphp
                                <tr>
                                    <td class="text-center align-middle small">{{ $msg->id }}</td>
                                    <td class="text-center align-middle">
                                        @if($msg->sender)
                                            <span class="badge {{ $isUserOne ? 'badge-primary' : 'badge-info' }} px-2 py-1">
                                                <i class="fe fe-user"></i> {{ $msg->sender->username }}
                                            </span>
                                        @else
                                            <span class="text-muted">نامشخص</span>
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">
                                        @if($msg->receiver)
                                            <span class="text-dark font-weight-bold">{{ $msg->receiver->username }}</span>
                                        @else
                                            <span class="text-muted">نامشخص</span>
                                        @endif
                                    </td>
                                    <td class="text-right align-middle">
                                        <div class="p-2 bg-light rounded text-dark d-inline-block text-right" style="max-width: 500px; word-break: break-word;">
                                            {{ $msg->body }}
                                        </div>
                                    </td>
                                    <td class="text-center align-middle small text-muted" dir="ltr">
                                        {{ $msg->created_at ? $msg->created_at->format('Y-m-d H:i') : '—' }}
                                        @if($msg->is_read)
                                            <span class="fe fe-check-circle text-success" title="خوانده شده"></span>
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">
                                        <form action="{{ route('admin.chats.message.destroy', ['id' => $msg->id]) }}" method="post" class="m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-outline-danger delete-msg-btn" title="حذف این پیام">
                                                <i class="fe fe-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        هیچ پیامی در این گفتگو ثبت نشده است.
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
            $(".delete-all-btn").on("click", function (){
                if (confirm("آیا از حذف کامل این گفتگو و تمامی پیام‌های آن اطمینان دارید؟")) {
                    $(this).closest('form').submit();
                }
            });

            $(".delete-msg-btn").on("click", function (){
                if (confirm("آیا از حذف این پیام اطمینان دارید؟")) {
                    $(this).closest('form').submit();
                }
            });
        });
    </script>
@endsection
