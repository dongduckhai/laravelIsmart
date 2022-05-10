@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center"
                style="box-sizing: border-box">
                <h5 class="m-0 ">Danh sách slider</h5>
            </div>
            <div class="card-body">
                <div class="analytic">
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'all','page'=> 1]) }}"
                        class="{{ $slider_active == 'all' ? 'text-danger' : 'text-dark' }}">Tất cả
                        ({{ $count[0] }})</a>
                    {{-- chèn vào input 1 giá trị 'status' --}}
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'trash','page'=> 1]) }}"
                        class="{{ $slider_active == 'trash' ? 'text-danger' : 'text-dark' }}">Thùng rác
                        ({{ $count[1] }})</a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'wait','page'=> 1]) }}"
                        class="{{ $slider_active == 'wait' ? 'text-danger' : 'text-dark' }}">Chờ duyệt
                        ({{ $count[2] }})</a>
                </div>
                <form action="{{ url('admin/slider/action') }}" method="">
                    <div class="form-action form-inline py-3">
                        <select class="form-control mr-1" id="" name='act'>
                            <option value='NULL'>Chọn</option>
                            @foreach ($act_list as $k => $act)
                                <option value="{{ $k }}">{{ $act }}</option>
                            @endforeach
                            {{-- dropdown action menu --}}
                        </select>
                        <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-success">
                    </div>
                    @if ($sliders->total() > 0)
                        <table class="table table-striped table-checkall">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" name="checkall">
                                    </th>
                                    <th scope="col">STT</th>
                                    <th scope="col">Ảnh</th>
                                    <th scope="col">Ngày tạo</th>
                                    <th scope="col">Trạng thái</th>
                                    <th scope="col">Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $count = ($sliders->currentpage() - 1) * $sliders->perpage();
                                @endphp
                                @foreach ($sliders as $slider)
                                    @php
                                        $count++;
                                    @endphp
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="check_list[]" value="{{ $slider->id }}">
                                        </td>
                                        <td scope="row">{{ $count }}</td>
                                        <td><img style="width:100px" src="{{ url($slider->thumbnail) }}" alt=""></td>
                                        <td>{{ date_format($slider->created_at, 'd/m/Y') }}</td>
                                        <td>
                                            @if ($slider->status == 1)
                                                <span class="badge badge-warning">
                                                    Chờ duyệt
                                                </span>
                                            @elseif ($slider->status == 2)
                                                <span class="badge badge-success">
                                                    Công khai
                                                </span>
                                            @else
                                                <span class="badge badge-secondary">
                                                    Bị hủy
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($slider->status != '3')
                                            <a href="{{ route('slider.edit', $slider->id) }}"
                                                class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                                data-toggle="tooltip" data-placement="top" title="Chỉnh sửa"><i
                                                    class="fa fa-edit"></i></a>
                                            @endif
                                            <a class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                                data-toggle="modal" data-target="#deleteModal{{ $slider->id }}"
                                                data-placement="top" title="Xóa">
                                                <i class="fa fa-trash delete-btn"></i>
                                            </a>
                                            {{-- modal --}}
                                            <div class="modal fade" id="deleteModal{{ $slider->id }}" tabindex="-1"
                                                role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modalLabel">Xóa bài viết</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Bạn chắc chắn muốn xóa bài viết này ?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-dark"
                                                                data-dismiss="modal">Hủy</button>
                                                            <a href="{{ route('slider.delete', $slider->id) }}"
                                                                name="deleteData" class="btn btn-danger">Xác nhận</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- end modal --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                </form>
                {{ $sliders
                    ->appends(
                        ['status'=>$status,]
                    )
                    ->links() }}
            @else
                <h4>Không tìm thấy kết quả nào</h4>
                <img class="w-25" src="{{ url('public/images/search_not_found.png') }}" alt="">
                @endif
            </div>
        </div>
    </div>
@endsection
