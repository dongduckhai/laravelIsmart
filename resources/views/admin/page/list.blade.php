@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Danh sách trang</h5>
                <div class="form-search form-inline">
                    <form action="#">
                        <input type="" class="form-control form-search" name="keyword" autocomplete="off"
                            placeholder="Nhập tiêu đề ..." value="{{ request()->input('keyword') }}">
                        {{-- chèn vào input 1 giá trị keyword --}}
                        <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-success">
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="analytic">
                    <a id="count" href="{{ request()->fullUrlWithQuery(['status' => 'all', 'page' => 1]) }}"
                        class="{{ $page_active == 'all' ? 'text-danger' : 'text-dark' }}">Tất cả({{ $count[0] }})</a>
                    {{-- chèn vào input 1 giá trị 'status' --}}
                    <a id="trashCount" href="{{ request()->fullUrlWithQuery(['status' => 'trash', 'page' => 1]) }}"
                        class="{{ $page_active == 'trash' ? 'text-danger' : 'text-dark' }}">Thùng
                        rác({{ $count[1] }})</a>
                </div>
                <form action="{{ url('admin/page/action') }}" method="">
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
                    @if ($pages->total() > 0)
                        <table class="table table-striped table-checkall">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" name="checkall">
                                    </th>
                                    <th scope="col">STT</th>
                                    <th scope="col">Tiêu đề</th>
                                    <th scope="col">Trạng thái</th>
                                    <th scope="col">Ngày tạo</th>
                                    <th scope="col">Nổi bật</th>
                                    <th scope="col">Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $count = ($pages->currentpage() - 1) * $pages->perpage();
                                @endphp
                                @foreach ($pages as $page)
                                    @php
                                        $count++;
                                    @endphp
                                    <tr id="tr-{{ $page->id }}">
                                        <td>
                                            <input type="checkbox" name="check_list[]" value="{{ $page->id }}">
                                        </td>
                                        <td scope="row">{{ $count }}</td>
                                        <td>{{ $page->title }}</td>
                                        <td>
                                            <select name="status" data-id={{ $page->id }} class="form-control custom-select custome-select-sm" style="width:8rem">
                                                <option value="1" {{ $page->status == 1 ? 'selected' : '' }}>Công khai</option>
                                                <option value="2" {{ $page->status == 2 ? 'selected' : '' }}>Bị hủy</option>
                                            </select>
                                        </td>
                                        <td>{{ date_format($page->created_at, 'd/m/Y') }}</td>
                                        <td>
                                            @if ($page->status == '2')
                                            <div class="rounded-circle btn btn-secondary btn-sm">
                                                <i class="fas fa-minus"></i>
                                            </div>
                                            @elseif ($page->hot == 'On')
                                            <a class="hot-{{ $page->id}} rounded-circle btn btn-success btn-sm" href="javascript:changeHot( '{{$page->id}}', '{{$page->hot}}' )">
                                                <i class="fas fa-check"></i>
                                            </a>
                                            @elseif ($page->hot == 'Off')
                                            <a class="hot-{{ $page->id}} rounded-circle btn btn-danger btn-sm" href="javascript:changeHot( '{{$page->id}}', '{{$page->hot}}' )">
                                                <i class="fas fa-minus"></i>
                                            </a>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($page->status != '2')
                                                <a href="{{ route('page.edit', $page->id) }}"
                                                    class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Chỉnh sửa">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            @endif
                                            <a class="btn btn-danger btn-sm rounded-0 text-white" type="button" title="Xóa"
                                                href="javascript:Delete('{{ url('admin/page/delete', $page->id) }} ')">
                                                <i class="fa fa-trash delete-btn" style="width:15.75px"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                </form>
                {{ $pages->appends(['status' => $status, 'keyword' => $keyword])->links() }}
            @else
                <h4>Không tìm thấy kết quả nào</h4>
                <img class="w-25" src="{{ url('public/images/search_not_found.png') }}" alt="">
                @endif
            </div>
        </div>
    </div>
@endsection
