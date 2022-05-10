<!DOCTYPE html>
<html>

<head>
    <title>ISMART STORE</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/ico" href="{{ url('public/images/ismart.ico') }}" />
    <link href="{{ url('public/css/bootstrap/bootstrap-theme.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('public/css/bootstrap/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('public/reset.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('public/css/carousel/owl.carousel.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('public/css/carousel/owl.theme.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('public/css/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('public/style.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('public/responsive.css') }}" rel="stylesheet" type="text/css" />

    <div id="fb-root"></div>

</head>

<body>
    <div id="site">
        <div id="container">
            <div id="header-wp">
                <div id="head-top" class="clearfix">
                    <div class="wp-inner">
                        <div id="main-menu-wp" class="fl-right">
                            <ul id="main-menu" class="clearfix">
                                <li>
                                    <a href="{{ route('index.home') }}" title="">Trang chủ</a>
                                </li>
                                <li>
                                    <a href="{{ route('index.product') }}" title="">Sản phẩm</a>
                                </li>
                                <li>
                                    <a href="{{ route('index.blog') }}" title="">Blog</a>
                                </li>
                                <li>
                                    <a href="{{ route('index.page', 1) }}" title="">Giới thiệu</a>
                                </li>
                                <li>
                                    <a href="{{ route('index.page', 2) }}" title="">Hỏi đáp</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="head-body" class="clearfix">
                    <div class="wp-inner">
                        <a href="{{ url('/') }} " title="" id="logo" class="fl-left"><img
                                src="{{ url('public/images/logo.png') }}" /></a>
                        <div id="search-wp" class="fl-left">
                            <form class="form-search" method="GET" action="{{ route('index.search') }}">
                                <input type="text" name="keyword" id="s" class=""
                                    placeholder="Nhập từ khóa tìm kiếm tại đây!" autocomplete="off">
                                <button type="submit" id="sm-s">Tìm kiếm</button>
                                <div id="data-list"></div>
                            </form>
                            {{ csrf_field() }}
                        </div>
                        <div id="action-wp" class="fl-right">
                            <div id="advisory-wp" class="fl-left">
                                <span class="title">Tư vấn</span>
                                <span class="phone">0987.654.321</span>
                            </div>
                            <div id="cart-wp" class="fl-right">
                                <a href="{{ route('cart.show') }}" id="btn-cart" style="color:#fdfafa">
                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                    @if (Cart::count() > 0)
                                        <span id="num">{{ Cart::count() }}</span>
                                    @endif
                                </a>
                                @if (Cart::count() > 0)
                                    <div id="dropdown">
                                        <p class="desc">
                                            Có <span>{{ Cart::count() }}</span> sản phẩm trong giỏ hàng
                                        </p>
                                        <ul class="list-cart">
                                            @foreach (Cart::content() as $row)
                                                <li class="clearfix">
                                                    <a href="{{ route('product.details', $row->id) }}"
                                                        class="thumb fl-left">
                                                        <img src="{{ url($row->options->thumbnail) }}" alt="">
                                                    </a>
                                                    <div class="info fl-right">
                                                        <a href="{{ route('product.details', $row->id) }}"
                                                            class="product-name">
                                                            {{ $row->name }}
                                                        </a>
                                                        <p class="price">
                                                            {!! number_format($row->price, 0, '', '.') !!}đ
                                                        </p>
                                                        <p class="qty">Số lượng: <span>{{ $row->qty }}</span></p>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="total-price clearfix">
                                            <p class="title fl-left">Tổng:</p>
                                            <p class="price fl-right">{{ Cart::total() }}đ</p>
                                        </div>
                                        <div class="action-cart clearfix">
                                            <a href="{{ route('cart.show') }}" title="Giỏ hàng"
                                                class="view-cart fl-left">
                                                Giỏ hàng
                                            </a>
                                            <a href="{{ route('checkout') }}" title="Thanh toán"
                                                class="checkout fl-right">
                                                Thanh toán
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                {{-- main content --}}
                @yield('content');
            </div>
            <div id="footer-wp">
                <div id="foot-body">
                    <div class="wp-inner clearfix">
                        <div class="block" id="info-company">
                            <h3 class="title">ISMART</h3>
                            <p class="desc">ISMART luôn cung cấp luôn là sản phẩm chính hãng có thông tin rõ ràng, chính
                                sách ưu đãi cực lớn cho khách hàng có thẻ thành viên.</p>
                            <div id="payment">
                                <div class="thumb">
                                    <img src="public/images/img-foot.png" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="block menu-ft" id="info-shop">
                            <h3 class="title">Thông tin cửa hàng</h3>
                            <ul class="list-item">
                                <li>
                                    <p>37 - Âu Cơ - Tân Bình - tp HCM</p>
                                </li>
                                <li>
                                    <p>0987.654.321 - 0989.989.989</p>
                                </li>
                                <li>
                                    <p>ISMART@gmail.com</p>
                                </li>
                            </ul>
                        </div>
                        <div class="block menu-ft policy" id="info-shop">
                            <h3 class="title">Chính sách mua hàng</h3>
                            <ul class="list-item">
                                <li>
                                    <a href="{{ route('index.page', 3) }}">Quy định - chính sách</a>
                                </li>
                                <li>
                                    <a href="{{ route('index.page', 4) }}">Chính sách bảo hành - đổi trả</a>
                                </li>
                                <li>
                                    <a href="{{ route('index.page', 5) }}">Chính sách hội viện</a>
                                </li>
                                <li>
                                    <a href="{{ route('index.page', 6) }}">Giao hàng - lắp đặt</a>
                                </li>
                            </ul>
                        </div>
                        <div class="block" id="newfeed">
                            <div class="fb-page"
                                data-href="https://www.facebook.com/%C4%90i%E1%BB%87n-m%C3%A1y-Ismart-104204065133418"
                                data-tabs="" data-width="" data-height="" data-small-header="false"
                                data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
                                <blockquote
                                    cite="https://www.facebook.com/%C4%90i%E1%BB%87n-m%C3%A1y-Ismart-104204065133418"
                                    class="fb-xfbml-parse-ignore"><a
                                        href="https://www.facebook.com/%C4%90i%E1%BB%87n-m%C3%A1y-Ismart-104204065133418">Điện
                                        máy Ismart</a></blockquote>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="foot-bot">
                <div class="wp-inner">
                    <p id="copyright">© Bản quyền thuộc về Đồng Đức Khải</p>
                </div>
            </div>
            <div id="btn-top">
                <img src="{{ url('public/images/icon-to-top.png') }}" />
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    {{-- Thông báo sweetAlert --}}
    @if (Session::has('status'))
        <script>
            swal("Thành công !", "{{ session('status') }}", "success", {
                button: "OK",
            });
        </script>
    @endif
    @if (Session::has('thankYou'))
        <script>
            swal("Mua hàng thành công !", "{{ session('thankYou') }}", "success", {
                button: "OK",
            });
        </script>
    @endif
    {{-- Select quận huyện --}}
    <script>
        $(document).ready(function() {
            $('.dynamic').change(function() {
                if ($(this).val() != '') {
                    var value = $(this).val();
                    var dependent = $(this).data('dependent');
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "{{ route('location') }}",
                        method: "POST",
                        data: {
                            value: value,
                            _token: _token,
                            dependent: dependent
                        },
                        success: function(result) {
                            $('#' + dependent).html(result);
                        }
                    })
                }
            });
        });
    </script>
    {{-- Gợi ý tìm kiếm --}}
    <script>
        $(document).ready(function() {
            $('input#s').keyup(function() {
                var query = $(this).val();
                if (query != '') {
                    //console.log(query);
                    var _token = $('input[name="_token"]').val();
                    //console.log(_token);
                    $.ajax({
                        url: "{{ route('index.autocomplete') }}",
                        method: "POST",
                        data: {
                            query: query,
                            _token: _token
                        },
                        success: function(data) {
                            $('#data-list').fadeIn();
                            $('#data-list').html(data);
                        }
                    })
                } else {
                    $('#data-list').fadeOut();
                }
            });
            $(document).on('click', '.suggest-li', function() {
                $('input#s').val($(this).text());
                $('#data-list').fadeOut();
            });
        });
    </script>

    <script src="{{ url('public/js/jquery-2.2.4.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('public/js/elevatezoom-master/jquery.elevatezoom.js') }}" type="text/javascript"></script>
    <script src="{{ url('public/js/bootstrap/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('public/js/carousel/owl.carousel.js') }}" type="text/javascript"></script>
    <script src="{{ url('public/js/slider.js') }}" type="text/javascript"></script>
    <script src="{{ url('public/js/main.js') }}" type="text/javascript"></script>
    <script src="{{ url('public/js/app.js') }}" type="text/javascript"></script>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v10.0"
        nonce="tGIhkK89"></script>

</body>

</html>
