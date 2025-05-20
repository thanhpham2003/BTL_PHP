<style>
    .hidden {
        opacity: 0;
        max-height: 0;
        overflow: hidden;
        transition: opacity 0.5s ease, max-height 0.5s ease;
    }

    .visible {
        margin-bottom: 50px;
        opacity: 1;
        max-height: 400px;
        /* Đảm bảo chiều cao tối đa lớn hơn chiều cao sản phẩm */
        transition: opacity 0.5s ease, max-height 0.5s ease;
    }

    .product-price {
        font-size: 18px;
        margin-top: 10px;
    }

    .original-price {
        text-decoration: line-through;
        color: gray;
        margin-right: 10px;
    }

    .sale-price {
        color: red;
        font-weight: bold;
    }

    .current-price {
        font-weight: bold;
    }
</style>
<!-- Product -->

<section class="bg0 p-t-23 p-b-140">
    <div class="container">
        <div class="p-b-10 mb-5" align="center">
            <h3 class="ltext-103 cl5">
                SẢN PHẨM
            </h3>
        </div>

        <div class="row" id="product-list">
            @foreach ($products as $index => $product)
                <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 product-item {{ $index < 8 ? 'initial' : 'hidden' }}">
                    <div class="block2">
                        <div class="block2-pic hov-img0">
                            <img src="{{ asset($product->thumb) }}" alt="IMG-PRODUCT"
                                style="width: 100%; height: 400px; object-fit: cover;">
                            <a href="#"
                                class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1" data-id="{{ $product->id }}"
                                data-name="{{ $product->name }}" data-price="{{ $product->price }}"
                                data-price-sale="{{ $product->price_sale }}"
                                data-description="{{ $product->description }}"
                                data-image="{{ asset($product->thumb) }}"">
                                Xem ngay
                            </a>
                        </div>
                        <div class="block2-txt flex-w flex-t p-t-14">
                            <div class="block2-txt-child1 flex-col-l">
                                <a href="{{ route('fr.product.detail', ['productID' => $product->id]) }} "
                                    class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                    {{ $product->name }}
                                </a>
                                @if ($product->price_sale)
                                    <span class="original-price"
                                        style="text-decoration: line-through;">{{ number_format($product->price, 0) }}
                                        VND</span>
                                    <span class="sale-price"
                                        style="color: red;">{{ number_format($product->price_sale, 0) }} VND</span>
                                @else
                                    <span class="current-price">{{ number_format($product->price, 0) }} VND</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<script src={{ asset("template/vendor/slick.min.js") }}></script>
<script src={{ asset("template/js/product.js?v=". time()) }}></script>
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


