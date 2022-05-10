<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Order;
use App\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\DB;
use Vanthao03596\HCVN\Models\District;
use Vanthao03596\HCVN\Models\Province;
use Vanthao03596\HCVN\Models\Ward;

class AdminOrderController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'order']);
            return $next($request);
        });
    }
    //================================Thêm mới================================
    function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'phone' => 'required',
                'email' => 'required|email|max:255',
                'house' => 'required|string|max:255',
                'province' => 'required',
                'district' => 'required',
                'ward' => 'required',
                'payment' => 'required'
            ],
            [
                'required' => 'Không được để trống :attribute',
                'max' => ':attribute có độ dài tối đa :max ký tự',
                'image' => ':attribute phải là ảnh',
                'unique' => ':attribute đã tồn tại',
                'string' => ':attribute phải ở dạng ký tự'

            ],
            [
                'name' => 'Tên',
                'phone' => 'Số điện thoại',
                'email' => 'Email',
                'house' => 'Địa chỉ nhà',
                'province' => 'Tỉnh / Thành phố',
                'district' => 'Quận / Huyện',
                'ward' => 'Phường / Xã',
                'payment' => 'Hình thức thanh toán'
            ]
        );
        //Xác định địa chỉ
        $house = $request->input('house');
        $province_code = $request->input('province');
        $province = Province::where('code', '=', $province_code)->first()->name_with_type;
        $district_code = $request->input('district');
        $district = District::where('code', '=', $district_code)->first()->name_with_type;
        $ward_code = $request->input('ward');
        $ward = Ward::where('code', '=', $ward_code)->first()->name_with_type;
        $address = $house . ', ' . $ward . ', ' . $district . ', ' . $province;
        //Tạo mã hóa đơn
        do {
            $code = Str::random(9);
            $count = Order::withTrashed()
                ->where('code', '=', "{$code}")
                ->count();
        } while ($count > 0);
        //Tạo hóa đơn
        $order = new Order;
        $order->name = $request->input('name');
        $order->phone = $request->input('phone');
        $order->email = $request->input('email');
        $order->payment = $request->input('payment');
        $order->address = $address;
        $order->note = $request->input('note');
        $order->status = "1";
        $order->qty = Cart::count();
        $order->code = "ISMART-" . $code;
        $order->total = intval(Cart::total()) * 1000000; //chuyển cart::total() từ chuỗi->số
        $order->save();
        //Ghi lại danh sách sản phẩm của 1 hóa đơn
        foreach (Cart::content() as $row) {
            $order->product()->attach($row->id, ['qty' => $row->qty]);
        }
        //Xóa cart đi
        Cart::destroy();
        return redirect('cart/show')->with('thankYou', 'Đơn hàng sẽ được gửi đến quý khách trong thời gian sớm nhất');
    }
    //================================Danh sách===============================
    function list(Request $request)
    {
        //Các trường tìm kiếm
        if ($request->input('customer')) {
            $customer = $request->input('customer');
            if ($request->input('code')) {
                $code = $request->input('code');
                $data = [
                    ['name', 'LIKE', "%{$customer}%"],
                    ['code', 'LIKE', "%{$code}%"]
                ];
            } else {
                $code = "";
                $data = [
                    ['name', 'LIKE', "%{$customer}%"]
                ];
            }
        } else {
            $customer = "";
            if ($request->input('code')) {
                $code = $request->input('code');
                $data = [
                    ['name', 'LIKE', "%{$customer}%"],
                    ['code','LIKE', "%{$code}%"],
                ];
            } else {
                $code = "";
                $data = [
                    ['name', 'LIKE', "%{$customer}%"],
                ];
            }
        }
        //Dropdown act_list
        $act_list = [
            'onTheWay' => 'Giao hàng',
            'complete' => 'Hoàn thành',
            'delete' => 'Hủy'
        ];
        //Danh sách dựa theo status
        if ($request->input('status'))
        {
            $status = $request->input('status');
            if ($status == 'trash') {
                $act_list = [
                    'restore' => 'Khôi phục',
                    'forceDelete' => 'Xóa vĩnh viễn'
                ];
                $orders = Order::onlyTrashed()
                    ->where($data)
                    ->orderBy('status')
                    ->paginate(4);
                $order_active = 'trash';
            }
            if ($status == 'wait') {
                $act_list = [
                    'delete' => 'Hủy',
                    'onTheWay' => 'Giao hàng'
                ];
                $orders = Order::where($data)
                    ->where('status', '=', '1')
                    ->orderBy('status')
                    ->paginate(4);
                $order_active = 'wait';
            }
            if ($status == 'onTheWay') {
                $act_list = [
                    'delete' => 'Hủy',
                    'complete' => 'Hoàn thành'
                ];
                $orders = Order::where($data)
                    ->where('status', '=', '2')
                    ->orderBy('status')
                    ->paginate(4);
                $order_active = 'onTheWay';
            }
            if ($status == 'complete') {
                $act_list = [];
                $orders = Order::where($data)
                    ->where('status', '=', '3')
                    ->orderBy('status')
                    ->paginate(4);
                $order_active = 'complete';
            }
            if ($status == 'all'){
                $orders = Order::where($data)
                ->orderBy('status')
                ->paginate(4);
                $order_active = 'all';
            }
        } else {
            $status = 'all';
            $orders = Order::where($data)
            ->orderBy('status')
            ->paginate(4);
            $order_active = 'all';
        }


        //số lượng phần tử theo từng loại
        $count_all_order = Order::count();
        $count_trash_order = Order::onlyTrashed()->count();
        $count_wait_order = Order::where('status', '=', '1')->count();
        $count_onTheWay_order = Order::where('status', '=', '2')->count();
        $count_complete_order = Order::where('status', '=', '3')->count();
        $count = [
            $count_all_order, $count_trash_order,
            $count_wait_order, $count_onTheWay_order, $count_complete_order
        ];
        return view('admin.order.list', compact('orders', 'order_active', 'act_list',
         'count','customer','code','status'));
    }
    //=================================Xóa====================================
    function delete($id)
    {
        if (Order::find($id) != null) {
            Order::where('id', $id)->update(['status' => '4']);
            Order::find($id)->delete();
            return redirect('admin/order/list')->with('status', 'Đã thêm vào thùng rác');
        } else {
            Order::onlyTrashed()->find($id)->forceDelete();
            return redirect('admin/order/list')->with('status', 'Xóa vĩnh viên thành công');
        }
    }
    //==============================Chỉnh sửa=================================
    function edit($id)
    {
        $order = Order::find($id);
        $products = $order->product;
        return view('admin.order.edit', compact('order', 'products'));
    }
    function update(Request $request, $id)
    {
        if ($request->input('status') == 4) {
            Order::where('id', $id)->update(['status' => '4']);
            Order::find($id)->delete();
        } else {
            Order::where('id', $id)->update([
                'status' => $request->input('status'),
            ]);
        }
        return redirect('admin/order/list')->with('status', 'Cập nhật thành công');
    }
    //================================Action==================================
    function action(Request $request)
    {
        $check_list = $request->input('check_list');
        if ($check_list) {
            if ($request->input('act') != 'NULL') {
                $act = $request->input('act');
                if ($act == 'delete') {
                    Order::whereIn('id', $check_list)
                        ->update(['status' => '4']);
                    Order::destroy($check_list);
                    return redirect('admin/order/list')->with('status', 'Đã thêm vào thùng rác');
                }
                if ($act == 'onTheWay') {
                    Order::whereIn('id', $check_list)
                        ->update(['status' => '2']);
                    return redirect('admin/order/list')->with('status', 'Cập nhật thành công');
                }
                if ($act == 'complete') {
                    Order::whereIn('id', $check_list)
                        ->update(['status' => '3']);
                    return redirect('admin/order/list')->with('status', 'Cập nhật thành công');
                }
                if ($act == 'restore') {
                    Order::onlyTrashed()
                        ->whereIn('id', $check_list)
                        ->update(['status' => '1']);
                    Order::onlyTrashed()
                        ->whereIn('id', $check_list)
                        ->restore();
                    return redirect('admin/order/list')->with('status', 'Khôi phục dữ liệu thành công');
                }
                if ($act == 'forceDelete') {
                    Order::onlyTrashed()
                        ->whereIn('id', $check_list)
                        ->forceDelete();
                    return redirect('admin/order/list')->with('status', 'Xóa vĩnh viễn thành công');
                }
            } else {
                return redirect('admin/order/list')->with('alert', 'Hãy chọn 1 tác vụ');
            }
        } else {
            return redirect('admin/order/list')->with('alert', 'Hãy chọn ít nhất 1 phần tử');
        }
    }
}
