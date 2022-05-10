<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cat;

class AdminCatController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'cat']);
            return $next($request);
        });
    }
    //===================Danh sách======================
    function list(Request $request)
    {
        //Tìm kiếm
        $keyword = "";
        if ($request->input('keyword')) {
            $keyword = $request->input('keyword');
        }
        //Dropdown menu
        $act_list = [
            'changeStatus' => 'Duyệt',
        ];
        if ($request->input('status')) {
            $status = $request->input('status');
            if ($status == 'wait') {
                $cats = Cat::where([
                    ['name', 'LIKE', "%{$keyword}%"]
                ])
                    ->where('status', '=', '2')
                    ->orderBy('status','desc')->paginate(5);
                $cat_active = 'wait';
            }
            if ($status == 'all') {
                $cats = Cat::where([
                    ['name', 'LIKE', "%{$keyword}%"]
                ])
                    ->orderBy('status','desc')
                    ->paginate(5);
                $cat_active = 'all';
            }
        } else {
            $status = 'all';
            $cats = Cat::where([
                ['name', 'LIKE', "%{$keyword}%"]
            ])
                ->orderBy('status','desc')
                ->paginate(5);
            $cat_active = 'all';
        }
        $count_all_cat = Cat::count();
        $count_wait_cat = Cat::where('status', '2')->count();
        $count = [$count_all_cat, $count_wait_cat];
        //số lượng phần tử đang có và đang trong thùng rác
        return view('admin.cat.list', compact(
            'cats',
            'count',
            'act_list',
            'cat_active',
            'status',
            'keyword'
        ));
    }
    //===================Thêm mới=======================
    function add()
    {
        return view('admin.cat.add');
    }
    function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
            ],
            [
                'required' => 'Không được để trống :attribute',
                'max' => ':attribute có độ dài tối đa :max ký tự',

            ],
            [
                'name' => 'Tên danh mục',
            ]
        );
        Cat::create([
            'name' => $request->input('name'),
            'status' => "2",
        ]);
        return redirect('admin/cat/list')->with('status', 'Thêm danh mục mới thành công');
    }
    //====================Xóa===========================
    function delete($id)
    {
        Cat::find($id)->delete();
        return redirect('admin/cat/list')->with('status', 'Xóa vĩnh viễn thành công');
    }
    //===================Chỉnh sửa======================
    function edit($id)
    {
        $cat = Cat::find($id);
        return view('admin.cat.edit', compact('cat'));
    }
    function update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
            ],
            [
                'required' => 'Không được để trống :attribute',
                'max' => ':attribute có độ dài tối đa :max ký tự',

            ],
            [
                'name' => 'Tên danh mục',
            ]
        );
        Cat::where('id', $id)->update([
            'name' => $request->input('name'),
        ]);
        return redirect('admin/cat/list')->with('status', 'Cập nhật thành công');
    }
    //====================Action========================
    function action(Request $request)
    {
        $check_list = $request->input('check_list');
        if ($check_list) {
            if ($request->input('act') != 'NULL') {
                $act = $request->input('act');
                if ($act == 'changeStatus') {
                    Cat::whereIn('id', $check_list)
                        ->update(['status' => '1']);
                    return redirect('admin/cat/list')->with('status', 'Duyệt thành công');
                }
            } else {
                return redirect('admin/cat/list')->with('alert', 'Hãy chọn 1 tác vụ');
            }
        } else {
            return redirect('admin/cat/list')->with('alert', 'Hãy chọn ít nhất 1 phần tử');
        }
    }
}
