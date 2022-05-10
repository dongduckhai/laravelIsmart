@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center"
                style="box-sizing: border-box">
                <h5 class="m-0 ">Danh sách bài viết</h5>
                <div class="form-inline" style="width: 43%">
                    <form action="#">
                        <input type="" class="form-control" name="keyword" autocomplete="off" placeholder="Nhập tiêu đề ..."
                            value="{{ request()->input('keyword') }}">
                        {{-- chèn vào input 1 giá trị keyword --}}
                        <select class="form-control mr-1" id="" name='cat'>
                            <option value='all'>Danh mục</option>
                            @foreach ($cat_list as $cat)
                                <option value="{{ $cat->id }}"
                                    {{ request()->input('cat') == $cat->id ? "selected='selected'" : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                            {{-- dropdown action menu --}}
                        </select>
                        <button type="submit"class="btn btn-success">Tìm kiếm</button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="analytic">
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'all','page'=> 1]) }}"
                        class="{{ $post_active == 'all' ? 'text-danger' : 'text-dark' }}">Tất cả
                        ({{ $count[0] }})</a>
                    {{-- chèn vào input 1 giá trị 'status' --}}
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'trash','page'=> 1]) }}"
                        class="{{ $post_active == 'trash' ? 'text-danger' : 'text-dark' }}">Thùng rác
                        ({{ $count[1] }})</a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'wait','page'=> 1]) }}"
                        class="{{ $post_active == 'wait' ? 'text-danger' : 'text-dark' }}">Chờ duyệt
                        ({{ $count[2] }})</a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'hot', 'page'=> 1]) }}"
                        class="{{ $post_active == 'hot' ? 'text-danger' : 'text-dark' }}">Nổi bật
                        ({{ $count[3] }})</a>
                </div>
                <form action="{{ url('admin/post/action') }}" method="">
                    <div class="form-action form-inline py-3">
                        <select class="form-control mr-1" id="" name='act'>
                            <option value='NULL'>Chọn</option>
                            @foreach ($act_list as $k => $act)
                                <option value="{{ $k }}">{{ $act }}</option>
                            @endforeach
                            {{-- dropdown action menu --}}
                        </select>
                        <input type="submit" value="Áp dụng" class="btn btn-success">
                    </div>
                    @if ($posts->total() > 0)
                        <table class="table table-striped table-checkall">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" name="checkall">
                                    </th>
                                    <th scope="col">STT</th>
                                    <th scope="col">Ảnh</th>
                                    <th scope="col">Tiêu đề</th>
                                    <th scope="col">Danh mục</th>
                                    <th scope="col">Ngày tạo</th>
                                    <th scope="col">Trạng thái</th>
                                    <th scope="col">Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $count = ($posts->currentpage() - 1) * $posts->perpage();
                                @endphp
                                @foreach ($posts as $post)
                                    @php
                                        $count++;
                                    @endphp
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="check_list[]" value="{{ $post->id }}">
                                        </td>
                                        <td scope="row">{{ $count }}</td>
                                        <td><img style="width:100px" src="{{ url($post->thumbnail) }}" alt=""></td>
                                        <td>{{ $post->title }}</td>
                                        <td>{{ $post->cat->name }}</td>
                                        <td>{{ date_format($post->created_at, 'd/m/Y') }}</td>
                                        <td>
                                            @if ($post->status == 1)
                                                <span class="badge badge-warning">
                                                    Chờ duyệt
                                                </span>
                                            @elseif ($post->status == 2)
                                                <span class="badge badge-success">
                                                    Công khai
                                                </span>
                                            @else
                                                <span class="badge badge-secondary">
                                                    Bị hủy
                                                </span>
                                            @endif
                                            <span class="badge {{ $post->hot == 'On' ? 'badge-danger' : '' }} ">
                                                {{ $post->hot == 'On' ? 'Nổi bật' : '' }}
                                            </span>
                                        </td>
                                        <td>
                                            @if ($post->status != '3')
                                            <a href="{{ route('post.edit', $post->id) }}"
                                                class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                                data-toggle="tooltip" data-placement="top" title="Chỉnh sửa"><i
                                                    class="fa fa-edit"></i></a>
                                            @endif
                                            <a class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                                data-toggle="modal" data-target="#deleteModal{{ $post->id }}"
                                                data-placement="top" title="Xóa">
                                                <i class="fa fa-trash delete-btn" style="width:15.75px"></i>
                                            </a>
                                            {{-- modal --}}
                                            <div class="modal fade" id="deleteModal{{ $post->id }}" tabindex="-1"
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
                                                            <a href="{{ route('post.delete', $post->id) }}"
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
                {{ $posts
                    ->appends(
                        ['status'=>$status,
                        'keyword'=>$keyword,
                        'cat'=>$cat_id,
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
