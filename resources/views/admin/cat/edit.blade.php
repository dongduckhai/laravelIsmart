@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Cập nhật danh mục
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('cat.update', $cat->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">Tên danh mục</label>
                    <input class="form-control" type="text" name="name" id="name" value="{{$cat->name}}">
                @error('title')
                    <small class="text-danger font-italic">{{$message}}</small>
                @enderror
                </div>
                <button type="submit" class="btn btn-success">Cập nhật</button>
            </form>
        </div>
    </div>
</div>
@endsection
