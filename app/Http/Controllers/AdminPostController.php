<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Cat;


class AdminPostController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'post']);
            return $next($request);
        });
    }
    //===================Danh sách======================
    function list(Request $request)
    {
        //Các trường tìm kiếm
        $cat_id = "";
        if ($request->input('keyword')) {
            $keyword = $request->input('keyword');
            if ($request->input('cat') == NULL || $request->input('cat') == 'all') {
                $data = [
                    ['title', 'LIKE', "%{$keyword}%"]
                ];
            } else {
                $cat_id = $request->input('cat');
                $data = [
                    ['title', 'LIKE', "%{$keyword}%"],
                    ['cat_id', '=', "{$cat_id}"]
                ];
            }
        } else {
            $keyword = "";
            if (!$request->input('cat') || $request->input('cat') == 'all' || $request->input('cat') == NULL) {
                $data = [
                    ['title', 'LIKE', "%{$keyword}%"]
                ];
            } else {
                $cat_id = $request->input('cat');
                $data = [
                    ['title', 'LIKE', "%{$keyword}%"],
                    ['cat_id', '=', "{$cat_id}"]
                ];
            }
        }
        //Dropdown act_list
        $act_list = [
            'delete' => 'Xóa tạm thời',
            'hot' => 'Nổi bật',
            'changeStatus' => 'Duyệt'
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
                $posts = Post::onlyTrashed()
                    ->where($data)
                    ->paginate(5);
                $post_active = 'trash';
            }
            if ($status == 'wait') {
                $act_list = [
                    'delete' => 'Xóa tạm thời',
                    'changeStatus' => 'Duyệt'
                ];
                $posts = Post::where($data)
                    ->where('status', '=', '1')
                    ->paginate(5);
                $post_active = 'wait';
            }
            if ($status == 'hot') {
                $act_list = [
                    'delete' => 'Xóa tạm thời',
                    'normal' => 'Bình thường'
                ];
                $posts = Post::where($data)
                    ->where('hot', '=', 'On')
                    ->paginate(5);
                $post_active = 'hot';
            }
            if ($status == "all") {
                $posts = Post::where($data)->paginate(5);
                $post_active = 'all';
            }
        } else {
            $status = "all";
            $posts = Post::where($data)->paginate(5);
            $post_active = 'all';
        }

        //Dropdown cat_list
        $cat_list = Cat::all();
        //số lượng phần tử đang có và đang trong thùng rác
        $count_all_post = Post::count();
        $count_trash_post = Post::onlyTrashed()->count();
        $count_wait_post = Post::where('status', '=', '1')->count();
        $count_hot_post = Post::where('hot', '=', 'On')->count();
        $count = [$count_all_post, $count_trash_post, $count_wait_post, $count_hot_post];

        return view('admin.post.list', compact('posts', 'count', 'act_list',
        'post_active', 'cat_list', 'status','keyword','cat_id'));
    }
    //===================Thêm mới=======================
    function add()
    {
        $cat_list = Cat::all();
        return view('admin.post.add', compact('cat_list'));
    }
    function store(Request $request)
    {
        $request->validate(
            [
                'title' => 'required|string|max:255',
                'content' => 'required',
                'file' => 'required|image',
                'desc' => 'required|string|max:255',
                'cat_id' => 'required',
                'status' => 'required'
            ],
            [
                'required' => 'Không được để trống :attribute',
                'max' => ':attribute có độ dài tối đa :max ký tự',
                'image' => ':attribute phải là ảnh'

            ],
            [
                'title' => 'Tiêu đề',
                'content' => 'Nội dung',
                'file' => 'Ảnh tiêu đề',
                'cat_id' => 'Danh mục',
                'desc' => 'Mô tả',
                'status' => 'Trạng thái'
            ]
        );
        if ($request->hasFile('file')) {
            $file = $request->file;
            $filename = $file->getClientOriginalName();
            $file->move('public/uploads', $filename);
            $thumbnail = 'public/uploads/' . $filename;
        }
        Post::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'desc' => $request->input('desc'),
            'cat_id' => $request->input('cat_id'),
            'status' => $request->input('status'),
            'thumbnail' => $thumbnail,
            'hot' => $request->input('hot'),
        ]);
        //phải thêm các trường này vào model Post protected $fillable
        return redirect('admin/post/list')->with('status', 'Thêm bài viết mới thành công');
    }
    //====================Xóa===========================
    function delete($id)
    {
        if (Post::find($id) != null) {
            Post::find($id)->update(['status' => '3', 'hot' => NULL]);
            Post::find($id)->delete();
            return redirect('admin/post/list')->with('status', 'Đã thêm vào thùng rác');
        } else {
            $post = Post::onlyTrashed()->find($id)->forceDelete();
            @unlink($post->thumbnail);
            return redirect('admin/post/list')->with('status', 'Xóa vĩnh viên thành công');
        }
    }
    //===================Chỉnh sửa======================
    function edit($id)
    {
        $cat_list = Cat::all();
        $post = Post::withTrashed()->find($id);
        return view('admin.post.edit', compact('post', 'cat_list'));
    }
    function update(Request $request, $id)
    {
        $request->validate(
            [
                'title' => 'required|string|max:255',
                'content' => 'required',
                'file' => 'image',
                'desc' => 'required|string|max:255',
                'cat_id' => 'required',
                'status' => 'required'
            ],
            [
                'required' => 'Không được để trống :attribute',
                'max' => ':attribute có độ dài tối đa :max ký tự',
                'image' => ':attribute phải là ảnh'

            ],
            [
                'title' => 'Tiêu đề',
                'content' => 'Nội dung',
                'file' => 'Ảnh tiêu đề',
                'cat_id' => 'Danh mục',
                'desc' => 'Mô tả',
                'status' => 'Trạng thái'
            ]
        );
        if ($request->hasFile('file')) {
            $file = $request->file;
            $filename = $file->getClientOriginalName();
            $file->move('public/uploads', $filename);
            $thumbnail = 'public/uploads/' . $filename;
            Post::withTrashed()->where('id', $id)->update([
                'title' => $request->input('title'),
                'content' => $request->input('content'),
                'desc' => $request->input('desc'),
                'cat_id' => $request->input('cat_id'),
                'status' => $request->input('status'),
                'thumbnail' => $thumbnail
            ]);
        } else {
            Post::withTrashed()->where('id', $id)->update([
                'title' => $request->input('title'),
                'content' => $request->input('content'),
                'desc' => $request->input('desc'),
                'cat_id' => $request->input('cat_id'),
                'status' => $request->input('status'),
            ]);
        }
        return redirect('admin/post/list')->with('status', 'Cập nhật thành công');
    }
    //====================Action========================
    function action(Request $request)
    {
        $check_list = $request->input('check_list');
        if ($check_list) {
            if ($request->input('act') != 'NULL') {
                $act = $request->input('act');
                if ($act == 'delete') {
                    Post::whereIn('id', $check_list)
                        ->update(['status' => '3', 'hot' => NULL]);
                    Post::destroy($check_list);
                    return redirect('admin/post/list')->with('status', 'Đã thêm vào thùng rác');
                }
                if ($act == 'changeStatus') {
                    Post::whereIn('id', $check_list)
                        ->update(['status' => '2']);
                    return redirect('admin/post/list')->with('status', 'Duyệt thành công');
                }
                if ($act == 'hot') {
                    Post::whereIn('id', $check_list)
                        ->update(['hot' => 'On', 'status' => '2']);
                    return redirect('admin/post/list')->with('status', 'Cập nhật thành công');
                }
                if ($act == 'normal') {
                    Post::whereIn('id', $check_list)
                        ->update(['hot' => NULL]);
                    return redirect('admin/post/list')->with('status', 'Cập nhật thành công');
                }
                if ($act == 'restore') {
                    Post::onlyTrashed()
                        ->whereIn('id', $check_list)
                        ->update(['status' => '1', 'hot' => NULL]);
                    Post::onlyTrashed()
                        ->whereIn('id', $check_list)
                        ->restore();
                    return redirect('admin/post/list')->with('status', 'Khôi phục dữ liệu thành công');
                }
                if ($act == 'forceDelete') {
                    Post::onlyTrashed()
                        ->whereIn('id', $check_list)
                        ->forceDelete();
                    return redirect('admin/post/list')->with('status', 'Xóa vĩnh viễn thành công');
                }
            } else {
                return redirect('admin/post/list')->with('alert', 'Hãy chọn 1 tác vụ');
            }
        } else {
            return redirect('admin/post/list')->with('alert', 'Hãy chọn ít nhất 1 phần tử');
        }
    }
}
