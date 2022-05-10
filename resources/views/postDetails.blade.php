@extends('layouts.index')
@section('content')
<div id="main-content-wp" class="clearfix detail-blog-page">
    <div class="wp-inner">
        <div class="secion" id="breadcrumb-wp">
            <div class="secion-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="{{ url('/') }}">Trang chủ</a>
                    </li>
                    <li>
                        <a href="{{ route('index.blog') }}">Blog</a>
                    </li>
                </ul>
            </div>
        </div>
        {{-- Nội dung post --}}
        <div class="main-content fl-right">
            <div class="section" id="detail-blog-wp">
                <div class="section-head clearfix">
                    <h3 class="section-title">{{ $post->title }}</h3>
                </div>
                <div class="section-detail">
                    <span class="create-date">
                        {{ date_format($post->created_at, 'd/m/Y') }}
                    </span>
                    <div class="detail">
                        {!! $post->content !!}
                    </div>
                </div>
            </div>
            <div class="section" id="social-wp">
                <div class="section-detail">
                    <div class="fb-like" data-href="" data-layout="button_count" data-action="like" data-size="small" data-show-faces="true" data-share="true"></div>
                    <div class="g-plusone-wp">
                        <div class="g-plusone" data-size="medium"></div>
                    </div>
                    <div class="fb-comments" id="fb-comment" data-href="" data-numposts="5"></div>
                </div>
            </div>
        </div>
        {{-- end nội dung post --}}
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
                                <a href="{{ route('post.details',$hot_post->id) }}" class="thumb fl-left">
                                    <img src="{{ url($hot_post->thumbnail) }}">
                                </a>
                                <div class="info fl-right">
                                    <a href="{{ route('post.details',$hot_post->id) }}" class="product-name">
                                        {{ $hot_post->title }}
                                    </a>
                                    <div class="price">
                                        <span class="hot-create-date">
                                            {{ date_format($hot_post->created_at, 'd/m/Y') }}
                                        </span>
                                    </div>
                                    <a href="{{ route('post.details',$hot_post->id) }}" title="Xem thêm" class="buy-now">
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
