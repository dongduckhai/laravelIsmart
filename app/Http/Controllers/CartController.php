<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    function show()
    {
        return view('cart.show');
    }

    function add(Request $request, $id)
    {
        $qty = 1;
        if ($request->qty) {
            $qty = $request->qty;
        }
        $product = Product::find($id);
        Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => $qty,
            'price' => $product->price,
            'options' => ['thumbnail' => $product->thumbnail]
            ]
        );
        return redirect('cart/show')->with('status','Đã thêm vào giỏ hàng');
    }

    function addAjax($id)
    {
        //add cart và update các thông số
        $product = Product::find($id);
        Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => 1,
            'price' => $product->price,
            'options' => ['thumbnail' => $product->thumbnail]
            ]
        );
         $data = array(
            //số lượng sản phẩm của cả giỏ
            'num_order'=> Cart::count(),
            //tổng tiền của cả giỏ
            'total'=> Cart::total(),
        );
        echo json_encode($data);

    }

    function remove($rowId)
    {
        Cart::remove($rowId);
        return redirect()->route('cart.show');
    }

    function destroy()
    {
        Cart::destroy();
        return redirect()->route('cart.show');
    }

    /*public function update(Request $request)
    {
        $data = $request->get('qty');
        foreach ($data as $k=>$v)
        {
            Cart::update($k, $v);
        }
        return redirect('cart/show');
    }  */
    function update()
    {
        //Lấy rowId và số lượng thay đổi
        $id = $_GET['id'];
        $qty = $_GET['qty'];
        //update cart
        Cart::update($id, $qty);
        //Tìm sản phẩm đã thay đổi
        $item = Cart::get($id);
        //update tổng giá cho sản phẩm ấy
        $sub_total = number_format($item->price * $qty, 0, ',', '.');
        // dữ liệu xử lý xong gói vào đổ lại file js thôi
        $data = array(
            //số lượng sản phẩm của cả giỏ
            'num_order'=> Cart::count(),
            //tồng tiền của từng sản phẩm
            'sub_total'=> $sub_total,
            //tổng tiền của cả giỏ
            'total'=> Cart::total(),
            //số lượng của từng sản phẩm
            'num_per_product' => $qty,
        );
        echo json_encode($data);
    }
    //==================================CheckOut====================================
    function checkOut()
    {
        $cities = DB::table('provinces')->get();
        return view('checkOut',compact('cities'));
    }
    function getLocation(Request $request)
    {
        $value = $request->get('value');
        $dependent = $request->get('dependent');
        $data = DB::table("{$dependent}")
        ->where('parent_code',$value)
        ->get();
        $choose = DB::table("{$dependent}")->first()->type;
        $output = '<option value="">'.$choose.'</option>';
        foreach($data as $row)
        {
            $output .= '<option value="'.$row->code.'">'.$row->name.'</option>';
        }
        echo $output;
    }
}
