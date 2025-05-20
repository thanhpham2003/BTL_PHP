@extends('frontend.layout')
@section('content')
    <style>
        .how-active1 {
            font-weight: bold;
            color: red !important;
            border-bottom: 2px solid red;
        }

        .active-filter {
            font-weight: bold;
            color: red !important;
        }


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
    <div class="bg0 m-t-23 p-b-140" style="margin-top:80px">
        <div class="container">
            <div class="flex-w flex-sb-m p-b-52">
                <div class="flex-w flex-l-m filter-tope-group m-tb-10">
                    <button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 how-active1 filter-btn" data-filter="all">
                        Tất cả
                    </button>

                    @foreach ($menus as $menu)
                        <button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 filter-btn"
                            data-filter="{{ $menu->id }}">
                            {{ $menu->name }}
                        </button>
                    @endforeach

                    <button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 filter-btn" data-filter="sale">
                        Giảm giá
                    </button>
                </div>


                <div class="flex-w flex-c-m m-tb-10">
                    <div class="flex-c-m stext-106 cl6 size-104 bor4 pointer hov-btn3 trans-04 m-r-8 m-tb-4 js-show-filter">
                        <i class="icon-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-filter-list"></i>
                        <i class="icon-close-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
                        Filter
                    </div>

                    <div class="flex-c-m stext-106 cl6 size-105 bor4 pointer hov-btn3 trans-04 m-tb-4 js-show-search">
                        <i class="icon-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-search"></i>
                        <i class="icon-close-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
                        Search
                    </div>
                </div>

                <!-- Search product -->
                <div class="dis-none panel-search w-full p-t-10 p-b-15">
                    <div class="bor8 dis-flex p-l-15">
                        <button class="size-113 flex-c-m fs-16 cl2 hov-cl1 trans-04">
                            <i class="zmdi zmdi-search"></i>
                        </button>

                        <input class="mtext-107 cl2 size-114 plh2 p-r-15" id="search-input" type="text"
                            name="search-product" placeholder="Search">
                    </div>
                </div>

                <!-- Filter -->
                <div class="dis-none panel-filter w-full p-t-10">
                    <div class="wrap-filter flex-w bg6 w-full p-lr-40 p-t-27 p-lr-15-sm">
                        <div class="filter-col1 p-r-15 p-b-27">
                            <div class="mtext-102 cl2 p-b-15">
                                Sắp xếp
                            </div>

                            <ul>
                                <li class="p-b-6">
                                    <a href="#" class="filter-link stext-106 trans-04" data-sort="default">
                                        Mặc định
                                    </a>
                                </li>

                                <li class="p-b-6">
                                    <a href="#" class="filter-link stext-106 trans-04" data-sort="newest">
                                        Mới nhất
                                    </a>
                                </li>

                                <li class="p-b-6">
                                    <a href="#" class="filter-link stext-106 trans-04" data-sort="price-low">
                                        Giá: Thấp đến cao
                                    </a>
                                </li>

                                <li class="p-b-6">
                                    <a href="#" class="filter-link stext-106 trans-04" data-sort="price-high">
                                        Giá: Cao đến thấp
                                    </a>
                                </li>

                            </ul>
                        </div>

                        <div class="filter-col2 p-r-15 p-b-27">
                            <div class="mtext-102 cl2 p-b-15">
                                Giá
                            </div>

                            <ul>
                                <li class="p-b-6">
                                    <a href="#" class="filter-link stext-106 trans-04" data-price="all">
                                        Tất cả
                                    </a>
                                </li>

                                <li class="p-b-6">
                                    <a href="#" class="filter-link stext-106 trans-04" data-price="1-10">
                                        1 VND - 10 VND
                                    </a>
                                </li>

                                <li class="p-b-6">
                                    <a href="#" class="filter-link stext-106 trans-04" data-price="11-50">
                                        11 VND - 50 VND
                                    </a>
                                </li>

                                <li class="p-b-6">
                                    <a href="#" class="filter-link stext-106 trans-04" data-price="51-100">
                                        51 VND - 100 VND
                                    </a>
                                </li>

                                <li class="p-b-6">
                                    <a href="#" class="filter-link stext-106 trans-04" data-price="100+">
                                        100 VND ++
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div id="product-list">
                @include('frontend.product.list', ['products' => $products])
            </div>
        </div>
    </div>


    <!-- Back to top -->
    <div class="btn-back-to-top" id="myBtn">
        <span class="symbol-btn-back-to-top">
            <i class="zmdi zmdi-chevron-up"></i>
        </span>
    </div>
    <script src="{{ asset('template/js/main.js') }}?v={{ time() }}"></script>

    <script src={{ asset('template/js/product.js?v=' . time()) }}></script>

    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.querySelector('input[name="search-product"]');
            const products = document.querySelectorAll('.product-item');

            searchInput.addEventListener('keyup', function() {
                let searchText = searchInput.value.toLowerCase().trim();

                products.forEach(product => {
                    let productName = product.querySelector('.js-name-b2').textContent
                        .toLowerCase();

                    if (productName.includes(searchText)) {
                        product.style.display = 'block';
                    } else {
                        product.style.display = 'none';
                    }
                });
            });
        });
    </script> --}}

    {{-- <script>
        document.addEventListener("DOMContentLoaded", function() {
            const productList = document.querySelector("#product-list");
            const productItems = document.querySelectorAll(".product-item");

            // Xử lý sự kiện click cho lọc giá
            document.querySelectorAll("[data-price]").forEach((btn) => {
                btn.addEventListener("click", function(e) {
                    e.preventDefault();

                    // Loại bỏ lớp active khỏi tất cả các nút lọc giá
                    document.querySelectorAll("[data-price]").forEach((el) => el.classList.remove(
                        "active-filter"));

                    // Thêm lớp active cho nút được chọn
                    this.classList.add("active-filter");

                    let priceRange = this.getAttribute("data-price").split("-");
                    let minPrice = priceRange[0] ? parseInt(priceRange[0]) : 0;
                    let maxPrice = priceRange[1] ? parseInt(priceRange[1]) : Infinity;

                    productItems.forEach((item) => {
                        let productPrice = parseInt(item.getAttribute("data-price"));
                        if (priceRange == "all" || (productPrice >= minPrice &&
                                productPrice <= maxPrice)) {
                            item.style.display = "block";
                        } else {
                            item.style.display = "none";
                        }
                    });
                });
            });

            // Xử lý sự kiện click cho sắp xếp
            document.querySelectorAll("[data-sort]").forEach((btn) => {
                btn.addEventListener("click", function(e) {
                    e.preventDefault();

                    // Loại bỏ lớp active khỏi tất cả các nút sắp xếp
                    document.querySelectorAll("[data-sort]").forEach((el) => el.classList.remove(
                        "active-filter"));

                    // Thêm lớp active cho nút được chọn
                    this.classList.add("active-filter");

                    let sortType = this.getAttribute("data-sort");
                    let sortedItems = Array.from(productItems);

                    if (sortType === "newest") {
                        sortedItems.sort((a, b) => {
                            return new Date(b.getAttribute("data-date")) - new Date(a
                                .getAttribute("data-date"));
                        });
                    } else if (sortType === "price-low") {
                        sortedItems.sort((a, b) => {
                            return parseInt(a.getAttribute("data-price")) - parseInt(b
                                .getAttribute("data-price"));
                        });
                    } else if (sortType === "price-high") {
                        sortedItems.sort((a, b) => {
                            return parseInt(b.getAttribute("data-price")) - parseInt(a
                                .getAttribute("data-price"));
                        });
                    }

                    // Cập nhật lại danh sách sản phẩm
                    productList.innerHTML = "";
                    sortedItems.forEach((item) => {
                        productList.appendChild(item);
                    });
                });
            });
        });
    </script> --}}



    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            const filterButtons = document.querySelectorAll(".filter-tope-group button");
            const searchInput = document.querySelector("#search-input");
            const sortFilters = document.querySelectorAll("[data-sort]");
            const priceFilters = document.querySelectorAll("[data-price]"); 

            function fetchProducts() {
                let menuId = document.querySelector(".filter-tope-group .how-active1")?.getAttribute(
                    "data-filter") || "all";
                let filter = document.querySelector(".filter-active")?.getAttribute("data-sort") || "";
                let priceRange = document.querySelector(".price-active")?.getAttribute("data-price") ||
                "all"; // Lấy giá trị lọc theo giá
                let search = searchInput.value.trim();

                $.ajax({
                    url: '{{ route('fr.product.filter') }}',
                    method: 'GET',
                    data: {
                        menu_id: menuId,
                        filter: filter,
                        price_range: priceRange,
                        search: search
                    }, // Gửi thêm price_range
                    success: function(response) {
                        $('#product-list').html(response.html);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            }

            // Click vào danh mục
            filterButtons.forEach(button => {
                button.addEventListener("click", function() {
                    filterButtons.forEach(btn => btn.classList.remove("how-active1"));
                    this.classList.add("how-active1");
                    fetchProducts();
                });
            });

            // Click vào filter (sắp xếp)
            sortFilters.forEach(button => {
                button.addEventListener("click", function(e) {
                    e.preventDefault();
                    document.querySelectorAll("[data-sort]").forEach((el) => el.classList.remove(
                        "active-filter"));

                    // Thêm lớp active cho nút được chọn
                    this.classList.add("active-filter");
                    sortFilters.forEach(btn => btn.classList.remove("filter-active"));
                    this.classList.add("filter-active");
                    fetchProducts();
                });
            });

            // Click vào filter giá
            priceFilters.forEach(button => {
                button.addEventListener("click", function(e) {
                    e.preventDefault();
                    // Loại bỏ lớp active khỏi tất cả các nút lọc giá
                    document.querySelectorAll("[data-price]").forEach((el) => el.classList.remove(
                        "active-filter"));

                    // Thêm lớp active cho nút được chọn
                    this.classList.add("active-filter");
                    priceFilters.forEach(btn => btn.classList.remove("price-active"));
                    this.classList.add("price-active");
                    fetchProducts();
                });
            });

            // Nhập tìm kiếm
            searchInput.addEventListener("keyup", function() {
                fetchProducts();
            });
        });
    </script>
@endsection
