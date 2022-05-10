<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/ico" href="{{ url('public/images/ismart.ico') }}" />
    {{-- Style --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/solid.min.css">
    <link rel="stylesheet" href="{{ url('/public/css/style.css') }}">
    {{-- Dropzone --}}
    <link rel="stylesheet" href="{{ url('public/css/dropzone.min.css') }}">
    {{-- Toastr thư viện thông báo --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <title>ISMART.COM | Trang quản trị</title>
</head>

<body>
    <div id="warpper" class="nav-fixed">
        <nav class="topnav shadow navbar-light bg-white d-flex">
            <div class="navbar-brand"><a href="{{ url('/admin') }}">TRANG QUẢN TRỊ</a></div>
            <div class="nav-right ">
                <div class="btn-group mr-auto">
                    <button type="button" class="btn dropdown" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="plus-icon fas fa-plus-circle"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ url('admin/post/add') }}">Thêm bài viết</a>
                        <a class="dropdown-item" href="{{ url('admin/product/add') }}">Thêm sản phẩm</a>
                        <a class="dropdown-item" href="{{ url('admin/slider/add') }}">Thêm slider</a>
                    </div>
                </div>
                <a href="{{ url('/') }}" class="btn btn-danger ml-auto" target="_blank">Trang chủ Website</a>
                <div class="btn-group">
                    <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        {{ Auth::user()->name }}
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="#">Tài khoản</a>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </nav>
        <!-- end nav  -->
        @php
            $module_active = session('module_active');
        @endphp
        <div id="page-body" class="d-flex">
            <div id="sidebar" class="bg-white">
                <ul id="sidebar-menu">
                    <li class="nav-link {{ $module_active == 'admin' ? 'active' : '' }}">
                        <a href="{{ url('/admin') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="fa fa-home"></i>
                            </div>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-link {{ $module_active == 'page' ? 'active' : '' }}">
                        <a href="{{ url('admin/page/list') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="far fa-map"></i>
                            </div>
                            Trang
                        </a>
                        <i class="arrow fas fa-angle-right"></i>
                        <ul class="sub-menu">
                            <li><a href="{{ url('admin/page/add') }}">Thêm mới</a></li>
                            <li><a href="{{ url('admin/page/list') }}">Danh sách</a></li>
                        </ul>
                    </li>
                    <li class="nav-link {{ $module_active == 'cat' ? 'active' : '' }}">
                        <a href="{{ url('admin/cat/list') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="far fa-bookmark"></i>
                            </div>
                            Danh mục
                        </a>
                        <i class="arrow fas fa-angle-right"></i>
                        <ul class="sub-menu">
                            <li><a href="{{ url('admin/cat/add') }}">Thêm mới</a></li>
                            <li><a href="{{ url('admin/cat/list') }}">Danh sách</a></li>
                        </ul>
                    </li>
                    <li class="nav-link {{ $module_active == 'post' ? 'active' : '' }}">
                        <a href="{{ url('admin/post/list') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="fas fa-edit"></i>
                            </div>
                            Bài viết
                        </a>
                        <i class="arrow fas fa-angle-right"></i>
                        <ul class="sub-menu">
                            <li><a href="{{ url('admin/post/add') }}">Thêm mới</a></li>
                            <li><a href="{{ url('admin/post/list') }}">Danh sách</a></li>
                        </ul>
                    </li>
                    <li class="nav-link {{ $module_active == 'product' ? 'active' : '' }}">
                        <a href="{{ url('admin/product/list') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="fas fa-box-open"></i>
                            </div>
                            Sản phẩm
                        </a>
                        <i class="arrow fas fa-angle-right"></i>
                        <ul class="sub-menu">
                            <li><a href="{{ url('admin/product/add') }}">Thêm mới</a></li>
                            <li><a href="{{ url('admin/product/list') }}">Danh sách</a></li>
                        </ul>
                    </li>
                    <li class="nav-link {{ $module_active == 'brand' ? 'active' : '' }}">
                        <a href="{{ url('admin/brand/list') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="fas fa-store"></i>
                            </div>
                            Nhãn hàng
                        </a>
                        <i class="arrow fas fa-angle-right"></i>
                        <ul class="sub-menu">
                            <li><a href="{{ url('admin/brand/add') }}">Thêm mới</a></li>
                            <li><a href="{{ url('admin/brand/list') }}">Danh sách</a></li>
                        </ul>
                    </li>
                    <li class="nav-link {{ $module_active == 'order' ? 'active' : '' }}">
                        <a href="{{ url('admin/order/list') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            Bán hàng
                        </a>
                        <i class="arrow fas fa-angle-right"></i>
                        <ul class="sub-menu">
                            <li><a href="{{ url('admin/order/list') }}">Danh sách</a></li>
                        </ul>
                    </li>
                    <li class="nav-link {{ $module_active == 'slider' ? 'active' : '' }}">
                        <a href="{{ url('admin/slider/list') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="fas fa-photo-video"></i>
                            </div>
                            Slider
                        </a>
                        <i class="arrow fas fa-angle-right"></i>
                        <ul class="sub-menu">
                            <li><a href="{{ url('admin/slider/add') }}">Thêm mới</a></li>
                            <li><a href="{{ url('admin/slider/list') }}">Danh sách</a></li>
                        </ul>
                    </li>
                    <li class="nav-link {{ $module_active == 'user' ? 'active' : '' }}">
                        <a href="{{ url('admin/user/list') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="fa fa-user"></i>
                            </div>
                            Users
                        </a>
                        <i class="arrow fas fa-angle-right"></i>
                        <ul class="sub-menu">
                            <li><a href="{{ url('admin/user/add') }}">Thêm mới</a></li>
                            <li><a href="{{ url('admin/user/list') }}">Danh sách</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div id="wp-content">
                @yield('content');
            </div>
        </div>
    </div>
    <script src="{{ url('public/js/plugins/ckeditor/ckeditor.js') }}" type="text/javascript"></script>
    <script src="{{ url('public/js/plugins/ckfinder/ckfinder.js') }}" type="text/javascript"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="{{ url('public/js/app.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    {{-- Toastr thư viện thông báo --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    {{-- sweetAlert --}}
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    @if (Session::has('status'))
        <script>
            swal("Thành công !", "{{ session('status') }}", "success", {
                button: "OK",
            });
        </script>
    @endif
    @if (Session::has('alert'))
        <script>
            swal("Lỗi !", "{{ session('alert') }}", "error", {
                button: "OK",
            });
        </script>
    @endif
    {{-- Dropzone --}}
    <script src="{{ url('public/js/dropzone.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('public/js/app.js') }}"></script>

    <script>
        if (document.getElementById('dropzone')) {
            Dropzone.autoDiscover = false;
            var myDropzone = new Dropzone("div#dropzone", {
                url: "http://localhost/Laravel/Lesson/LaravelIsmart/admin/product/uploadFile",
                paramName: "file",
                uploadMultiple: true, // uplaod files in a single request
                parallelUploads: 100, // use it with uploadMultiple
                maxFiles: 10,
                acceptedFiles: ".jpg, .jpeg, .png",
                addRemoveLinks: true,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                // Language Strings
                dictInvalidFileType: "File tải lên không hợp lệ",
                dictCancelUpload: "Cancel",
                dictRemoveFile: "Xóa",
                dictFileTooBig: 'Kích thước file quá lớn',
                dictDefaultMessage: "Kéo thả hình ảnh để tải lên",
                //Update hình ảnh
                init: function() {
                    @if (isset($product))
                    var myDropzone = this;
                    $.get("{{ url('admin/product/getImages', $product->id) }}", function(data) {
                        //console.log(data);
                        $.each(data, function(i, mockFile) {
                            //console.log(mockFile);
                            var url =
                                "http://localhost/Laravel/Lesson/LaravelIsmart/public/storage/" +
                                mockFile.image;
                            var alt = mockFile.alt;
                            var name = mockFile.image;
                            var size = mockFile.size;
                            var mockFile = {
                                name: name,
                                size: size
                            };
                            myDropzone.options.addedfile.call(myDropzone, mockFile);
                            myDropzone.options.thumbnail.call(myDropzone, mockFile, url);
                            mockFile.previewElement.classList.add('dz-success');
                            mockFile.previewElement.classList.add('dz-complete');
                            mockFile._captionBox = Dropzone.createElement(
                                "<input type='text' name='alt[]' class='image_alt' autocomplete='off' placeholder='mô tả (viết liền)' value=" + alt + " >");
                            mockFile._image = Dropzone.createElement(
                                "<input type='hidden' name='images[]' value=" + name + " >");
                            mockFile._size = Dropzone.createElement(
                                "<input type='hidden' name='size[]' value=" + size + " >");
                            mockFile.previewElement.appendChild(mockFile._captionBox);
                            mockFile.previewElement.appendChild(mockFile._image);
                            mockFile.previewElement.appendChild(mockFile._size);
                        });
                    });
                    @endif
                },
                //Khi xóa 1 ảnh trong dropzone
                removedfile: function(file) {
                    $('.dz-message').remove();
                    var _ref;
                    return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file
                        .previewElement) : void 0;
                }
            });
            myDropzone.on("addedfile", function(file) {
                caption = file.caption == undefined ? "" : file.caption;
                file._captionBox = Dropzone.createElement("<input type='text' name='alt[]' autocomplete='off' placeholder='mô tả (viết liền)' class='image_alt' value=" + caption +
                    " >");
                file._image = Dropzone.createElement("<input type='hidden' name='images[]' value=" + file.name +
                    " >");
                file._size = Dropzone.createElement("<input type='hidden' name='size[]' value=" + file.size + " >");
                file.previewElement.appendChild(file._captionBox);
                file.previewElement.appendChild(file._image);
                file.previewElement.appendChild(file._size);
            });
            $( function() {
                $( "#dropzone" ).sortable({
                    delay: 500,
                    cursor: "move",
                });
                $( "#dropzone" ).disableSelection();
            });
        }
    </script>
    {{-- Sort jquery --}}
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</body>

</html>
