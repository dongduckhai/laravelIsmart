@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Thêm danh mục
        </div>
        <div class="card-body">
            <form method="POST" action="{{ url('admin/cat/store') }}" >
                @csrf
                <div class="form-group">
                    <label for="name">Tên danh mục</label>
                    <input class="form-control w-50" type="text" name="name" id="name" value="{{old('title')}}">
                @error('title')
                    <small class="text-danger font-italic">{{$message}}</small>
                @enderror
                </div>
                <button type="submit" class="btn btn-success">Thêm mới</button>
            </form>
        </div>
    </div>
</div>
@endsection
