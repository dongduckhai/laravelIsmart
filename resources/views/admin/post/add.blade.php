@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Thêm bài viết
        </div>
        <div class="card-body">
            <form method="POST" action="{{url('admin/post/store')}}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="title">Tiêu đề bài viết</label>
                    <input class="form-control w-50" type="text" name="title" id="title" value="{{old('title')}}">
                @error('title')
                    <small class="text-danger font-italic">{{$message}}</small>
                @enderror
                </div>
                <div class="form-group">
                    <label for="cat">Danh mục</label>
                    <select name="cat_id" id="cat"class="form-control" style="width:25%">
                        <option value="">... Chọn ...</option>
                        @foreach ($cat_list as $cat)
                            <option value="{{$cat->id}}" {{ old('cat_id') == $cat->id ? ' selected = "selected" ' : ''}}>
                                {{$cat->name}}
                            </option>
                        @endforeach
                    </select>
                    @error('cat_id')
                        <small class="text-danger font-italic">{{$message}}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="file">Ảnh tiêu đề</label>
                    <input class="form-control-file mb-2" type="file" name="file" id="thumbnail">
                @error('file')
                    <small class="text-danger font-italic">{{$message}}</small>
                @enderror
                </div>
                <div class="form-group">
                    <label for="desc">Mô tả (ngắn)</label>
                    <input type="text" name="desc" class="form-control" style="width:50%" id="desc" value="{{old('desc')}}">
                @error('desc')
                    <small class="text-danger font-italic">{{$message}}</small>
                @enderror
                </div>
                <div class="form-group">
                    <label for="content">Nội dung bài viết</label>
                    <textarea name="content" class="form-control ckeditor" id="content" cols="30" rows="15">{{old('content')}}</textarea>
                @error('content')
                    <small class="text-danger font-italic">{{$message}}</small>
                @enderror
                </div>
                <div class="form-group">
                    <label>Trạng thái</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="status1" value="1" checked>
                        <label class="form-check-label" for="status1">Chờ duyệt</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="status2" value="2" disabled>
                        <label class="form-check-label" for="status2">Công khai</label>
                    </div>
                @error('status')
                    <small class="text-danger font-italic">{{$message}}</small>
                @enderror
                </div>
                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="hot" name='hot'>
                        <label class="custom-control-label" for="hot">Bài viết nổi bật</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Thêm mới</button>
            </form>
        </div>
    </div>
</div>
@endsection
