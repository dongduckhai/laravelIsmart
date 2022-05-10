@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center"
                style="box-sizing: border-box">
                <h5 class="m-0 ">Danh sách đơn hàng</h5>
                <div class="form-inline" style="width: 50%">
                    <form action="#">
                        <input type="" class="form-control" name="customer" autocomplete="off"
                            placeholder="Nhập tên khách hàng ..." value="{{ request()->input('customer') }}">
                        {{-- chèn vào input 1 giá trị keyword --}}
                        <input type="" class="form-control" name="code" autocomplete="off"
                            placeholder="Nhập mã đơn hàng ..." value="{{ request()->input('code') }}">
                        <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-success">
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="analytic">
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'all','page'=> 1]) }}"
                        class="{{ $order_active == 'all' ? 'text-danger' : 'text-dark' }}">Tất cả
                        ({{ $count[0] }})</a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'trash','page'=> 1]) }}"
                        class="{{ $order_active == 'trash' ? 'text-danger' : 'text-dark' }}">Thùng rác
                        ({{ $count[1] }})</a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'wait','page'=> 1]) }}"
                        class="{{ $order_active == 'wait' ? 'text-danger' : 'text-dark' }}">Chờ duyệt
                        ({{ $count[2] }})</a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'onTheWay','page'=> 1]) }}"
                        class="{{ $order_active == 'onTheWay' ? 'text-danger' : 'text-dark' }}">Đang vận chuyển
                        ({{ $count[3] }})</a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'complete','page'=> 1]) }}"
                        class="{{ $order_active == 'complete' ? 'text-danger' : 'text-dark' }}">Hoàn thành
                        ({{ $count[4] }})</a>
                </div>
                <form action="{{ url('admin/order/action') }}" method="">
                    <div class="form-action form-inline py-3">
                        @if ($order_active != 'complete')
                            <select class="form-control mr-1" id="" name='act'>
                                <option value='NULL'>Chọn</option>
                                @foreach ($act_list as $k => $act)
                                    <option value="{{ $k }}">{{ $act }}</option>
                                @endforeach
                            </select>
                            <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-success">
                        @endif
                    </div>
                    @if ($orders->total() > 0)
                        <table class="table table-striped table-checkall">
                            <thead>
                                <tr>
                                    @if($order_active != 'complete')
                                    <th>
                                        <input type="checkbox" name="checkall">
                                    </th>
                                    @endif
                                    <th scope="col">STT</th>
                                    <th scope="col">Mã</th>
                                    <th scope="col">Khách hàng</th>
                                    <th scope="col">Số điện thoại</th>
                                    <th scope="col">Địa chỉ giao hàng</th>
                                    <th scope="col">Trạng thái</th>
                                    <th scope="col">Thời gian</th>
                                    <th scope="col">Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $count = ($orders->currentpage() - 1) * $orders->perpage();
                                @endphp
                                @foreach ($orders as $order)
                                    @php
                                        $count++;
                                    @endphp
                                    <tr>
                                        @if($order_active != 'complete')
                                        <td>
                                            <input type="checkbox" name="check_list[]" value="{{ $order->id }}">
                                        </td>
                                        @endif
                                        <td scope="row">{{ $count }}</td>
                                        <td>{{ $order->code }}</td>
                                        <td>{{ $order->name }}</td>
                                        <td>{{ $order->phone }}</td>
                                        <td>{{ $order->address }}</td>
                                        <td>
                                            @if ($order->status == 1)
                                                <span class="badge badge-warning">
                                                    Chờ duyệt
                                                </span>
                                            @elseif ($order->status == 2)
                                                <span class="badge badge-primary">
                                                    Đang vận chuyển
                                                </span>
                                            @elseif ($order->status == 3)
                                                <span class="badge badge-success">
                                                    Hoàn thành
                                                </span>
                                            @else
                                                <span class="badge badge-secondary">
                                                    Bị hủy
                                                </span>
                                            @endif
                                        </td>
                                        <td>{{ date_format($order->created_at, 'd/m/Y') }}</td>

                                        <td>
                                            @if ($order->status != '4')
                                                <a href="{{ route('order.edit', $order->id) }}"
                                                    class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Chỉnh sửa"><i
                                                        class="fa fa-edit"></i></a>
                                            @endif
                                            <a class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                                data-toggle="modal" data-target="#deleteModal{{ $order->id }}"
                                                data-placement="top" title="Hủy đơn hàng">
                                                <i class="fa fa-trash delete-btn" style="width:15.75px"></i>
                                            </a>
                                            {{-- modal --}}
                                            <div class="modal fade" id="deleteModal{{ $order->id }}" tabindex="-1"
                                                role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modalLabel">Hủy đơn hàng</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Bạn chắc chắn muốn hủy đơn hàng này ?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-dark"
                                                                data-dismiss="modal">Hủy</button>
                                                            <a href="{{ route('order.delete', $order->id) }}"
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
                {{ $orders
                    ->appends(
                        ['status'=>$status,
                        'customer'=>$customer,
                        'code'=>$code,
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
