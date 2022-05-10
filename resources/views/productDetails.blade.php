@extends('layouts.index')
@section('content')
    <div id="main-content-wp" class="clearfix detail-product-page">
        <div class="wp-inner">
            <div class="secion" id="breadcrumb-wp">
                <div class="secion-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="{{ url('/') }}">Trang chủ</a>
                        </li>
                        <li>
                            <a href="{{ route('index.product') }}">Sản phẩm</a>
                        </li>
                        <li>
                            <a href="{{ route('index.cat.product', $product->cat_id) }}">
                                {{ $product->cat->name }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('index.brand.product', $product->brand_id) }}">
                                {{ $product->brand->name }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="main-content fl-right">
                <div class="section" id="detail-product-wp">
                    <div class="section-detail clearfix">
                        <div class="thumb-wp fl-left">
                            <a href="" title="" id="main-thumb">
                                <img style="width:350px;height:auto;" id="zoom" src="{{ url($product->thumbnail) }}"
                                    data-zoom-image="{{ url($product->thumbnail) }}" />
                            </a>
                        </div>
                        <div class="info fl-right">
                            <h3 class="product-name">{{ $product->name }}</h3>
                            <div class="desc">
                                {!! $product->desc !!}
                            </div>
                            @if ($product->hot == 'On')
                                <div class="num-product">
                                    <span class="title">Sản phẩm: </span>
                                    <span class="status">HOT</span>
                                </div>
                            @endif
                            <form action="{{ route('cart.add', $product->id) }}" method="GET">
                                @csrf
                                <div id="num-order-wp">
                                    <a title="" id="minus"><i class="fa fa-minus"></i></a>
                                    <input type="text" name="qty" value="1" id="num-order">
                                    <a title="" id="plus"><i class="fa fa-plus"></i></a>
                                </div>
                                <p class="price">
                                    {!! number_format($product->price, 0, '', '.') !!}đ
                                </p>
                                <button type='submit' class="add-cart">Thêm giỏ hàng</button>
                        </div>
                    </div>
                </div>
                <div class="section" id="post-product-wp">
                    <div class="section-head">
                        <h3 class="section-title">Mô tả sản phẩm</h3>
                    </div>
                    <div class="section-detail">
                        {!! $product->details !!}
                    </div>
                </div>
                <div class="section" id="feature-product-wp">
                    <div class="section-head">
                        <h3 class="section-title">Cùng chuyên mục</h3>
                    </div>
                    <div class="section-detail">
                        <ul class="list-item">
                            @foreach ($same_brand_products as $same_product)
                                @if ($same_product->id == $product->id)
                                    @php continue; @endphp
                                @endif
                                <li class="h-308">
                                    <a href="{{ route('product.details', $same_product->id) }}" title="Chi tiết"
                                        class="thumb">
                                        <img class="thumb-img" src="{{ url($same_product->thumbnail) }}">
                                    </a>
                                    <a href="{{ route('product.details', $same_product->id) }}" title=""
                                        class="product-name h-33">
                                        {{ $same_product->name }}
                                    </a>
                                    <div class="price">
                                        <span class="new">
                                            {!! number_format($same_product->price, 0, '', '.') !!}đ
                                        </span>
                                        @if ($same_product->old_price != null)
                                            <span class="old">
                                                {!! number_format($same_product->price, 0, '', '.') !!}đ
                                            </span>
                                        @endif
                                    </div>
                                    <div class="action clearfix">
                                        <a href="{{ route('cart.add',$same_product->id) }}" title="Thêm giỏ hàng" class="add-cart fl-left">Thêm
                                            giỏ hàng</a>
                                        <a href="{{ route('product.details', $same_product->id) }}"
                                            title="Chi tiết sản phẩm" class="buy-now fl-right">Thông tin</a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            {{-- sidebar danh mục --}}
            <div class="sidebar fl-left">
                <div class="section" id="category-product-wp">
                    <div class="section-head">
                        <h3 class="section-title">Danh mục sản phẩm</h3>
                    </div>
                    <div class="secion-detail">
                        <ul class="list-item">
                            @foreach ($cats as $cat)
                                <li>
                                    <a href="{{ route('index.cat.product', $cat->id) }}">{{ $cat->name }}</a>
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
                            @foreach ($hot_products as $hot_product)
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
                                            @if ($hot_product->old_price != null)
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
                            <img src="{{ url('public/images/banner-2.png') }}" alt="">
                        </a>
                    </div>
                </div>
            </div>
            {{-- end sidebar hot product --}}
        </div>
    </div>
@endsection
