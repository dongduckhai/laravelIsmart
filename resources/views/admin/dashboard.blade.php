@extends('layouts.admin')
@section('content')
    <div class="container-fluid py-5">
        <div class="row">
            <div class="col">
                <div class="card text-white bg-primary mb-3" style="max-width: 18rem;height: 91.5%;">
                    <div class="card-header">ĐƠN HÀNG THÀNH CÔNG</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $count[0] }}</h5>
                        <p class="card-text">Đơn hàng giao dịch thành công</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-danger mb-3" style="max-width: 18rem;height: 91.5%;">
                    <div class="card-header">ĐANG XỬ LÝ</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $count[1] }}</h5>
                        <p class="card-text">Số lượng đơn hàng đang xử lý</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-success mb-3" style="max-width: 18rem;height: 91.5%;">
                    <div class="card-header">DOANH SỐ</div>
                    <div class="card-body">
                        <h5 class="card-title"> {!! number_format($revenue, 0, '', '.') !!}đ </h5>
                        <p class="card-text">Doanh số hệ thống</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-dark mb-3" style="max-width: 18rem;height: 91.5%;">
                    <div class="card-header">ĐƠN HÀNG HỦY</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $count[2] }}</h5>
                        <p class="card-text">Số đơn bị hủy trong hệ thống</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- end analytic  -->
        <div class="card">
            <div class="card-header font-weight-bold">
                ĐƠN HÀNG MỚI
            </div>
            <div class="card-body">
                @if ($wait_orders->total() > 0)
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">STT</th>
                                <th scope="col">Mã</th>
                                <th scope="col">Khách hàng</th>
                                <th scope="col">Số điện thoại</th>
                                <th scope="col">Địa chỉ giao hàng</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Thời gian</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $count = ($wait_orders->currentpage() - 1) * $wait_orders->perpage();
                            @endphp
                            @foreach ($wait_orders as $order)
                                @php
                                    $count++;
                                @endphp
                                <tr>
                                    <th scope="row">{{ $count }}</th>
                                    <td>{{ $order->code }}</td>
                                    <td>{{ $order->name }} </td>
                                    <td>{{ $order->phone }}</td>
                                    <td>{{ $order->address }}</td>
                                    <td>
                                        @if ($order->status == 1)
                                        <span class="badge badge-warning" >
                                            Chờ duyệt
                                        </span>
                                        @elseif ($order->status == 2)
                                        <span class="badge badge-danger" >
                                            Đang giao hàng
                                        </span>
                                        @else
                                        <span class="badge badge-success" >
                                            Hoàn thành
                                        </span>
                                        @endif
                                    </td>
                                    <td>{{ date_format($order->created_at, 'd/m/Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $wait_orders->links() }}
                @else
                    <h4>Không tìm thấy kết quả nào</h4>
                    <img class="w-25" src="{{ url('public/images/search_not_found.png') }}" alt="">
                @endif
            </div>
        </div>
    </div>
@endsection
