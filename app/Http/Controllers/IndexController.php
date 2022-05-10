<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Slider;
use App\Cat;
use App\Product;
use App\Brand;
use App\Post;
use App\Page;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    //=====================================Trang chủ=====================================
    function home()
    {
        $sliders = Slider::all()
            ->where('status', '=', '2');
        //danh sách danh mục + hot_product dùng cho sidebar
        $cats = Cat::all();
        $hot_products = Product::where('hot', '=', 'On')
            ->where('status', '=', '2')
            ->orderBy('brand_id')
            ->get();
        //Lấy sản phẩm theo danh mục
        foreach ($cats as $cat) {
            $count["{$cat->id}"] = Product::where('cat_id', '=', "{$cat->id}")
                ->where('status', '=', '2')
                ->count();
            $products["{$cat->id}"] = Product::where('cat_id', '=', "{$cat->id}")
                ->where('status', '=', '2')
                ->paginate(8);
        }
        return view('index', compact('sliders', 'cats', 'products', 'hot_products', 'count'));
    }
    //===========================Danh sách laptop và điện thoại==========================
    function listByCat($id)
    {
        //danh sách danh mục + hot_product dùng cho sidebar
        $cats = Cat::all();
        $cat = Cat::find($id);
        $hot_products = Product::where('hot', '=', 'On')
            ->where('status', '=', '2')
            ->orderBy('brand_id')
            ->get();
        //danh sách nhãn hàng theo danh mục
        $brands = Brand::all()
            ->where('cat_id', '=', "{$id}")
            ->where('status', '=', '2');
        //Lấy sản phẩm theo nhãn hàng
        foreach ($brands as $brand) {
            $count["{$brand->id}"] = Product::where('brand_id', '=', "{$brand->id}")
                ->where('status', '=', '2')
                ->count();
            $products["{$brand->id}"] = Product::where('brand_id', '=', "{$brand->id}")
                ->where('status', '=', '2')
                ->paginate(8);
        }
        return view('productByCat', compact('brands', 'products', 'count', 'cats', 'cat', 'hot_products'));
    }
    //=======================Danh sách sản phẩm của từng nhãn hàng=======================
    function listByBrand(Request $request, $id)
    {
        //danh sách danh mục + hot_product dùng cho sidebar
        $cats = Cat::all();
        $hot_products = Product::where('hot', '=', 'On')
            ->where('status', '=', '2')
            ->orderBy('brand_id')
            ->get();

        //Lấy nhãn hàng, danh mục
        $brand = Brand::find($id);
        $cat = $brand->cat;
        //Lấy danh sách sản phẩm
        if ($request->input('sort')) {
            $sort = $request->input('sort');
            if ($sort == 1) {
                $products = Product::where([
                    ['brand_id', '=', "{$id}"],
                    ['price', '<', 5000000],
                    ['status', '=', '2'],
                ])->paginate(8);
            } else if ($sort == 2) {
                $products = Product::where([
                    ['brand_id', '=', "{$id}"],
                    ['status', '=', '2'],
                    ['price', '>', 5000000],
                    ['price', '<', 10000000],
                ])->paginate(8);
            } else if ($sort == 3) {
                $products = Product::where([
                    ['brand_id', '=', "{$id}"],
                    ['status', '=', '2'],
                    ['price', '>', 10000000],
                    ['price', '<', 20000000],
                ])->paginate(8);
            } else if ($sort == 4) {
                $products = Product::where([
                    ['brand_id', '=', "{$id}"],
                    ['price', '>', 20000000],
                    ['status', '=', '2'],
                ])->paginate(8);
            } else {
                $products = Product::where([
                    ['brand_id', '=', "{$id}"],
                    ['status', '=', '2'],
                ])->paginate(8);
            }
        } else {
            $sort = 0;
            $products = Product::where([
                ['brand_id', '=', "{$id}"],
                ['status', '=', '2'],
            ])->paginate(8);
        }

        return view('productByBrand', compact('products', 'cats', 'hot_products', 'brand', 'cat', 'sort'));
    }
    //====================================Products======================================
    function products()
    {
        //danh sách danh mục + hot_product dùng cho sidebar
        $cats = Cat::all();
        $hot_products = Product::where('hot', '=', 'On')
            ->where('status', '=', '2')
            ->orderBy('brand_id')
            ->get();
        //Lấy sản phẩm theo danh mục
        foreach ($cats as $cat) {
            $count["{$cat->id}"] = Product::where('cat_id', '=', "{$cat->id}")
                ->where('status', '=', '2')
                ->count();
            $products["{$cat->id}"] = Product::where('cat_id', '=', "{$cat->id}")
                ->where('status', '=', '2')
                ->paginate(8);
        }
        return view('productIndex', compact('cats', 'products', 'hot_products', 'count'));
    }
    //====================================Blog==========================================
    function blog()
    {
        //sidebar hot_posts
        $hot_posts = Post::where('status', '=', '2')
            ->where('hot', '=', 'On')
            ->get();
        //post index
        $posts = Post::where('status', '=', '2')
            ->paginate(5);
        return view('blog', compact('posts', 'hot_posts'));
    }
    //===================================Page===========================================
    function page($id)
    {
        //sidebar hot_posts
        $hot_posts = Post::where('status', '=', '2')
            ->where('hot', '=', 'On')
            ->get();
        //page details
        $page = Page::find($id);
        return view('page', compact('page', 'hot_posts'));
    }
    //===================================ProductDetails=================================
    function product($id)
    {
        //danh sách danh mục + hot_product dùng cho sidebar
        $cats = Cat::all();
        $hot_products = Product::where('hot', '=', 'On')
            ->where('status', '=', '2')
            ->orderBy('brand_id')
            ->get();
        $product = Product::find($id);
        $brand = $product->brand_id;
        $same_brand_products = Product::all()
            ->where('brand_id', '=', "{$brand}")
            ->where('status', '=', '2');
        return view('productDetails', compact('product', 'cats', 'hot_products', 'same_brand_products'));
    }
    //======================================PostDetails=================================
    function post($id)
    {
        //sidebar hot_posts
        $hot_posts = Post::where('status', '=', '2')
            ->where('hot', '=', 'On')
            ->get();
        //Chi tiết bài viết
        $post = Post::find($id);
        return view('postDetails', compact('post', 'hot_posts'));
    }
    //======================================Search======================================
    function autocomplete(Request $request)
    {
        if ($request->get('query')) {
            $query = $request->get('query');
            $data = Product::where('name', 'LIKE', "%{$query}%")->limit(5)->get();
            $output = '<ul id="suggest-list">';
            foreach ($data as $row) {
                $output .= '<li class="clearfix suggest-li">
                                <a href ="' . url("product/{$row->id}") . '" class="clearfix" style="display:block">
                                    <div class="thumb fl-left">
                                        <img src="' . url($row->thumbnail) . '">
                                    </div>
                                    <div class="info fl-left">
                                        <p class="info product-name">' . $row->name . '</p>
                                        <p class="price">' . number_format($row->price, 0, '', '.') . 'đ</p>
                                    </div>
                                </a>
                            </li>';
            }
            $output .= '</ul>';
            echo $output;
        }
    }
    function search(Request $request)
    {
        if ($request->input('keyword') == NULL) {
            return redirect('/');
        } else {
            //danh sách danh mục + hot_product dùng cho sidebar
            $cats = Cat::all();
            $hot_products = Product::where('hot', '=', 'On')
                ->where('status', '=', '2')
                ->orderBy('brand_id')
                ->get();
            //danh sách tìm kiếm
            $keyword = $request->input('keyword');
            if ($request->input('sort')) {
                $sort = $request->input('sort');
                if ($sort == 1) {
                    $search_products = Product::where([
                        ['name', 'LIKE', "%{$keyword}%"],
                        ['price', '<', 5000000],
                        ['status', '=', '2'],
                    ])->paginate(8);
                } else if ($sort == 2) {
                    $search_products = Product::where([
                        ['name', 'LIKE', "%{$keyword}%"],
                        ['status', '=', '2'],
                        ['price', '>', 5000000],
                        ['price', '<', 10000000],
                    ])->paginate(8);
                } else if ($sort == 3) {
                    $search_products = Product::where([
                        ['name', 'LIKE', "%{$keyword}%"],
                        ['status', '=', '2'],
                        ['price', '>', 10000000],
                        ['price', '<', 20000000],
                    ])->paginate(8);
                } else if ($sort == 4) {
                    $search_products = Product::where([
                        ['name', 'LIKE', "%{$keyword}%"],
                        ['price', '>', 20000000],
                        ['status', '=', '2'],
                    ])->paginate(8);
                } else {
                    $search_products = Product::where([
                        ['name', 'LIKE', "%{$keyword}%"],
                        ['status', '=', '2'],
                    ])->paginate(8);
                }
            } else {
                $sort = 0;
                $search_products = Product::where([
                    ['name', 'LIKE', "%{$keyword}%"],
                    ['status', '=', '2'],
                ])->paginate(8);
            }
            return view('search', compact('cats', 'hot_products', 'search_products', 'keyword', 'sort'));
        }
    }
}
