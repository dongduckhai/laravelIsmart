@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Cập nhật slider
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('slider.update', $slider->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="file">Ảnh</label>
                    <input class="form-control-file" type="file" name="file" id="thumbnail">
                    <img class="w-25 mt-2" src="{{url($slider->thumbnail)}}">
                @error('file')
                    <small class="text-danger font-italic">{{$message}}</small>
                @enderror
                </div>
                <div class="form-group">
                    <label>Trạng thái</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="status1" value="1"
                        {{ $slider->status == '1' ? 'checked' :''}}>
                        <label class="form-check-label" for="status1">Chờ duyệt</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="status2" value="2"
                        {{ $slider->status == '2' ? 'checked' :''}}>
                        <label class="form-check-label" for="status2">Công khai</label>
                    </div>
                @error('status')
                    <small class="text-danger font-italic">{{$message}}</small>
                @enderror
                </div>
                <button type="submit" class="btn btn-success">Cập nhật</button>
            </form>
        </div>
    </div>
</div>
@endsection
