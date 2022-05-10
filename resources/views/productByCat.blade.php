@extends('layouts.index')
@section('content')
<div id="main-content-wp" class="home-page clearfix">
    <div class="wp-inner">
        <div class="secion" id="breadcrumb-wp">
            <div class="secion-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="{{ url('/') }}" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="{{ route('index.product')}}" title="">Sản phẩm</a>
                    </li>
                    <li>
                        <a href="">{{ $cat->name }}</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-content fl-right">
            {{-- product list --}}
            <div class="section" id="list-product-wp">
                @foreach ($brands as $brand)
                    <div class="section-head clearfix">
                        <h3 class="section-title fl-left">{{ $brand->name }}</h3></h3>
                        <a href="{{ route('index.brand.product',$brand->id) }}" class="show-all fl-right">Xem tất cả: {{ $count["{$brand->id}"] }} sản phẩm</a>
                    </div>
                    <div class="section-detail">
                        <ul class="list-item clearfix">
                            @foreach ($products["{$brand->id}"] as $product)
                                <li class="h-308">
                                    <a href="{{ route('product.details', $product->id) }}" class="thumb">
                                        <img class="thumb-img" src="{{ url($product->thumbnail) }}">
                                    </a>
                                    <a href="{{ route('product.details', $product->id) }}" class="product-name h-33">
                                        {{ $product->name }}
                                    </a>
                                    <div class="price">
                                        <span class="new">
                                            {!! number_format($product->price, 0, '', '.') !!}đ
                                        </span>
                                        <span class="old">
                                            @if ($product->old_price != NULL)
                                            {!! number_format($product->old_price, 0, '', '.') !!}đ
                                            @endif
                                        </span>
                                    </div>
                                    <div class="action clearfix">
                                        <a href="#" title="Thêm giỏ hàng" class="add-cart fl-left"
                                        data-url="{{ route('cart.ajax',$product->id) }}">
                                            Thêm giỏ hàng
                                        </a>
                                        <a href="{{ route('product.details', $product->id) }}" title="Thông tin chi tiết" class="buy-now fl-right">Thông tin</a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
            <!-- endProduct -->
        </div>
        {{-- sidebar danh mục --}}
        <div class="sidebar fl-left">
            <div class="section" id="category-product-wp">
                <div class="section-head">
                    <h3 class="section-title">Danh mục sản phẩm</h3>
                </div>
                <div class="secion-detail">
                    <ul class="list-item">
                    @foreach($cats as $cat)
                        <li>
                            <a href="{{ route('index.cat.product',$cat->id) }}">{{ $cat->name}}</a>
                        </li>
                    @endforeach
                    </ul>
                </div>
            </div>
        </div>
        {{-- end sidebar danh mục --}}
        {{-- sidebar hot product --}}
        <div class="sidebar fl-left">
            <div class="section" id="selling-wp">
                <div class="section-head">
                    <h3 class="section-title">Sản phẩm bán chạy</h3>
                </div>
                <div class="section-detail">
                    <ul class="list-item">
                    @foreach($hot_products as $hot_product)
                        <li class="clearfix">
                            <a href="{{ route('product.details',$hot_product->id) }}" class="thumb fl-left">
                                <img src="{{ url($hot_product->thumbnail) }}">
                            </a>
                            <div class="info fl-right">
                                <a href="{{ route('product.details',$hot_product->id) }}" class="product-name">
                                    {{ $hot_product->name }}
                                </a>
                                <div class="price">
                                    <span class="new">
                                        {!! number_format($hot_product->price, 0, '', '.') !!}đ
                                    </span>
                                    @if($hot_product->old_price != NULL)
                                    <span class="old">
                                        {!! number_format($hot_product->old_price, 0, '', '.') !!}đ
                                    </span>
                                    @endif
                                </div>
                                <a href="{{ route('cart.add',$hot_product->id) }}" title="Mua ngay" class="buy-now">Mua ngay</a>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="section" id="banner-wp">
                <div class="section-detail">
                    <a href="" class="thumb">
                        <img src="{{ url('public/images/banner-2.png')}}" alt="">
                    </a>
                </div>
            </div>
        </div>
        {{-- end sidebar hot product --}}
    </div>
</div>
@endsection
