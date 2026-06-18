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
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">کاربران</h3>
                        <a href="{{route("user.create")}}" class="btn btn-sm btn-outline-success">افزودن کاربر</a>
                    </div>
                    <table class="table table-hover mt-5">
                        <thead>
                        <tr>
                            <th class="text-center">شناسه</th>
                            <th class="text-center">نام</th>
                            <th class="text-center">نام خانوادگی</th>
                            <th class="text-center">نام کاربری</th>
                            <th class="text-center">ایمیل</th>
                            <th class="text-center">شماره تلفن</th>
                            <th class="text-center">عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td class="text-center">{{$user->id}}</td>
                                <td class="text-center">{{$user->name}}</td>
                                <td class="text-center">{{$user->family}}</td>
                                <td class="text-center">{{$user->username}}</td>
                                <td class="text-center">{{$user->email}}</td>
                                <td class="text-center">{{$user->phone}}</td>
                                <td class="text-center" width="10%">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <a href="{{route("user.edit" , ['user' => $user->id])}}" class="btn btn-sm btn-outline-warning d-flex align-items-center">
                                            <span class="fe fe-edit-2"></span>
                                            <span class="ml-1">ویرایش</span>
                                        </a>
                                        <form action="{{route("user.destroy" , ['user' => $user])}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger ml-2 delete-user d-flex mb-0 align-items-center">
                                                <span class="fe fe-trash"></span>
                                                <span class="ml-1">حذف</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        $(document).ready(function (){
            $(".delete-user").on("click" , function (){
                if (confirm("از حذف این یوزر مطمئن هستید؟"))
                    $(this).parent().submit();
            })
        })
    </script>
@endsection
