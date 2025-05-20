@if ($products->count() > 0)
    <div class="row">
        @foreach ($products as $index => $product)
            <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 product-item  menu-{{ $product->menu_id }} {{ $product->price_sale ? 'sale' : '' }}"
                data-price="{{ $product->price_sale ?? $product->price }}" data-date="{{ $product->created_at }}">
                <div class="block2">
                    <div class="block2-pic hov-img0">
                        <img src="{{ asset($product->thumb) }}" alt="IMG-PRODUCT"
                            style="width: 100%; height: 400px; object-fit: cover;">
                        <a href="/san-pham/{{ $product->id }}-{{ Str::slug($product->name, '-') }}"
                            data-id="{{ $product->id }}"
                            class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
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
@else
    <p class="text-center">Không có sản phẩm nào!</p>
@endif
