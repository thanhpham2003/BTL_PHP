jQuery(document).ready(function(){
    $("body").append("<div id='modal-popup'></div>");
    $(".js-show-modal1").click(function(){
        $("#modal-popup").empty();
        let productId = $(this).data("id");
        $.ajax({
            url: `/product/show-modal-detail/${productId}`,
            dataType: "json",
            success: function(response){
                $("#modal-popup").append(response.content);
                $("#modal-popup .wrap-modal1").addClass("show-modal show-modal1");
                // Đóng modal khi bấm vào overlay hoặc nút đóng
                $(".js-hide-modal1").click(function(){
                    $("#modal-popup .wrap-modal1").removeClass("show-modal show-modal1");
                })
                $('#modal-popup .gallery-lb').each(function() { // the containers for all your galleries
                    $(this).magnificPopup({
                        delegate: 'a', // the selector for gallery item
                        type: 'image',
                        gallery: {
                            enabled:true
                        },
                        mainClass: 'mfp-fade'
                    });
                });
            },
            error: function(xhr) {
                Swal.fire({
                    title: "Cảnh báo!",
                    text: "Có lỗi trong quá trình hiển thị",
                    icon: "warning"
                  });
            }
        });
    })
});

$(document).on("click", ".js-addcart-detail", function(){
    let productId = $(this).data("id");
    let sizeId = $(".size-button.active").data("size-id");
    let sizeName = $(".size-button.active").data("size");
    let quantity = $(".show-modal #quantity-product").val();
    console.log(quantity);

    if (!sizeId) {
        Swal.fire({
            title: "Chưa chọn size!",
            text: "Vui lòng chọn size trước khi thêm vào giỏ hàng.",
            icon: "warning"
        });
        return;
    }

    $.ajax({
        url: "/cart/add",
        type: "POST",
        data: {
            id: productId,
            size_id: sizeId,
            size_name: sizeName,
            quantity: quantity
        },
        success: function(response) {
            Swal.fire({
                title: "Thành công!",
                text: "Sản phẩm đã được thêm vào giỏ hàng.",
                icon: "success"
            });
            // console.log(response);
            $(".cart-content").html(response.cart_content);
            // $(".icon-header-noti").attr("data-notify", response.total_items);
        },
        error: function(){

        }
    });
});

jQuery(document).ready(function() {
    // Bấm chọn size
    $(".size-button").click(function() {
        if ($(this).hasClass("disabled")) return; // Không làm gì nếu size không có sẵn

        $(".size-button").removeClass("active"); // Xóa active khỏi tất cả
        $(this).addClass("active"); // Đánh dấu size đã chọn

        let sizeId = $(this).data("size-id");
        let sizeName = $(this).data("size-name");

        $("#selected-size-id").val(sizeId);
        $("#selected-size-name").val(sizeName);
    });

    // Thêm vào giỏ hàng
    
});

$(document).ready(function() {
    // Xử lý xóa sản phẩm khỏi giỏ hàng
    $(document).on("click", ".btn-remove-cart", function() {
        let button = $(this);
        let rowId = button.data("rowid");
        let productId = button.data("id"); 
        let url = button.data("url").replace(':id', productId);

        // Hiển thị hộp thoại xác nhận
        Swal.fire({
            title: "Bạn có chắc chắn?",
            text: "Sản phẩm này sẽ bị xóa khỏi giỏ hàng!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Có, xóa ngay!",
            cancelButtonText: "Hủy"
        }).then((result) => {
            if (result.isConfirmed) {
                // Nếu người dùng đồng ý xóa
                $.ajax({
                    url: "/cart/remove",
                    type: "POST",
                    data: {
                        rowId: rowId,
                        _method: "DELETE",
                    },
                    success: function(response) {
                        if (response.success) {
                            $(".cart-content").html(response.cart_content);
                            Swal.fire({
                                title: "Đã xóa!",
                                text: "Sản phẩm đã được xóa khỏi giỏ hàng.",
                                icon: "success"
                            });
                        } else {
                            Swal.fire({
                                title: "Lỗi!",
                                text: "Không thể xóa sản phẩm.",
                                icon: "error"
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            title: "Lỗi!",
                            text: "Có lỗi xảy ra, vui lòng thử lại.",
                            icon: "error"
                        });
                    }
                });
            }
        });
    });
});




