@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Thêm nhãn hàng
        </div>
        <div class="card-body">
            <form method="POST" action="{{url('admin/brand/store')}}">
                @csrf
                <div class="form-group">
                    <label for="title">Tên nhãn hàng</label>
                    <input class="form-control w-25" type="text" name="name" id="title" value="{{old('name')}}">
                @error('name')
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
                <button type="submit" class="btn btn-success">Thêm mới</button>
            </form>
        </div>
    </div>
</div>
@endsection
