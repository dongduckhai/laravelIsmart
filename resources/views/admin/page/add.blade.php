@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Thêm trang
        </div>
        <div class="card-body">
            <form method="POST" action="{{url('admin/page/store')}}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="title">Tiêu đề trang</label>
                    <input class="form-control w-50" type="text" name="title" id="title" value="{{old('title')}}">
                @error('title')
                    <small class="text-danger font-italic">{{$message}}</small>
                @enderror
                </div>
                <div class="form-group">
                    <label for="content">Nội dung trang</label>
                    <textarea name="content" class="form-control ckeditor" id="content" cols="30" rows="15">{{old('content')}}</textarea>
                @error('content')
                    <small class="text-danger font-italic">{{$message}}</small>
                @enderror
                </div>
                <button type="submit" class="btn btn-success">Thêm mới</button>
            </form>
        </div>
    </div>
</div>
@endsection
