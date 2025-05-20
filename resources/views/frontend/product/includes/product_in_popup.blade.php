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


    .wrap-modal1 {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        z-index: 9999;
        justify-content: center;
        align-items: center;
    }

    .wrap-modal1.show-modal {
        display: flex;
    }

    .wrap-pic-w img {
        width: 100%;
        height: auto;
        object-fit: cover;
        max-height: 400px;
    }
</style>


<div class="wrap-modal1 js-modal1 p-t-60 p-b-20">
    <div class="overlay-modal1 js-hide-modal1"></div>
    <div class="container">
        <div class="bg0 p-t-60 p-b-30 p-lr-15-lg how-pos3-parent">
            <button class="how-pos3 hov3 trans-04 js-hide-modal1">
                <img src="template/images/icons/icon-close.png" alt="CLOSE">
            </button>

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
                                        class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail"
                                        data-id="{{ $product->id }}">
                                        Thêm vào giỏ hàng
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    var sizeButtons = document.querySelectorAll(".size-button:not(.disabled)");
    sizeButtons.forEach(button => {
        button.addEventListener("click", function(event) {
            event.preventDefault(); // Ngăn chặn hành động mặc định (nếu có)
            // Loại bỏ class active khỏi tất cả nút size
            sizeButtons.forEach(btn => btn.classList.remove("active"));
            // Thêm class active cho nút được click
            this.classList.add("active");
        });
    });
</script>

<script>
    // Truyền giá trị `auth()->check()` vào biến JavaScript
    $(document).on("click", ".js-addcart-detail", function() {
        var isAuthenticated =
            {{ auth('frontend')->check() ? 'true' : 'false' }}; // Kiểm tra trạng thái đăng nhập

        if (!isAuthenticated) {
            // Nếu chưa đăng nhập, hiển thị thông báo lỗi bằng SweetAlert
            Swal.fire({
                icon: 'warning',
                title: 'Bạn chưa đăng nhập',
                text: 'Vui lòng đăng nhập để thêm vào giỏ hàng.',
                confirmButtonText: 'Đăng nhập',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Điều hướng đến trang đăng nhập nếu người dùng nhấn nút "Đăng nhập"
                    window.location.href = "{{ route('fr.login') }}";
                }
            });
            return;
        }
    });
</script>
{{-- <script src="{{ asset('js/product.js') }}"></script> <!-- hoặc đường dẫn đến file JS của bạn --> --}}
