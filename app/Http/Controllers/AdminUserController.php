<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Role;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'user']);
            return $next($request);
        });
    }
    //===================Danh sách=====================
    function list(Request $request)
    {
        //Tìm kiếm
        $keyword = "";
        if ($request->input('keyword')) {
            $keyword = $request->input('keyword');
        }
        //Dropdown menu action
        $act_list = [
            'delete' => 'Xóa tạm thời',
        ];
        if ($request->input('status'))
        {
            $status = $request->input('status');
            if ($status == 'trash') {
                $act_list = [
                    'restore' => 'Khôi phục',
                    'forceDelete' => 'Xóa vĩnh viễn'
                ];
                $users = User::onlyTrashed()
                    ->where([
                        ['name', 'LIKE', "%{$keyword}%"]
                    ])
                    ->paginate(5);
                $user_active = 'trash';
                //Trang đang active
            }
            if ($status == 'all') {
                $users = User::where([
                    ['name', 'LIKE', "%{$keyword}%"]
                ])->paginate(5);
                $user_active = 'all';
            }
        } else {
            $status = 'all';
            $users = User::where([
                ['name', 'LIKE', "%{$keyword}%"]
            ])->paginate(5);
            $user_active = 'all';
        }
        //Số lượng đang có và đang trong thùng rác
        $count_all_user = User::count();
        $count_trash_user = User::onlyTrashed()->count();
        $count = [$count_all_user, $count_trash_user];

        return view('admin.user.list', compact('users', 'count', 'act_list',
         'user_active','keyword','status'));
    }
    //======================Thêm mới===================
    function add()
    {
        $role_list = Role::all();
        return view('admin.user.add', compact('role_list'));
    }
    function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'role_id' => 'required',
            ],
            [
                'required' => 'Không được để trống :attribute',
                'min' => ':attribute phải có độ dài ít nhất :min ký tự',
                'max' => ':attribute có độ dài tối đa :max ký tự',
                'confirmed' => 'Xác nhận mật khẩu không khớp',
                'unique' => ':attribute đã tồn tại'
            ],
            [
                'name' => 'Họ tên',
                'email' => 'Email',
                'password' => 'Mật khẩu',
                'role_id' => 'Quyền'
            ]
        );
        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role_id' => $request->input('role_id'),
        ]);
        return redirect('admin/user/list')->with('status', 'Thêm thành viên thành công');
    }
    //=======================Xóa=======================
    function delete($id)
    {
        if (User::find($id) != null) {
            $user = User::find($id);
            $user->delete();
            return redirect('admin/user/list')->with('status', 'Đã thêm vào thùng rác');
        } else {
            $user = User::onlyTrashed()->find($id);
            $user->forceDelete();
            return redirect('admin/user/list')->with('status', 'Xóa vĩnh viên thành công');
        }
    }
    //=====================Action======================
    function action(Request $request)
    {
        $check_list = $request->input('check_list');
        if ($check_list) {
            foreach ($check_list as $k => $v) {
                if (Auth::id() == $v) {
                    unset($check_list[$k]);
                }
            }
            if (!empty($check_list)) {
                if ($request->input('act') != 'NULL') {
                    $act = $request->input('act');
                    if ($act == 'delete') {
                        User::destroy($check_list);
                        return redirect('admin/user/list')->with('status', 'Đã thêm vào thùng rác');
                    }
                    if ($act == 'restore') {
                        User::withTrashed()
                            ->whereIn('id', $check_list)
                            ->restore();
                        return redirect('admin/user/list')->with('status', 'Khôi phục dữ liệu thành công');
                    }
                    if ($act == 'forceDelete') {
                        User::onlyTrashed()
                            ->whereIn('id', $check_list)
                            ->forceDelete();
                        return redirect('admin/user/list')->with('status', 'Xóa vĩnh viễn thành công');
                    }
                } else {
                    return redirect('admin/user/list')->with('status', 'Hãy chọn 1 tác vụ');
                }
            } else {
                return redirect('admin/user/list')->with('alert', 'Không thể thao tác trên tài khoản của bạn');
            }
        } else {
            return redirect('admin/user/list')->with('alert', 'Hãy chọn 1 phần tử');
        }
    }
    //=====================Chỉnh sửa===================
    function edit($id)
    {
        $user = User::withTrashed()->find($id);
        $role_list = Role::all();
        return view('admin.user.edit', compact('user', 'role_list'));
    }
    function update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'password' => 'required|string|min:8|confirmed',
            ],
            [
                'required' => 'Không được để trống :attribute',
                'min' => ':attribute phải có độ dài ít nhất :min ký tự',
                'max' => ':attribute có độ dài tối đa :max ký tự',
                'confirmed' => 'Xác nhận mật khẩu không khớp',
                'unique' => ':attribute đã tồn tại'
            ],
            [
                'name' => 'Họ tên',
                'password' => 'Mật khẩu'
            ]
        );
        User::withTrashed()->where('id', $id)->update([
            'name' => $request->input('name'),
            'password' => Hash::make($request->input('password')),
        ]);
        return redirect('admin/user/list')->with('status', 'Cập nhật thành công');
    }
}
