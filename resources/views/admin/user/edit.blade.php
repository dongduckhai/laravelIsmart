@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Chỉnh sửa người dùng
            </div>
            <div class="card-body">
                <form action="{{ route('user.update', $user->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Họ và tên</label>
                        <input class="form-control" type="text" name="name" id="name" value='{{ $user->name }}'>
                        @error('name')
                            <small class="text-danger font-italic">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input class="form-control" type="text" name="email" id="email" disabled value='{{ $user->email }}'>
                    </div>
                    <div class="form-group">
                        <label for="email">Mật khẩu</label>
                        <input class="form-control" type="password" name="password" id="password">
                        @error('password')
                            <small class="text-danger font-italic">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="confirm-password">Xác nhận mật khẩu</label>
                        <input class="form-control" type="password" name="password_confirmation" id="confirm-password">
                    </div>
                    <div class="form-group">
                        <label for="role">Nhóm quyền</label>
                        <select name="role_id" id="role"class="form-control">
                            <option value="">... Chọn ...</option>
                            @foreach ($role_list as $role)
                                <option value="{{$role->id}}" {{$user->role_id == $role->id?"selected ='selected' ": ""}}
                                {{$user->id == Auth::id() ?'disabled':''}}>
                                    {{$role->name}}
                                </option>
                            @endforeach
                        {{-- dropdown role menu --}}
                        </select>
                        @error('role_id')
                            <small class="text-danger font-italic">{{$message}}</small>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-success">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
@endsection
