@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">

        <div class="row">
            <div class="col-5">
                <div class="card">
                    <div class="card-header">
                        <h5>Thông tin đơn hàng</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="title">
                                    <i class="fas fa-barcode text-primary mr-1"></i>
                                    <strong>Mã đơn hàng</strong>
                                </div>
                                <div class="content mt-2">
                                    {{$order->code}}
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="title">
                                    <i class="fas fa-cash-register text-primary mr-1"></i>
                                    <strong>Hình thức thanh toán</strong>
                                </div>
                                <div class="content mt-2">
                                    {{ $order->payment == 1? 'Chuyển khoản ngân hàng' : 'Thanh toán tại nhà'}}
                                </div>
                            </div>
                            <div class="col-6 mt-3">
                                <div class="title">
                                    <i class="fas fa-map-marked-alt text-primary mr-1"></i>
                                    <strong>Địa chỉ nhận</strong>
                                </div>
                                <div class="content mt-2">
                                    {{ $order->address }}
                                </div>
                            </div>

                            <div class="col-6 mt-3">
                                <div class="title">
                                    <i class="fas fa-shipping-fast text-primary mr-1"></i>
                                    <strong>Trạng thái đơn hàng</strong>
                                </div>
                                <div class="content mt-2">
                                    <form action="{{ route('order.update',$order->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="list_check[]" value="">
                                        <div class="input-group">
                                            <select class="custom-select" name="status" id="status">
                                                <option value="1" {{$order->status == 1? "selected ='selected' ":""}}>Chờ Duyệt
                                                </option>
                                                <option value="2" {{$order->status == 2? "selected ='selected' ":""}}>Đang vận chuyển
                                                </option>
                                                <option value="3" {{$order->status == 3? "selected ='selected' ":""}}>Hoàn thành
                                                </option>
                                                <option value="4">Hủy
                                                </option>
                                            </select>
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-primary">Cập nhật</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-4">
                <div class="card" style="height:100%">
                    <div class="card-header">
                        <h5>Thông tin khách hàng</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="title">
                                    <i class="fas fa-user text-primary mr-1"></i>
                                    <strong>Tên khách hàng</strong>
                                </div>
                                <div class="content mt-1">
                                    {{ $order->name }}
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="title">
                                    <i class="fas fa-phone-volume text-primary mr-1"></i>
                                    <strong>Số điện thoại</strong>
                                </div>
                                <div class="content mt-1 text-center">
                                    {{ $order->phone }}
                                </div>
                            </div>

                            <div class="col-12 mt-3">
                                <div class="title">
                                    <i class="fas fa-at text-primary mr-1"></i>
                                    <strong>Email </strong><span class="float-right">{{ $order->email }}</span>
                                </div>
                            </div>

                            <div class="col-12 mt-2">
                                <div class="title">
                                    <i class="fas fa-comment text-primary mr-1"></i>
                                    <strong>Ghi Chú</strong>
                                </div>
                                <div class="content mt-1">
                                    {{ $order->note }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-3">
                <div class="card">
                    <div class="card-header">
                        <h5>Tổng giá trị đơn hàng</h5>
                    </div>
                    <div class="card-body">
                        <div class="section">
                            <strong>Tổng số sản phẩm:</strong><span class="ml-2">{{ $order->qty }}</span>
                        </div>
                        <div class="section">
                            <strong class="text-danger">
                                Tổng giá trị:
                            </strong>
                            <span class="text-danger font-weight-bold ml-2">
                                {!! number_format($order->total, 0, '', '.') !!}VNĐ
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Danh sách sản phẩm</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-checkall">
                            <thead>
                                <tr>
                                    <th scope="col">STT</th>
                                    <th scope="col">Ảnh</th>
                                    <th scope="col">Tên sản phẩm</th>
                                    <th scope="col">Giá</th>
                                    <th scope="col">Số lượng</th>
                                    <th scope="col">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $count = 0;
                                @endphp
                                @foreach ($products as $product)
                                    @php
                                        $count++;
                                    @endphp
                                <tr>
                                    <td>{{ $count }}</td>
                                    <td>
                                        <img src="{{ url($product->thumbnail) }}" style="max-width:100px" alt="">
                                    </td>
                                    <td>{{ $product->name }}</td>
                                    <td>{!! number_format($product->price, 0, '', '.') !!}đ</td>
                                    <td>{{ $product->pivot->qty}}</td>
                                    @php
                                        $sub_total = $product->pivot->qty * $product->price
                                    @endphp
                                    <td>{!! number_format($sub_total, 0, '', '.') !!}đ</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
