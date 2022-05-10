<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['prefix' => 'laravel-filemanager', 'middleware'], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
Auth::routes();
//===================================ADMIN ==========================================
Route::get('/admin', 'AdminController@show')->middleware('auth');
//==================================ADMIN/USER ======================================
Route::middleware('auth','CheckRole:Admintrator')->group(function(){
    Route::get('admin/user/list','AdminUserController@list');
    Route::get('admin/user/add',"AdminUserController@add");
    Route::post('admin/user/store',"AdminUserController@store");
    Route::get('admin/user/delete/{id}',"AdminUserController@delete")->name('user.delete');
    Route::get('admin/user/action',"AdminUserController@action");
    Route::get('admin/user/edit/{id}',"AdminUserController@edit")->name('user.edit');
    Route::post('admin/user/update/{id}',"AdminUserController@update")->name('user.update');
});
//================================ADMIN/PAGE========================================
Route::middleware('auth','CheckRole:Admintrator')->group(function(){
    Route::get('admin/page/list','AdminPageController@list');
    Route::get('admin/page/add',"AdminPageController@add");
    Route::post('admin/page/store',"AdminPageController@store");
    Route::get('admin/page/delete/{id}',"AdminPageController@delete")->name('page.delete');
    Route::get('admin/page/action',"AdminPageController@action");
    Route::get('admin/page/edit/{id}',"AdminPageController@edit")->name('page.edit');
    Route::post('admin/page/update/{id}',"AdminPageController@update")->name('page.update');
    Route::get('admin/page/quickUpdate',"AdminPageController@quickUpdate")->name('page.update');
});
//================================ADMIN/CAT========================================
Route::middleware('auth','CheckRole:Admintrator')->group(function(){
    Route::get('admin/cat/list','AdminCatController@list');
    Route::get('admin/cat/add',"AdminCatController@add");
    Route::post('admin/cat/store',"AdminCatController@store");
    Route::get('admin/cat/delete/{id}',"AdminCatController@delete")->name('cat.delete');
    Route::get('admin/cat/action',"AdminCatController@action");
    Route::get('admin/cat/edit/{id}',"AdminCatController@edit")->name('cat.edit');
    Route::post('admin/cat/update/{id}',"AdminCatController@update")->name('cat.update');
});
//================================ADMIN/POST========================================
Route::middleware('auth')->group(function(){
    Route::get('admin/post/list','AdminPostController@list');
    Route::get('admin/post/add',"AdminPostController@add");
    Route::post('admin/post/store',"AdminPostController@store");
    Route::get('admin/post/delete/{id}',"AdminPostController@delete")->name('post.delete');
    Route::get('admin/post/action',"AdminPostController@action");
    Route::get('admin/post/edit/{id}',"AdminPostController@edit")->name('post.edit');
    Route::post('admin/post/update/{id}',"AdminPostController@update")->name('post.update');
});
//================================ADMIN/BRAND========================================
Route::middleware('auth')->group(function(){
    Route::get('admin/brand/list','AdminBrandController@list');
    Route::get('admin/brand/add',"AdminBrandController@add");
    Route::post('admin/brand/store',"AdminBrandController@store");
    Route::get('admin/brand/delete/{id}',"AdminBrandController@delete")->name('brand.delete');
    Route::get('admin/brand/action',"AdminBrandController@action");
    Route::get('admin/brand/edit/{id}',"AdminBrandController@edit")->name('brand.edit');
    Route::post('admin/brand/update/{id}',"AdminBrandController@update")->name('brand.update');
});
//================================ADMIN/PRODUCT=======================================
Route::middleware('auth')->group(function(){
    Route::get('admin/product/list','AdminProductController@list');
    Route::get('admin/product/add',"AdminProductController@add");
    Route::post('admin/product/store',"AdminProductController@store");
    Route::post('admin/product/uploadFile',"AdminProductController@uploadFile");
    Route::get('admin/product/edit/{id}',"AdminProductController@edit")->name('product.edit');
    Route::get('admin/product/getImages/{id}',"AdminProductController@getImages");
    //Route::get('admin/product/removeImage',"AdminProductController@removeImage");
    Route::post('admin/product/update/{id}',"AdminProductController@update")->name('product.update');
    Route::get('admin/product/delete/{id}',"AdminProductController@delete")->name('product.delete');
    Route::get('admin/product/action',"AdminProductController@action");
});
//================================ADMIN/Slider========================================
Route::middleware('auth')->group(function(){
    Route::get('admin/slider/list','AdminSliderController@list');
    Route::get('admin/slider/add',"AdminSliderController@add");
    Route::post('admin/slider/store',"AdminSliderController@store");
    Route::get('admin/slider/edit/{id}',"AdminSliderController@edit")->name('slider.edit');
    Route::post('admin/slider/update/{id}',"AdminSliderController@update")->name('slider.update');
    Route::get('admin/slider/delete/{id}',"AdminSliderController@delete")->name('slider.delete');
    Route::get('admin/slider/action',"AdminSliderController@action");
});
//==================================ORDER=============================================
Route::middleware('auth')->group(function(){
    Route::get('admin/order/list','AdminOrderController@list');
    Route::get('admin/order/edit/{id}',"AdminOrderController@edit")->name('order.edit');
    Route::post('admin/order/update/{id}',"AdminOrderController@update")->name('order.update');
    Route::get('admin/order/action',"AdminOrderController@action");
    Route::get('admin/order/delete/{id}','AdminOrderController@delete')->name('order.delete');
});
Route::post('admin/order/store',"AdminOrderController@store")->name('order.store');
//===============================Phần Website=========================================
Route::get('/','IndexController@home')->name('index.home');
Route::get('products','IndexController@products')->name('index.product');
Route::get('blog','IndexController@blog')->name('index.blog');
Route::get('page/{id}','IndexController@page')->name('index.page');
Route::get('/cat/{id}','IndexController@listByCat')->name('index.cat.product');
Route::get('brand/{id}','IndexController@listByBrand')->name('index.brand.product');
//====================================Tìm kiếm========================================
Route::get('search','IndexController@search')->name('index.search');
Route::post('autocomplete','IndexController@autocomplete')->name('index.autocomplete');
Route::get('sort/{keyword}','IndexController@sort')->name('index.search.sort');
//==================================CHi tiết sản phẩm=================================
Route::get('product/{id}','IndexController@product')->name('product.details');
//==================================CHi tiết bài viết=================================
Route::get('post/{id}','IndexController@post')->name('post.details');
//====================================Giỏ hàng========================================
Route::get('cart/show','CartController@show')->name('cart.show');
Route::get('cart/add/{id}','CartController@add')->name('cart.add');
Route::get('cart/ajax/{id}','CartController@addAjax')->name('cart.ajax');
Route::get('cart/remove/{id}','CartController@remove')->name('cart.remove');
Route::get('cart/destroy','CartController@destroy')->name('cart.destroy');
Route::get('cart/update','CartController@update');
Route::get('checkout','CartController@checkOut')->name('checkout');
Route::post('checkout/location','CartController@getLocation')->name('location');







