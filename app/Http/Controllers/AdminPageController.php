<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;

class AdminPageController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'page']);
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
            'delete' => 'Xóa tạm thời',
        ];
        if ($request->input('status')) {
            $status = $request->input('status');
            if ($status == 'trash') {
                $act_list = [
                    'restore' => 'Khôi phục',
                    'forceDelete' => 'Xóa vĩnh viễn'
                ];
                $pages = Page::onlyTrashed()
                    ->where([
                        ['title', 'LIKE', "%{$keyword}%"]
                    ])
                    ->paginate(5);
                $page_active = 'trash';
                //Trang đang active
            }
            if ($status == 'all') {
                $pages = Page::where([
                    ['title', 'LIKE', "%{$keyword}%"]
                ])->paginate(5);
                $page_active = 'all';
            }
        } else {
            $status = 'all';
            $pages = Page::where([
                ['title', 'LIKE', "%{$keyword}%"]
            ])->paginate(5);
            $page_active = 'all';
        }

        $count_all_page = Page::count();
        $count_trash_page = Page::onlyTrashed()->count();
        $count = [$count_all_page, $count_trash_page];
        //số lượng phần tử đang có và đang trong thùng rác
        return view('admin.page.list', compact('pages', 'count', 'act_list',
         'page_active','status','keyword'));
    }
    //===================Thêm mới=======================
    function add()
    {
        return view('admin.page.add');
    }
    function store(Request $request)
    {
        $request->validate(
            [
                'title' => 'required|string|max:255',
                'content' => 'required',
            ],
            [
                'required' => 'Không được để trống :attribute',
                'max' => ':attribute có độ dài tối đa :max ký tự',

            ],
            [
                'title' => 'Tiêu đề',
                'content' => 'Nội dung',
            ]
        );
        Page::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'status' => "1",
        ]);
        return redirect('admin/page/list')->with('status', 'Thêm trang mới thành công');
    }
    //====================Xóa===========================
    function delete($id)
    {
        if (Page::find($id) != null) {
            Page::where('id', $id)->update(['status' => '2']);
            Page::find($id)->delete();
            $data = [
                'title'=>"Đã thêm vào thùng rác",
            ];
            echo json_encode($data);
        } else {
            $page = Page::onlyTrashed()->find($id);
            $page->forceDelete();
            $data = [
                'title'=>"Đã xóa vĩnh viễn trang",
            ];
            echo json_encode($data);
        }
    }
    //===================Chỉnh sửa======================
    function edit($id)
    {
        $page = Page::find($id);
        return view('admin.page.edit', compact('page'));
    }
    function update(Request $request, $id)
    {
        $request->validate(
            [
                'title' => 'required|string|max:255',
                'content' => 'required',
            ],
            [
                'required' => 'Không được để trống :attribute',
                'max' => ':attribute có độ dài tối đa :max ký tự',

            ],
            [
                'title' => 'Tiêu đề',
                'content' => 'Nội dung',
            ]
        );
        Page::where('id', $id)->update([
            'title' => $request->input('title'),
            'content' => $request->input('content')
        ]);
        return redirect('admin/page/list')->with('status', 'Cập nhật thành công');
    }

    function quickUpdate() {
        $type = $_GET['type'];
        $id = $_GET['id'];
        if($type == "changeHot") {
            $hot = $_GET['hot'];
            $newClass = ($hot == 'On')? 'danger' : 'success';
            $newButton = ($hot == 'On')? 'minus' : 'check';
            $newHot = ($hot == 'On')? 'Off' : 'On';
            Page::where('id', $id)
            ->update([
                'hot' => $newHot
            ]);
            $params = "'".$id."','".$newHot."'";
            $xhtml =
            '<a class="hot-'.$id.' rounded-circle btn btn-'.$newClass.' btn-sm" href="javascript:changeHot('.$params.')"><i class="fas fa-'.$newButton.'"></i></a>';
            $data = [
                'html'=>$xhtml,

            ];
            echo json_encode($data);
        }
        if($type == "changeStatus") {
            $status = $_GET['status'];
            Page::where('id',$id)
            ->update(["status" => $status]);
            $data = [
                'title' => 'Chỉnh sửa thành công',
            ];
            echo json_encode($data);
        }
    }
    //====================Action========================
    function action(Request $request)
    {
        $check_list = $request->input('check_list');
        if ($check_list) {
            if ($request->input('act') != 'NULL') {
                $act = $request->input('act');
                if ($act == 'delete') {
                    Page::whereIn('id', $check_list)
                        ->update(['status' => '2']);
                    Page::destroy($check_list);
                    return redirect('admin/page/list')->with('status', 'Đã thêm vào thùng rác');
                }
                if ($act == 'restore') {
                    Page::onlyTrashed()
                        ->whereIn('id', $check_list)
                        ->update(['status' => '1','hot'=>'Off']);
                    Page::onlyTrashed()
                        ->whereIn('id', $check_list)
                        ->restore();
                    return redirect('admin/page/list')->with('status', 'Khôi phục dữ liệu thành công');
                }
                if ($act == 'forceDelete') {
                    Page::onlyTrashed()
                        ->whereIn('id', $check_list)
                        ->forceDelete();
                    return redirect('admin/page/list')->with('status', 'Xóa vĩnh viễn thành công');
                }
            } else {
                return redirect('admin/page/list')->with('alert', 'Hãy chọn 1 tác vụ');
            }
        } else {
            return redirect('admin/page/list')->with('alert', 'Hãy chọn ít nhất 1 phần tử');
        }
    }
}
