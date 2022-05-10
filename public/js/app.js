$(document).ready(function () {
    $(".nav-link.active .sub-menu").slideDown();
    // $("p").slideUp();

    $("#sidebar-menu .arrow").click(function () {
        $(this).parents("li").children(".sub-menu").slideToggle();
        $(this).toggleClass("fa-angle-right fa-angle-down");
    });

    $("input[name='checkall']").click(function () {
        var checked = $(this).is(":checked");
        $(".table-checkall tbody tr td input:checkbox").prop(
            "checked",
            checked
        );
    });

    //============================== Ajax update ====================================

    $("input.num-order").change(function () {
        /* lấy dữ liệu từ view */
        var id = $(this).attr("data-id");
        var url = $(this).attr("data-url");
        var qty = $(this).val();
        var data = { id: id, qty: qty };
        // đổ sang file xử lý
        $.ajax({
            url: url,
            method: "GET",
            data: data,
            dataType: "json",
            // xủ lý xong đổ ra đây
            success: function (data) {
                $("td#sub-total-" + id + " span#sub-total-num").text(
                    data.sub_total
                );
                $("p#total-price span#total-num").text(data.total);
                $("a#btn-cart span#num").text(data.num_order);
                $("div#dropdown p.desc span").text(data.num_order);
                $("div.total-price p.price").text(data.total);
                $("div.info p.qty span").text(data.num_per_product);
            },
            // kra lỗi
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            },
        });
    });

    //============================== Ajax add Cart==================================
    $("a.add-cart").on("click", function () {
        event.preventDefault();
        /* lấy dữ liệu từ view */
        var url = $(this).attr("data-url");
        var data = {};
        $.ajax({
            url: url,
            method: "GET",
            data: data,
            dataType: "json",
            success: function (data) {
                $("a#btn-cart span#num").text(data.num_order);
                $("div#dropdown p.desc span").text(data.num_order);
                $("div.total-price p.price").text(data.total);
                swal("Thành công !", "Đã thêm vào giỏ hàng", "success").then(
                    (value) => {
                        location.reload();
                    }
                );
            },
            // kra lỗi
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            },
        });
    });

});

    //====================== Xóa bằng Ajax ====================
    function Delete(url) {
        sweetAlert("Xóa trang", "Bạn có chắc chắn muốn xóa?", "warning").then(
            (willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: "GET",
                        url: url,
                        dataType: "json",
                        success: function (data) {
                            console.log(data.title);
                            swal("Thành công !", data.title, "success").then(
                                (value) => {
                                    location.reload();
                                }
                            );
                        },
                    });
                }
            }
        );
    }

    function sweetAlert(title, text, icon) {
        return swal({
            title: title,
            text: text,
            icon: icon,
            buttons: true,
            dangerMode: true,
        });
    }
//=================== Update Hot ===================================
function changeHot(id, hot) {
    $.ajax({
        type: "GET",
        url: "http://localhost/Laravel/Lesson/LaravelIsmart/admin/page/quickUpdate",
        dataType: "json",
        data:{
            id: id,
            hot: hot,
            type: "changeHot",
        },
        success: function (data) {
            let current = $('.hot-' + id);
            //Cấu hình cho thông báo
            toastr.options.closeMethod = 'fadeOut';
            toastr.options.closeDuration = 300;
            toastr.options.closeEasing = 'swing';
            toastr.options.closeButton = true;
            toastr.success('Chỉnh sửa thành công');
            $(current).replaceWith(data.html);
        }
    });
}
//============== Update Status ===========================

$(document).ready(function(){
    $('select[name=status]').change(function(e){
        e.stopImmediatePropagation(); //sửa lỗi event thực hiện 2 lần
        let value = $(this).val();
        let id = $(this).attr('data-id');
        console.log(id);
        $.ajax({
            type: "GET",
            url: "http://localhost/Laravel/Lesson/LaravelIsmart/admin/page/quickUpdate",
            data: {
                id: id,
                status: value,
                type: "changeStatus",
            },
            dataType: "json",
            success: function (data) {
                toastr.options.closeMethod = 'fadeOut';
                toastr.options.closeDuration = 300;
                toastr.options.closeEasing = 'swing';
                toastr.options.closeButton = true;
                toastr.success('Chỉnh sửa thành công');
            }
        });
    });
});

