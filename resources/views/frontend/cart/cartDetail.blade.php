@extends('frontend.layout')
@section('content')
    <style>
        .table-shopping-cart th,
        .table-shopping-cart td {
            padding: 15px;
            /* Tăng padding để cột rộng hơn */
            font-size: 16px;
            /* Tăng kích thước chữ nếu cần */
        }

        .column-1 {
            width: 15%;
        }

        .column-2 {
            width: 30%;
        }

        .column-3,
        .column-4,
        .column-5,
        .column-6 {
            width: 15%;
            text-align: center;
        }

        .checkout-input input {
            width: 100%;
            padding: 12px;
            margin-top: 8px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }

        .checkout-select select {
            width: 100%;
            padding: 12px;
            margin-top: 8px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            background: #fff;
            cursor: pointer;
        }

        .checkout-btn {
            width: 100%;
            padding: 14px;
            margin-top: 20px;
            background: #000;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .checkout-btn:hover {
            background: #444;
        }
    </style>
    <!-- breadcrumb -->
    <div class="container" style="margin-top:100px">
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
            <a href="{{ route('fr.homepage') }}" class="stext-109 cl8 hov-cl1 trans-04">
                Trang chủ
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>

            <span class="stext-109 cl4">
                Giỏ hàng
            </span>
        </div>
    </div>


    <!-- Shoping Cart -->
    <form class="bg0 p-t-75 p-b-85" action="{{ route('fr.order') }}" method="POST">
        @csrf
        <div class="container">
            <div class="row">
                <!-- Bảng sản phẩm -->
                <div class="col-lg-8 col-xl-8 m-b-50">
                    <div class="wrap-table-shopping-cart">
                        <table class="table-shopping-cart">
                            <tr class="table_head">
                                <th class="column-1 text-left">SẢN PHẨM</th>
                                <th class="column-2"></th>
                                <th class="column-3 text-center">SIZE</th>
                                <th class="column-4 text-center">GIÁ</th>
                                <th class="column-5 text-center">SỐ LƯỢNG</th>
                                <th class="column-6 text-center">THÀNH TIỀN</th>
                            </tr>
                            @foreach ($cart->content() as $key => $item)
                                <tr class="table_row">
                                    <td class="column-1">
                                        <div class="how-itemcart1">
                                            <img src="{{ $item->product->thumb }}" alt="IMG">
                                        </div>
                                    </td>
                                    <td class="column-2">{{ $item->product->name }}</td>
                                    <td class="column-3 text-center">{{ $item->getSize()->name }}</td>
                                    <td class="column-4 text-center">
                                        @if ($item->product->price_sale && $item->product->price_sale < $item->product->price)
                                            <span class="item-price" data-price="{{ $item->product->price_sale }}">
                                                {{ number_format($item->product->price_sale) }} VND
                                            </span>
                                        @else
                                            <span class="item-price" data-price="{{ $item->product->price }}">
                                                {{ number_format($item->product->price) }} VND
                                            </span>
                                        @endif
                                    </td>
                                    <td class="column-5 text-center">
                                        <div class="wrap-num-product flex-w m-l-auto m-r-0">
                                            <div class="btn-num-product-down-cart cl8 hov-btn3 trans-04 flex-c-m">
                                                <i class="fs-16 zmdi zmdi-minus"></i>
                                            </div>
                                            <input class="mtext-104 cl3 txt-center num-product" type="number"
                                                name="num-product1" data-item-id="{{ $key }}"
                                                value="{{ $item->quantity }}" min="1">
                                            <div class="btn-num-product-up-cart cl8 hov-btn3 trans-04 flex-c-m">
                                                <i class="fs-16 zmdi zmdi-plus"></i>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="column-6 text-center">
                                        <span class="item-total">
                                            {{ number_format(($item->product->price_sale ?? $item->product->price) * $item->quantity) }}
                                            VND
                                        </span>
                                        <button class="btn-remove-cart" data-url="{{ route('cart.remove', ':id') }}"
                                            data-rowid="{{ $item->product->id }}_{{ $item->getSize()->id }}">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>

                <!-- Hóa đơn -->
                <div class="col-lg-4 col-xl-4">
                    <div class="bor10 p-lr-40 p-t-30 p-b-40 p-lr-15-sm">
                        <h4 class="mtext-109 cl2 p-b-30">Hóa đơn</h4>
                        <div class="flex-w flex-t bor12 p-b-13">
                            <div class="size-208">
                                <span class="stext-110 cl2">Tổng:</span>
                            </div>
                            <div class="size-209">
                                <span class="mtext-110 cl2">{{ $cart->total() }} VND</span>
                            </div>
                        </div>

                        <!-- Thông tin giao hàng -->
                        <div class="p-t-20">
                            <span class="stext-110 cl2">Thông tin giao hàng:</span>
                            <div class="checkout-input">
                                <input type="text" id="name" name="name" placeholder="Họ và tên" required>
                            </div>
                            <div class="checkout-input">
                                <input type="text" id="phone" name="phone" placeholder="Số điện thoại" required>
                            </div>
                            <div class="checkout-input">
                                <input type="text" id="address" name="address" placeholder="Địa chỉ giao hàng"
                                    required>
                            </div>
                        </div>

                        <!-- Chọn hình thức thanh toán -->
                        <div class="p-t-15">
                            <span class="stext-112 cl2">Chọn hình thức thanh toán:</span>
                            <div class="checkout-select">
                                <select name="payment_method">
                                    <option value="cod">Thanh toán khi nhận hàng (COD)</option>
                                    <option value="momo">Thanh toán qua Momo</option>
                                </select>
                            </div>
                        </div>

                        <!-- Nút đặt hàng -->
                        <button class="checkout-btn">ĐẶT HÀNG</button>
                    </div>
                </div>
            </div>
        </div>

    </form>


    <!-- Back to top -->
    <div class="btn-back-to-top" id="myBtn">
        <span class="symbol-btn-back-to-top">
            <i class="zmdi zmdi-chevron-up"></i>
        </span>
    </div>
    <script>
        $(document).ready(function() {
            var processing = false;
            $('.btn-num-product-up-cart, .btn-num-product-down-cart').off('click').on('click', function(e) {
                e.preventDefault(); // Ngăn chặn sự kiện chạy 2 lần nếu form có submit
                if (processing == true) return;
                processing = true;
                let row = $(this).closest('tr');
                let input = row.find('.num-product');
                let newValue = parseInt(input.val()) + ($(this).hasClass('btn-num-product-up-cart') ? 1 : -
                    1);
                newValue = Math.max(1, newValue); // Không cho số lượng < 1
                input.val(newValue);
                $.ajax({
                    url: "{{ route('cart.update') }}",
                    method: "POST",
                    data: {
                        rowId: input.data("item-id"),
                        quantity: newValue
                    },
                    success: function(res) {
                        $('.mtext-110.cl2').text(res.total.toLocaleString('vi-VN') + ' VND');
                        row.find('.item-total').text(res.row_total.toLocaleString('vi-VN') +
                            ' VND');
                    },
                    error: function(xhr) {
                        console.log(xhr);
                    },
                }).always(function() {
                    processing = false;
                });
            });

            $('.num-product').off('input').on('input', function() {
                let row = $(this).closest('tr');
                updateTotal(row);
            });

            // Cập nhật tổng tiền khi load trang
            $('.table-shopping-cart tr').each(function() {
                updateTotal($(this));
            });
        });
    </script>

    <script>
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
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelector(".checkout-btn").addEventListener("click", function(e) {
                e.preventDefault(); // Ngăn form submit mặc định

                let name = document.querySelector("input[name='name']").value.trim();
                let phone = document.querySelector("input[name='phone']").value.trim();
                let address = document.querySelector("input[name='address']").value.trim();
                let cartCount =
                    {{ count($cart->content()) }}; // Truyền số lượng sản phẩm từ Laravel vào JS

                if (!name || !phone || !address) {
                    Swal.fire({
                        icon: "error",
                        title: "Lỗi!",
                        text: "Vui lòng nhập đầy đủ họ tên, số điện thoại và địa chỉ giao hàng.",
                    });
                    return;
                }

                if (cartCount == 0) {
                    Swal.fire({
                        icon: "error",
                        title: "Lỗi!",
                        text: "Giỏ hàng của bạn đang trống.",
                    });
                    return;
                }

                $.ajax({
                    url: "{{ route('fr.order') }}",
                    method: "POST",
                    data: $('form').serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Bạn đã đặt hàng thành công',
                            text: 'Cảm ơn bạn.',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed || result.dismiss === Swal
                                .DismissReason.timer) {
                                window.location.href = '/';
                            }
                        });
                    },

                    error: function(xhr) {
                        alert('Lỗi: ' + xhr.responseJSON.message);
                    }
                });

            });


        });
    </script>
@endsection
