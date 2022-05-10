<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Slider;

class AdminSliderController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'slider']);
            return $next($request);
        });
    }
    //===================Danh sách======================
    function list(Request $request)
    {
        //Dropdown act_list
        $act_list = [
            'delete' => 'Xóa tạm thời',
            'changeStatus' => 'Duyệt'
        ];
        //Danh sách dựa theo status
        if ($request->input('status')) {
            $status = $request->input('status');
            if ($status == 'trash') {
                $act_list = [
                    'restore' => 'Khôi phục',
                    'forceDelete' => 'Xóa vĩnh viễn'
                ];
                $sliders = Slider::onlyTrashed()
                    ->paginate(5);
                $slider_active = 'trash';
            }
            if ($status == 'wait') {
                $act_list = [
                    'delete' => 'Xóa tạm thời',
                    'changeStatus' => 'Duyệt'
                ];
                $sliders = Slider::where('status', '=', '1')
                    ->paginate(5);
                $slider_active = 'wait';
            }
            if($status == 'all') {
                $sliders = Slider::paginate(5);
                $slider_active = 'all';
            }
        } else {
            $status = 'all';
            $sliders = Slider::paginate(5);
            $slider_active = 'all';
        }
        $count_all_slider = Slider::count();
        $count_trash_slider = Slider::onlyTrashed()->count();
        $count_wait_slider = Slider::where('status', '=', '1')->count();
        $count = [$count_all_slider, $count_trash_slider, $count_wait_slider];
        //số lượng phần tử đang có và đang trong thùng rác
        return view('admin.slider.list', compact('sliders', 'count', 'act_list',
        'slider_active','status'));
    }
    //===================Thêm mới=======================
    function add()
    {
        return view('admin.slider.add');
    }
    function store(Request $request)
    {
        $request->validate(
            [
                'file' => 'required|image',
                'status' => 'required'
            ],
            [
                'required' => 'Không được để trống :attribute',
                'image' => ':attribute phải là ảnh'

            ],
            [
                'file' => 'Ảnh tiêu đề',
                'status' => 'Trạng thái'
            ]
        );
        if ($request->hasFile('file')) {
            $file = $request->file;
            $filename = $file->getClientOriginalName();
            $file->move('public/uploads', $filename);
            $thumbnail = 'public/uploads/' . $filename;
        }
        Slider::create([
            'thumbnail' => $thumbnail,
            'status' => $request->input('status')
        ]);
        //phải thêm các trường này vào model Post protected $fillable
        return redirect('admin/slider/list')->with('status', 'Thêm slide mới thành công');
    }
    //====================Xóa===========================
    function delete($id)
    {
        if (Slider::find($id) != null) {
            Slider::find($id)->update(['status' => '3']);
            Slider::find($id)->delete();
            return redirect('admin/slider/list')->with('status', 'Đã thêm vào thùng rác');
        } else {
            $slider = Slider::onlyTrashed()->find($id)->forceDelete();
            @unlink($slider->thumbnail);
            return redirect('admin/slider/list')->with('status', 'Xóa vĩnh viên thành công');
        }
    }
    //===================Chỉnh sửa======================
    function edit($id)
    {
        $slider = Slider::withTrashed()->find($id);
        return view('admin.slider.edit', compact('slider'));
    }
    function update(Request $request, $id)
    {
        $request->validate(
            [
                'file' => 'image',
                'status' => 'required'
            ],
            [
                'required' => 'Không được để trống :attribute',
                'image' => ':attribute phải là ảnh'

            ],
            [
                'file' => 'Ảnh tiêu đề',
                'status' => 'Trạng thái'
            ]
        );
        if ($request->hasFile('file')) {
            $file = $request->file;
            $filename = $file->getClientOriginalName();
            $file->move('public/uploads', $filename);
            $thumbnail = 'public/uploads/' . $filename;
            Slider::withTrashed()->where('id', $id)->update([
                'status' => $request->input('status'),
                'thumbnail' => $thumbnail
            ]);
        } else {
            Slider::withTrashed()->where('id', $id)->update([
                'status' => $request->input('status'),
            ]);
        }
        return redirect('admin/slider/list')->with('status', 'Cập nhật thành công');
    }
    //====================Action========================
    function action(Request $request)
    {
        $check_list = $request->input('check_list');
        if ($check_list) {
            if ($request->input('act') != 'NULL') {
                $act = $request->input('act');
                if ($act == 'delete') {
                    Slider::whereIn('id', $check_list)
                        ->update(['status' => '3']);
                    Slider::destroy($check_list);
                    return redirect('admin/slider/list')->with('status', 'Đã thêm vào thùng rác');
                }
                if ($act == 'changeStatus') {
                    Slider::whereIn('id', $check_list)
                        ->update(['status' => '2']);
                    return redirect('admin/slider/list')->with('status', 'Duyệt thành công');
                }
                if ($act == 'restore') {
                    Slider::onlyTrashed()
                        ->whereIn('id', $check_list)
                        ->update(['status' => '1']);
                    Slider::onlyTrashed()
                        ->whereIn('id', $check_list)
                        ->restore();
                    return redirect('admin/slider/list')->with('status', 'Khôi phục dữ liệu thành công');
                }
                if ($act == 'forceDelete') {
                    Slider::onlyTrashed()
                        ->whereIn('id', $check_list)
                        ->forceDelete();
                    return redirect('admin/slider/list')->with('status', 'Xóa vĩnh viễn thành công');
                }
            } else {
                return redirect('admin/slider/list')->with('alert', 'Hãy chọn 1 tác vụ');
            }
        } else {
            return redirect('admin/slider/list')->with('alert', 'Hãy chọn ít nhất 1 phần tử');
        }
    }
}
