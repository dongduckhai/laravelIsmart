<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;

class AdminController extends Controller
{
    //
    function __construct()
    {
        $this->middleware(function($request,$next)
        {
            session(['module_active' => 'admin']);
            return $next($request);
        });
    }
    function show()
    {
        $wait_orders = Order::where('status', "1")->paginate(4);
        $wait_order_count = Order::all()->where('status', "1")->count();
        $done_order_count = Order::all()->where('status', "3")->count();
        $revenue = Order::where('status', "3")->sum('total');
        $trash_order_count = Order::onlyTrashed()->count();
        $count = [$done_order_count, $wait_order_count, $trash_order_count];
        return view('admin.dashboard', compact('wait_orders', 'revenue', 'count'));
    }
}
