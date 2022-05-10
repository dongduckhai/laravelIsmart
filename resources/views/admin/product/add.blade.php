@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Thêm sản phẩm
            </div>
            <div class="card-body">
                <form method="POST" action="{{ url('admin/product/store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Tên sản phẩm</label>
                        <input class="form-control w-50" type="text" name="name" id="name" value="{{ old('name') }}">
                        @error('name')
                            <small class="text-danger font-italic">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="brand">Nhãn hàng</label>
                        <select name="brand_id" id="brand" class="form-control" style="width:25%">
                            <option value="">... Chọn ...</option>
                            @foreach ($brand_list as $brand)
                                <option value="{{ $brand->id }}"
                                    {{ old('brand_id') == $brand->id ? ' selected = "selected" ' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('brand_id')
                            <small class="text-danger font-italic">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="dropzone">Ảnh</label>
                        <div class="dropzone" id="dropzone" name="images"></div>
                        @error('images')
                            <small class="text-danger font-italic">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="price">Giá</label>
                        <input class="form-control w-50" type="text" name="price" id="price" value="{{ old('price') }}">
                        @error('price')
                            <small class="text-danger font-italic">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="old_price">Giá cũ (nếu có)</label>
                        <input class="form-control w-50" type="text" name="old_price" id="old_price"
                            value="{{ old('old_price') }}">
                        @error('old_price')
                            <small class="text-danger font-italic">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="desc">Mô tả</label>
                        <textarea name="desc" class="form-control ckeditor" id="desc" cols="30"
                            rows="15">{!! old('desc') !!}</textarea>
                        @error('desc')
                            <small class="text-danger font-italic">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="details">Chi tiết sản phẩm</label>
                        <textarea name="details" class="form-control ckeditor" id="details" cols="30"
                            rows="15">{!! old('details') !!}</textarea>
                        @error('details')
                            <small class="text-danger font-italic">{{ $message }}</small>
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
                            <small class="text-danger font-italic">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="hot" name='hot'>
                            <label class="custom-control-label" for="hot">Sản phẩm nổi bật</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Thêm mới</button>
                </form>
            </div>
        </div>
    </div>
@endsection
