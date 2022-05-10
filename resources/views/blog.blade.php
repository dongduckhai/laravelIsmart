@extends('layouts.index')
@section('content')
<div id="main-content-wp" class="clearfix blog-page">
    <div class="wp-inner">
        <div class="secion" id="breadcrumb-wp">
            <div class="secion-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="{{ url('/')}}" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="" title="">Blog</a>
                    </li>
                </ul>
            </div>
        </div>
        {{-- Danh sách post --}}
        <div class="main-content fl-right">
            <div class="section" id="list-blog-wp">
                <div class="section-head clearfix">
                    <h3 class="section-title">Tin tức công nghệ 24h</h3>
                </div>
                <div class="section-detail">
                    <ul class="list-item">
                        @foreach($posts as $post)
                        <li class="clearfix">
                            <a href="{{ route('post.details',$post->id) }}" class="thumb fl-left">
                                <img src="{{ url($post->thumbnail)}}" alt="">
                            </a>
                            <div class="info fl-right">
                                <a href="{{ route('post.details',$post->id) }}" class="title">
                                    {{ $post->title }}
                                </a>
                                <span class="create-date">{{ date_format($post->created_at, 'd/m/Y') }}</span>
                                <p class="desc">{{ $post->desc }}</p>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        {{ $posts->links() }}
        </div>
        {{-- end danh sách post --}}
        {{-- sidebar hot_post --}}
        <div class="sidebar fl-left">
            <div class="section" id="selling-wp">
                <div class="section-head">
                    <h3 class="section-title">Bài viết nổi bật</h3>
                </div>
                <div class="section-detail">
                    <ul class="list-item">
                        @foreach ($hot_posts as $hot_post)
                            <li class="clearfix">
                                <a href="{{-- {{ route('post.details',$hot_post->id) }} --}}" class="thumb fl-left">
                                    <img src="{{ url($hot_post->thumbnail) }}">
                                </a>
                                <div class="info fl-right">
                                    <a href="{{-- {{ route('post.details',$hot_post->id) }} --}}" class="product-name">
                                        {{ $hot_post->title }}
                                    </a>
                                    <div class="price">
                                        <span class="hot-create-date">
                                            {{ date_format($hot_post->created_at, 'd/m/Y') }}
                                        </span>
                                    </div>
                                    <a href="{{-- {{ route('post.details',$hot_post->id) }} --}}" title="Xem thêm" class="buy-now">
                                        Xem thêm</a>
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
        {{-- end sidebar hot_post --}}
    </div>
</div>
@endsection
