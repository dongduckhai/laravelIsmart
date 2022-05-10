@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Danh sách danh mục</h5>
                <div class="form-search form-inline">
                    <form action="#">
                        <input type="" class="form-control form-search" name="keyword" autocomplete="off"
                            placeholder="Nhập tên danh mục ..." value="{{ request()->input('keyword') }}">
                        {{-- chèn vào input 1 giá trị keyword --}}
                        <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-success">
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="analytic">
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'all','page'=> 1]) }}"
                        class="{{ $cat_active == 'all' ? 'text-danger' : 'text-dark' }}">Tất cả({{ $count[0] }})</a>
                    {{-- chèn vào input 1 giá trị 'status' --}}
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'wait','page'=> 1]) }}"
                        class="{{ $cat_active == 'wait' ? 'text-danger' : 'text-dark' }}">Chờ duyệt({{ $count[1] }})</a>
                </div>
                <form action="{{ url('admin/cat/action') }}" method="">
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
                    @if ($cats->total() > 0)
                        <table class="table table-striped table-checkall">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" name="checkall">
                                    </th>
                                    <th scope="col">STT</th>
                                    <th scope="col">Tên danh mục</th>
                                    <th scope="col">Trạng thái</th>
                                    <th scope="col">Ngày tạo</th>
                                    <th scope="col">Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $count = ($cats->currentpage() - 1) * $cats->perpage();
                                @endphp
                                @foreach ($cats as $cat)
                                    @php
                                        $count++;
                                    @endphp
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="check_list[]" value="{{ $cat->id }}">
                                        </td>
                                        <th scope="row">{{ $count }}</th>
                                        <td>{{ $cat->name }}</td>
                                        <td>
                                            @if ($cat->status == 1)
                                                <span class="badge badge-success">
                                                    Công khai
                                                </span>
                                            @else
                                                <span class="badge badge-warning">
                                                    Chờ duyệt
                                                </span>
                                            @endif
                                        </td>
                                        <td>{{ date_format($cat->created_at,"d/m/Y") }}</td>
                                        <td>
                                            <a href="{{ route('cat.edit', $cat->id) }}"
                                                class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                                data-toggle="tooltip" data-placement="top" title="Chỉnh sửa"><i
                                                    class="fa fa-edit"></i></a>
                                            <a class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                                data-toggle="modal" data-target="#deleteModal{{$cat->id}}" data-placement="top"
                                                title="Xóa">
                                                <i class="fa fa-trash delete-btn" style="width:15.75px"></i>
                                            </a>
                                            {{-- modal --}}
                                            <div class="modal fade" id="deleteModal{{$cat->id}}" tabindex="-1" role="dialog"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modalLabel">Xóa danh mục</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Bạn chắc chắn muốn xóa danh mục này ?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-dark"
                                                                data-dismiss="modal">Hủy</button>
                                                            <a href="{{ route('cat.delete', $cat->id) }}"
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
                {{ $cats
                    ->appends(
                        ['status'=>$status,
                        'keyword'=>$keyword,
                        ]
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
