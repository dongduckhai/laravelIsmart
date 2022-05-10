@extends('layouts.index')
@section('content')
<div id="main-content-wp" class="cart-page">
    <div class="section" id="breadcrumb-wp">
        <div class="wp-inner">
            <div class="section-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="{{ url('/')}}" >Trang chủ</a>
                    </li>
                    <li>
                        <a href="{{ route('cart.show')}}">Giỏ hàng</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div id="wrapper" class="wp-inner clearfix">
        <div class="section" id="info-cart-wp">
            <div class="section-detail table-responsive">
            @if (Cart::count() > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <td>STT</td>
                            <td>Ảnh sản phẩm</td>
                            <td>Tên sản phẩm</td>
                            <td>Giá sản phẩm</td>
                            <td>Số lượng</td>
                            <td colspan="2">Thành tiền</td>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $count = 0;
                        @endphp
                        @foreach (Cart::content() as $row)
                            @php
                                $count++;
                            @endphp
                        <tr>
                            <td>
                                {{ $count }}
                            </td>
                            <td>
                                <a href="" class="thumb">
                                    <img src="{{ url($row->options->thumbnail) }}" alt="">
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('product.details',$row->id) }}"
                                    title="" class="name-product">
                                    {{ $row->name }}
                                </a>
                            </td>
                            <td>
                                {!! number_format($row->price, 0, '', '.') !!}đ
                            </td>
                            <td>
                                <input type="number" min="1" max="20" value="{{ $row->qty }}"  data-url="{{url('cart/update')}}"
                                    name="qty[{{ $row->rowId }}]" class="num-order" data-id="{{ $row->rowId }}">
                                <!-- sự kiện: khi thay đổi input thì data-id, data-url, value sẽ được đổ sang file js -->
                            </td>
                            <td id='sub-total-{{ $row->rowId }}'>
                                <span id="sub-total-num">
                                    {{ number_format($row->total, 0, ',', '.') }}
                                </span>
                                <span>đ</span>
                            </td>
                            <td>
                                <a href="{{ route('cart.remove', $row->rowId) }}"
                                class="del-product"><i class="fa fa-trash-o"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7">
                                <div class="clearfix">
                                    <p id="total-price" class="fl-right">Tổng giá:
                                        <span id="total-num">
                                            {{ Cart::total() }}
                                        </span>
                                        <span>đ</span>
                                    </p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="7">
                                <div class="clearfix">
                                    <div class="fl-right">
                                        <a href="{{ route('cart.destroy') }}" title="" id="destroy-all-cart">Xóa hết giỏ hàng</a>
                                        <a href="{{ route('checkout') }}" id="checkout-cart">Thanh
                                            toán</a>
                                    </div>
                                    <div class="fl-left">
                                        <a href="{{ route('index.product')}}" title="" id="buy-more-product">Tiếp tục mua hàng</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            @else
                <h1 style='font-size:20px'>Không còn sản phẩm nào trong giỏ hàng</h1>
                <img src="{{ url('public/images/search_not_found.png') }}">
            @endif
            </div>
        </div>
    </div>
</div>
@endsection
