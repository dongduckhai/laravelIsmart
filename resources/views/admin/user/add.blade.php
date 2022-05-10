@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Thêm người dùng
            </div>
            <div class="card-body">
                <form method="POST" action="{{url('admin/user/store')}}">
                    @csrf
                    <div class="form-group">
                        <label for="name">Họ và tên</label>
                        <input class="form-control w-50" type="text" name="name" id="name" value="{{old('name')}}">
                        @error('name')
                            <small class="text-danger font-italic">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input class="form-control w-50" type="text" name="email" id="email" value="{{old('email')}}">
                        @error('email')
                            <small class="text-danger font-italic">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Mật khẩu</label>
                        <input class="form-control w-50" type="password" name="password" id="password">
                        @error('password')
                            <small class="text-danger font-italic">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="confirm-password">Xác nhận mật khẩu</label>
                        <input class="form-control w-50" type="password" name="password_confirmation" id="confirm-password">
                    </div>
                    <div class="form-group">
                        <label for="role">Nhóm quyền</label>
                        <select name="role_id" id="role"class="form-control w-25">
                            <option value="">... Chọn ...</option>
                            @foreach ($role_list as $role)
                                <option value="{{$role->id}}">{{$role->name}}</option>
                            @endforeach
                        {{-- dropdown role menu --}}
                        </select>
                        @error('role_id')
                            <small class="text-danger font-italic">{{$message}}</small>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-success">Thêm mới</button>
                </form>
            </div>
        </div>
    </div>
@endsection
