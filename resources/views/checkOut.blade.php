@extends('layouts.index')
@section('content')
    <div id="main-content-wp" class="checkout-page">
        <div class="section" id="breadcrumb-wp">
            <div class="wp-inner">
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="{{ url('/') }}" title="Trang chủ">Trang chủ</a>
                        </li>
                        <li>
                            <a href="" title="Thanh toán">Thanh toán</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="wrapper" class="wp-inner clearfix">
            <form method="POST" action="{{ route('order.store') }}" name="form-checkout">
                <div class="section" id="customer-info-wp">
                    <div class="section-head">
                        <h1 class="section-title">Thông tin khách hàng</h1>
                    </div>
                    <div class="section-detail">
                        <div class="form-row clearfix">
                            <div class="form-col fl-left">
                                <label for="name">Họ tên</label>
                                <input type="text" name="name" id="name" autocomplete="off" value="{{ old('name') }}">
                                @error('name')
                                    <small style="text:red;font-style:italic">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row clearfix">
                            <div class="form-col fl-left">
                                <label for="phone">Số điện thoại</label>
                                <input type="tel" name="phone" id="phone" autocomplete="off" value="{{ old('phone') }}">
                                @error('phone')
                                    <small class="text-danger font-italic">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row clearfix">
                            <div class="form-col fl-left">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}">
                                @error('email')
                                    <small class="text-danger font-italic">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row clearfix">
                            <div class="form-col fl-left">
                                <label for="address">Địa chỉ</label>
                                <div class="fl-left" style="width:47%">
                                    <input type="text" name="house" id="address" autocomplete="off" value=""
                                        placeholder="Số nhà, đường ...">
                                    @error('house')
                                        <small class="text-danger font-italic">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="fl-right" style="width:47%">
                                    <select name="province" class="dynamic" data-dependent="districts"
                                        id="provinces">
                                        <option value="">Tỉnh / Thành phố</option>
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->code }}">{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('province')
                                        <small class="text-danger font-italic">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-row clearfix">
                            <div class="form-col fl-left">
                                <div class="fl-left" style="width:47%">
                                    <select name="district" class="dynamic" data-dependent="wards"
                                        id="districts">
                                        <option value="">Quận / Huyện</option>
                                    </select>
                                    @error('district')
                                        <small class="text-danger font-italic">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="fl-right" style="width:47%">
                                    <select name="ward" id="wards">
                                        <option value="">Phường / Xã</option>
                                    </select>
                                    {{ csrf_field() }}
                                    @error('ward')
                                        <small class="text-danger font-italic">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-col">
                                <label for="note">Ghi chú</label>
                                <textarea id="note" name="note" style="width:100%;height:120px">
                                    {{ old('note') }}
                                </textarea>
                                @error('note')
                                <small class="text-danger font-italic">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                @if (Cart::count() > 0)
                    <div class="section" id="order-review-wp">
                        <div class="section-head">
                            <h1 class="section-title">Thông tin đơn hàng</h1>
                        </div>
                        <div class="section-detail">
                            <table class="shop-table">
                                <thead>
                                    <tr>
                                        <td>Sản phẩm</td>
                                        <td>Tổng</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (Cart::content() as $row)
                                        <tr class="cart-item">
                                            <td class="product-name">
                                                {{ $row->name }}
                                                <strong class="product-quantity">
                                                    x {{ $row->qty }}
                                                </strong>
                                            </td>
                                            <td class="product-total">
                                                {!! number_format($row->total, 0, '', '.') !!}đ
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="order-total">
                                        <td>Tổng đơn hàng:</td>
                                        <td>
                                            <strong class="total-price">
                                                {{ Cart::total() }}
                                            </strong>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            <div id="payment-checkout-wp">
                                <ul id="payment_methods">
                                    <li>
                                        <input type="radio" id="direct-payment" name="payment" value="1">
                                        <label for="direct-payment">Chuyển khoản ngân hàng</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="payment-home" name="payment" value="2">
                                        <label for="payment-home">Thanh toán tại nhà</label>
                                    </li>
                                    @error('payment')
                                        <small class="text-danger font-italic">{{ $message }}</small>
                                    @enderror
                                </ul>
                            </div>
                        </div>
                    </div>
                @else
                    <h2>Không còn sản phẩm nào trong giỏ hàng</h2>
                    <img src="public/images/search_not_found.png" alt="Không có sản phẩm nào trong giỏ hàng">
                @endif
                <div class="place-order-wp clearfix">
                    <input type="submit" id="order-now" name="btn-order" value="Đặt hàng">
                </div>
            </form>
        </div>
    </div>
@endsection
