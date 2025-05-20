@extends('frontend.layout')
@section('content')
    <style>
        .size-button {
            padding: 10px 15px;
            border: 1px solid #ccc;
            background-color: white;
            cursor: pointer;
            margin-right: 10px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .size-button:hover {
            background-color: black;
            color: white;
        }

        .size-button.active {
            background-color: black !important;
            color: white !important;
            border-color: black !important;
        }



        .size-button.disabled {
            opacity: 0.5;
            pointer-events: none;
            cursor: not-allowed;
        }
    </style>
    <div class="container" style="margin-top:100px">
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
            <!-- Link Trang chủ -->
            <a href="{{ route('fr.product') }}" class="stext-109 cl8 hov-cl1 trans-04">
                Trang chủ
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>

            <!-- Nếu có danh mục cha cấp cao nhất -->
            @if ($rootCategory)
                <a href="{{ route('fr.product', ['menu_id' => $rootCategory->id]) }}" class="stext-109 cl8 hov-cl1 trans-04">
                    {{ $rootCategory->name }}
                    <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
                </a>
            @endif

            <!-- Nếu có danh mục cha -->
            @if ($parentCategory)
                <a href="{{ route('fr.product', ['menu_id' => $parentCategory->id]) }}"
                    class="stext-109 cl8 hov-cl1 trans-04">
                    {{ $parentCategory->name }}
                    <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
                </a>
            @endif

            <!-- Hiển thị danh mục sản phẩm -->
            <a href="{{ route('fr.product', ['menu_id' => $category->id]) }}" class="stext-109 cl8 hov-cl1 trans-04">
                {{ $category->name }}
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>

            <!-- Hiển thị tên sản phẩm -->
            <span class="stext-109 cl4">
                {{ $product->name }}
            </span>
        </div>
    </div>




    <!-- Product Detail -->
    <section class="sec-product-detail bg0 p-t-65 p-b-60">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-7 p-b-30">
                    <div class="p-l-25 p-r-30 p-lr-0-lg">
                        <div class="wrap-slick-my flex-sb flex-w">
                            <div class="slick3 gallery-lb">
                                <div class="item-slick3" data-thumb="images/product-detail-01.jpg">

                                    <div class="wrap-pic-w pos-relative">
                                        <img src="{{ $product->thumb }}" alt="IMG-PRODUCT">

                                        <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
                                            href="{{ $product->thumb }}">
                                            <i class="fa fa-expand"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-5 p-b-30">
                    <div class="p-r-50 p-t-5 p-lr-0-lg">
                        <h4 class="mtext-105 cl2 js-name-detail p-b-14">
                            {{ $product->name }}
                        </h4>

                        <span class="mtext-106 cl2 js-price-detail">
                            @if ($product->price_sale)
                                <span class="original-price"
                                    style="text-decoration: line-through; color: gray;">{{ number_format($product->price) }}
                                    VND</span>
                                <span class="sale-price"
                                    style="color: red; font-weight: bold;">{{ number_format($product->price_sale) }}
                                    VND</span>
                            @else
                                <span class="current-price">{{ number_format($product->price, 0) }} VND</span>
                            @endif
                        </span>

                        <p class="stext-102 cl3 p-t-23 js-description-detail">
                            {!! $product->description !!}
                        </p>

                        <!--  -->
                        <div class="p-t-33">
                            <div class="flex-w flex-r-m p-b-10">
                                <div class="size-203 flex-c-m respon6">Size</div>
                                <div class="size-204 respon6-next">
                                    <div class="flex-w">
                                        @foreach ($sizes as $size)
                                            <button type="button"
                                                class="size-button {{ in_array($size->id, $availableSizes) ? '' : 'disabled' }}"
                                                data-size="{{ $size->name }}" data-size-id="{{ $size->id }}"
                                                {{ in_array($size->id, $availableSizes) ? '' : 'disabled' }}>
                                                {{ $size->name }}
                                            </button>
                                        @endforeach

                                    </div>
                                </div>
                            </div>

                            <div class="flex-w flex-r-m p-b-10">
                                <div class="size-204 flex-w flex-m respon6-next">

                                    <div class="wrap-num-product flex-w m-r-20 m-tb-10">

                                        <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                            <i class="fs-16 zmdi zmdi-minus"></i>
                                        </div>

                                        <input class="mtext-104 cl3 txt-center num-product" id="quantity-product"
                                            type="number" name="num-product" value="1">

                                        <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                            <i class="fs-16 zmdi zmdi-plus"></i>
                                        </div>
                                    </div>

                                    <button
                                        class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail1"
                                        data-id="{{ $product->id }}">
                                        Thêm vào giỏ hàng
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bor10 m-t-50 p-t-43 p-b-40">
                <!-- Tab01 -->
                <div class="tab01">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item p-b-10">
                            <a class="nav-link active" data-toggle="tab" href="#description" role="tab">Mô tả</a>
                        </li>

                        <li class="nav-item p-b-10">
                            <a class="nav-link" data-toggle="tab" href="#reviews" role="tab">Đánh giá (
                                {{ $reviewCount }} )</a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content p-t-43">
                        <!-- - -->
                        <div class="tab-pane fade show active" id="description" role="tabpanel">
                            <div class="how-pos2 p-lr-15-md">
                                <p class="stext-102 cl6">
                                    {!! $product->content !!}
                                </p>
                            </div>
                        </div>

                        <!-- - -->
                        <div class="tab-pane fade" id="reviews" role="tabpanel">
                            <div class="row">
                                <div class="col-sm-10 col-md-8 col-lg-6 m-lr-auto">
                                    <div class="p-b-30 m-lr-15-sm">
                                        <!-- Review -->
                                        @if ($product->reviews && $product->reviews->count())
                                            @foreach ($product->reviews as $review)
                                                <div class="flex-w flex-t p-b-68">
                                                    <div class="wrap-pic-s size-109 bor0 of-hidden m-r-18 m-t-6">
                                                        <img src="{{ asset('template/images/download.png') }}"
                                                            alt="AVATAR">
                                                    </div>
                                                    <div class="size-207">
                                                        <div class="flex-w flex-sb-m p-b-17">
                                                            <span class="mtext-107 cl2 p-r-20">
                                                                {{ $review->user->name }}
                                                            </span>
                                                            <span class="fs-18 cl11">
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    <i
                                                                        class="zmdi {{ $i <= $review->rating ? 'zmdi-star' : 'zmdi-star-outline' }}"></i>
                                                                @endfor
                                                            </span>
                                                        </div>
                                                        <p class="stext-102 cl6">
                                                            {{ $review->comment }}
                                                        </p>

                                                        <!-- Kiểm tra nếu có phản hồi từ admin -->
                                                        @if ($review->admin_reply)
                                                            <div class="admin-reply mt-4">
                                                                <strong>Phản hồi từ Admin:</strong>
                                                                <p class="stext-102 cl6"
                                                                    style="margin-left: 20px; font-style: italic; color: #007bff;">
                                                                    {{ $review->admin_reply }}
                                                                </p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <p>Chưa có đánh giá nào cho sản phẩm này.</p>
                                        @endif


                                        <!-- Add review -->
                                        <form class="w-full" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <div class="flex-w flex-m p-t-50 p-b-23">
                                                <span class="wrap-rating fs-18 cl11 pointer">
                                                    <i class="item-rating pointer zmdi zmdi-star-outline"></i>

                                                    <i class="item-rating pointer zmdi zmdi-star-outline"></i>

                                                    <i class="item-rating pointer zmdi zmdi-star-outline"></i>

                                                    <i class="item-rating pointer zmdi zmdi-star-outline"></i>

                                                    <i class="item-rating pointer zmdi zmdi-star-outline"></i>
                                                    <input class="dis-none" type="hidden" name="rating"
                                                        value="">

                                                </span>
                                            </div>



                                            <div class="row p-b-25">
                                                <div class="col-12 p-b-5">
                                                    <label class="stext-102 cl3" for="review">Đánh giá của bạn</label>
                                                    <textarea class="size-110 bor8 stext-102 cl2 p-lr-20 p-tb-10" id="review" name="review"></textarea>
                                                </div>
                                            </div>

                                            <button
                                                class="flex-c-m stext-101 cl0 size-112 bg7 bor11 hov-btn3 p-lr-15 trans-04 m-b-10">
                                                Gửi
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg6 flex-c-m flex-w size-302 m-t-73 p-tb-15">
            <span class="stext-107 cl6 p-lr-25">
                Mã: Pmou-{{ $product->id }}
            </span>

            <span class="stext-107 cl6 p-lr-25">
                Loại:
                @if ($rootCategory)
                    {{ $rootCategory->name }},
                @endif
                @if ($parentCategory)
                    {{ $parentCategory->name }},
                @endif
                {{ $category->name }}
            </span>

        </div>
    </section>

    <script>
        $(document).ready(function() {
            $('form').submit(function(e) {
                e.preventDefault();

                var isAuthenticated =
                    {{ auth()->check() ? 'true' : 'false' }}; // Kiểm tra trạng thái đăng nhập

                if (!isAuthenticated) {
                    // Nếu chưa đăng nhập, hiển thị thông báo lỗi bằng SweetAlert
                    Swal.fire({
                        icon: 'warning',
                        title: 'Bạn chưa đăng nhập',
                        text: 'Vui lòng đăng nhập để thực hiện đánh giá.',
                        confirmButtonText: 'Đăng nhập',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Điều hướng đến trang đăng nhập nếu người dùng nhấn nút "Đăng nhập"
                            window.location.href = "{{ route('fr.login') }}";
                        }
                    });
                    return;
                }

                var rating = $('input[name="rating"]').val();
                // Kiểm tra giá trị của rating
                if (!rating || rating < 1 || rating > 5) {
                    alert("Vui lòng chọn đánh giá hợp lệ (1-5 sao).");
                    return;
                }

                $.ajax({
                    url: "{{ route('fr.review.send') }}",
                    method: "POST",
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Đánh giá của bạn đã được gửi!',
                            text: 'Cảm ơn bạn đã để lại đánh giá.',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            location.reload();
                        });
                    },

                    error: function(xhr) {
                        alert('Lỗi: ' + xhr.responseJSON.message);
                    }
                });
            });
        });
    </script>

    <script src="{{ asset('js/public.js') }}"></script>

    <script src={{ asset('template/js/product.js?v=' . time()) }}></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sizeButtons = document.querySelectorAll('.size-button');

            sizeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Kiểm tra nếu button bị disabled thì không làm gì cả
                    if (this.classList.contains('disabled')) {
                        return;
                    }

                    // Bỏ class "active" khỏi tất cả các button
                    sizeButtons.forEach(btn => btn.classList.remove('active'));

                    // Thêm class "active" vào button được bấm
                    this.classList.add('active');

                    // Lấy giá trị size đã chọn
                    const selectedSize = this.getAttribute('data-size');
                    console.log("Size đã chọn:", selectedSize);
                });
            });
        });
    </script>

<script>
    $(document).on("click", ".js-addcart-detail1", function(){
    let productId = $(this).data("id");
    let sizeId = $(".size-button.active").data("size-id");
    let sizeName = $(".size-button.active").data("size");
    let quantity = parseInt($("#quantity-product").val()) || 1;

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
</script>
@endsection
