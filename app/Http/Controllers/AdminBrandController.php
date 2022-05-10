<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Brand;
use App\Cat;
use App\Product;

class AdminBrandController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'brand']);
            return $next($request);
        });
    }
    //===================Danh sách======================
    function list(Request $request)
    {
        //Các trường tìm kiếm
        $keyword = "";
        $cat_id = "";
        if ($request->input('keyword')) {
            if ($request->input('cat') == 'all') {
                $keyword = $request->input('keyword');
                $data = [
                    ['name', 'LIKE', "%{$keyword}%"]
                ];
            } else {
                $keyword = $request->input('keyword');
                $cat_id = $request->input('cat');
                $data = [
                    ['name', 'LIKE', "%{$keyword}%"],
                    ['cat_id', '=', "{$cat_id}"]
                ];
            }
        } else {
            if (!$request->input('cat') || $request->input('cat') == 'all') {
                $data = [
                    ['name', 'LIKE', "%{$keyword}%"]
                ];
            } else {
                $cat_id = $request->input('cat');
                $data = [
                    ['name', 'LIKE', "%{$keyword}%"],
                    ['cat_id', '=', "{$cat_id}"]
                ];
            }
        }
        //Dropdown act_list
        $act_list = [
            'changeStatus' => 'Duyệt'
        ];
        if ($request->input('status')) {
            $status = $request->input('status');
            if ($status == 'wait') {
                $brands = Brand::where($data)
                    ->where('status', '=', '1')
                    ->orderBy('status')
                    ->paginate(5);
                $brand_active = 'wait';
            }
            if ($status == 'all') {
                $brands = Brand::where($data)->orderBy('status')->paginate(5);
                $brand_active = 'all';
            }
        } else {
            $status = 'all';
            $brands = Brand::where($data)
            ->orderBy('status')
            ->paginate(5);
            $brand_active = 'all';
        }


        //Dropdown cat_list
        $cat_list = Cat::all();
        $count_all_brand = Brand::count();
        $count_wait_brand = Brand::where('status', '=', '1')->count();
        $count = [$count_all_brand, $count_wait_brand];
        //số lượng phần tử đang có và đang trong thùng rác
        return view('admin.brand.list', compact(
            'brands',
            'count',
            'act_list',
            'brand_active',
            'cat_list',
            'status',
            'keyword',
            'cat_id'
        ));
    }
    //===================Thêm mới=======================
    function add()
    {
        $cat_list = Cat::all();
        return view('admin.brand.add', compact('cat_list'));
    }
    function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'cat_id' => 'required',
                'status' => 'required'
            ],
            [
                'required' => 'Không được để trống :attribute',
                'max' => ':attribute có độ dài tối đa :max ký tự',

            ],
            [
                'name' => 'Tên nhãn hàng',
                'cat_id' => 'Danh mục',
                'status' => 'Trạng thái'
            ]
        );
        Brand::create([
            'name' => $request->input('name'),
            'cat_id' => $request->input('cat_id'),
            'status' => $request->input('status'),
        ]);
        //phải thêm các trường này vào model brand protected $fillable
        return redirect('admin/brand/list')->with('status', 'Thêm nhãn hàng mới thành công');
    }
    //====================Xóa===========================
    function delete($id)
    {
        Brand::find($id)->delete();
        return redirect('admin/brand/list')->with('status', 'Xóa vĩnh viên thành công');
    }
    //===================Chỉnh sửa======================
    function edit($id)
    {
        $cat_list = Cat::all();
        $brand = Brand::find($id);
        return view('admin.brand.edit', compact('brand', 'cat_list'));
    }
    function update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'cat_id' => 'required',
                'status' => 'required'
            ],
            [
                'required' => 'Không được để trống :attribute',
                'max' => ':attribute có độ dài tối đa :max ký tự',

            ],
            [
                'name' => 'Tên nhãn hàng',
                'cat_id' => 'Danh mục',
                'status' => 'Trạng thái'
            ]
        );
        Brand::where('id', $id)->update([
            'name' => $request->input('name'),
            'cat_id' => $request->input('cat_id'),
            'status' => $request->input('status')
        ]);
        return redirect('admin/brand/list')->with('status', 'Cập nhật thành công');
    }
    //====================Action========================
    function action(Request $request)
    {
        $check_list = $request->input('check_list');
        if ($check_list) {
            if ($request->input('act') != 'NULL') {
                $act = $request->input('act');
                if ($act == 'changeStatus') {
                    Brand::whereIn('id', $check_list)
                        ->update(['status' => '2']);
                    return redirect('admin/brand/list')->with('status', 'Duyệt thành công');
                }
            } else {
                return redirect('admin/brand/list')->with('status', 'Hãy chọn 1 tác vụ');
            }
        } else {
            return redirect('admin/brand/list')->with('status', 'Hãy chọn ít nhất 1 phần tử');
        }
    }
}
