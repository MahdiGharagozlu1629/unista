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
                        <h3 class="card-title mb-0">مدیریت گفتگوها و پیام‌ها</h3>
                        <span class="badge badge-primary px-3 py-2">مجموع: {{ $conversations->total() }} گفتگو</span>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-striped mt-3">
                            <thead>
                            <tr>
                                <th class="text-center" width="6%">شناسه</th>
                                <th class="text-center" width="18%">کاربر اول</th>
                                <th class="text-center" width="18%">کاربر دوم</th>
                                <th class="text-center" width="28%">آخرین پیام</th>
                                <th class="text-center" width="10%">تعداد پیام‌ها</th>
                                <th class="text-center" width="12%">زمان آخرین پیام</th>
                                <th class="text-center" width="14%">عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($conversations as $conv)
                                <tr>
                                    <td class="text-center align-middle font-weight-bold">{{ $conv->id }}</td>
                                    <td class="text-center align-middle">
                                        @if($conv->userOne)
                                            <div class="font-weight-bold text-dark">{{ $conv->userOne->username }}</div>
                                            <small class="text-muted">{{ $conv->userOne->name }} {{ $conv->userOne->family }}</small>
                                        @else
                                            <span class="text-muted">کاربر حذف شده</span>
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">
                                        @if($conv->userTwo)
                                            <div class="font-weight-bold text-dark">{{ $conv->userTwo->username }}</div>
                                            <small class="text-muted">{{ $conv->userTwo->name }} {{ $conv->userTwo->family }}</small>
                                        @else
                                            <span class="text-muted">کاربر حذف شده</span>
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">
                                        <div class="text-truncate mx-auto text-dark" style="max-width: 260px;" title="{{ $conv->last_message }}">
                                            {{ $conv->last_message ? \Illuminate\Support\Str::limit($conv->last_message, 45) : '—' }}
                                        </div>
                                    </td>
                                    <td class="text-center align-middle">
                                        <span class="badge badge-info px-2 py-1">
                                            <i class="fe fe-message-circle"></i> {{ $conv->messages_count }}
                                        </span>
                                    </td>
                                    <td class="text-center align-middle text-muted small" dir="ltr">
                                        {{ $conv->last_message_at ? $conv->last_message_at->diffForHumans() : '—' }}
                                    </td>
                                    <td class="text-center align-middle">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <a href="{{ route('admin.chats.show', ['chat' => $conv->id]) }}" class="btn btn-sm btn-outline-primary d-flex align-items-center" title="مشاهده تاریخچه پیام‌ها">
                                                <span class="fe fe-eye"></span>
                                                <span class="ml-1 d-none d-lg-inline">پیام‌ها</span>
                                            </a>
                                            <form action="{{ route('admin.chats.destroy', ['chat' => $conv->id]) }}" method="post" class="m-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-outline-danger ml-2 delete-conv-btn d-flex align-items-center" title="حذف کل مکالمه">
                                                    <span class="fe fe-trash"></span>
                                                    <span class="ml-1 d-none d-lg-inline">حذف</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="fe fe-send fe-32 d-block mb-2"></i>
                                        هیچ گفتگویی یافت نشد.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="d-flex justify-content-center mt-4">
                        {{ $conversations->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        $(document).ready(function (){
            $(".delete-conv-btn").on("click", function (){
                if (confirm("آیا از حذف کامل این گفتگو و تمامی پیام‌های تبادل‌شده بین این دو کاربر اطمینان دارید؟")) {
                    $(this).closest('form').submit();
                }
            });
        });
    </script>
@endsection
