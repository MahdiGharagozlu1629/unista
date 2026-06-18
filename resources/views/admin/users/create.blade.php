@extends('admin.layout')

@section('main')

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">افزودن کاربر</h3>
                    </div>

                    <form action="{{route("user.store")}}" method="post">
                        @csrf

                        <div class="card-body">

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="name">نام</label>
                                        <input type="text" id="name" name="name" class="form-control"
                                               value="{{old('name')}}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="family">نام خانوادگی</label>
                                        <input type="text" id="family" name="family" class="form-control"
                                               value="{{old("family")}}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="username">نام کاربری</label>
                                        <input type="text" id="username" name="username" class="form-control"
                                               value="{{old('username')}}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="email">ایمیل</label>
                                        <input type="email" id="email" name="email" class="form-control"
                                               value="{{old('email')}}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="password_confirmation">تکرار رمز عبور</label>
                                        <input type="password" id="password_confirmation" name="password_confirmation"
                                               class="form-control">
                                    </div>
                                </div> <!-- /.col -->
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="phone">شماره تلفن</label>
                                        <input type="text" maxlength="11" id="phone" name="phone" class="form-control"
                                               value="{{old('phone')}}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="national_code">کد ملی</label>
                                        <input type="text" id="national_code" name="national_code" class="form-control"
                                               value="{{old('national_code')}}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="student_code">کد دانشجویی</label>
                                        <input type="text" id="student_code" name="student_code" class="form-control"
                                               value="{{old('student_code')}}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="password">رمز عبور</label>
                                        <input type="password" id="password" name="password" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="form-group mb-3">
                                    <button type="submit" class="btn btn-primary">ثبت</button>
                                </div>
                                <div class="form-group mb-3 ml-3">
                                    <a href="{{route('user.index')}}" class="btn btn-danger">بازگشت</a>
                                </div>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection
