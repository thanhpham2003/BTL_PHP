<style>
    .main-menu li.active a {
    color: #ff6600; /* Màu cam */
    font-weight: bold;
    border-bottom: 2px solid #ff6600; /* Gạch chân */
}
    .active {
        font-weight: bold;
        /* Hoặc bất kỳ kiểu dáng nào bạn muốn */
        color: #ff6347
            /* Màu sắc cho mục đang được chọn */
    }

    .notification-dropdown {
        position: absolute;
        top: 60px;
        right: 10px;
        width: 320px;
        background: #fff;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.15);
        border-radius: 10px;
        display: none;
        z-index: 1000;
        overflow: hidden;
        animation: fadeIn 0.3s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .notification-header {
        background: #ff6347;
        color: white;
        padding: 12px;
        font-weight: bold;
        text-align: center;
    }

    .notification-dropdown ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .notification-dropdown li {
        padding: 15px;
        border-bottom: 1px solid #eee;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .notification-dropdown li:last-child {
        border-bottom: none;
    }

    .notification-icon {
        width: 30px;
        height: 30px;
        background: #ff6347;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-size: 14px;
    }

    .notification-text {
        flex: 1;
    }

    .notification-dropdown.active {
        display: block;
    }

    .badge {
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 12px;
        font-weight: bold;
        color: white;
    }

    .badge-pending {
        background-color: orange;
        /* Chờ duyệt */
    }

    .badge-processing {
        background-color: blue;
        /* Đang chuẩn bị */
    }

    .badge-shipped {
        background-color: purple;
        /* Đang giao */
    }

    .badge-completed {
        background-color: green;
        /* Giao thành công */
    }

    .badge-canceled {
        background-color: red;
        /* Đã hủy */
    }

    .notification-dot {
        position: absolute;
        top: 5px;
        /* Điều chỉnh vị trí theo ý muốn */
        right: 5px;
        width: 10px;
        height: 10px;
        background-color: red;
        border-radius: 50%;
    }
</style>
<div>
    <header>
        <!-- Header desktop -->
        <div class="container-menu-desktop">

            <div class="wrap-menu-desktop">
                <nav class="limiter-menu-desktop container">

                    <!-- Logo desktop -->
                    <a href="{{ route('fr.homepage') }}" class="logo">
                        <img src="/template/admin/dist/img/download.jpg" alt="AdminLTE Logo"
                            class="brand-image img-circle elevation-3"
                            style="opacity: .8; width: 50px; height: 120px; border-radius: 50%;">
                        <span class="brand-text"
                            style="font-family: 'Lobster', cursive; font-size: 32px; color: #ff6347; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); padding-left: 10px; margin-top: 5px;">PmouShop</span>
                    </a>

                    <!-- Menu desktop -->
                    <div class="menu-desktop">
                        <ul class="main-menu">
                            <li class="{{ request()->is('/') ? 'active' : '' }}">
                                <a href="{{ route('fr.homepage') }}">Trang chủ</a>
                            </li>


                            <li class="{{ request()->is('product') ? 'active' : '' }}">
                                <a href="{{ route('fr.product') }}">Cửa hàng</a>
                            </li>


                            <li class="{{ request()->is('about') ? 'active' : '' }}">
                                <a href="{{ route('fr.about') }}">Giới thiệu</a>
                            </li>

                            <li class="{{ request()->is('contact') ? 'active' : '' }}">
                                <a href="{{ route('fr.contact') }}">Liên hệ</a>
                            </li>
                        </ul>
                    </div>

                    @php
                        $statusMessages = [];

                        // Danh sách trạng thái & thông báo tương ứng
                        $statusLabels = [
                            'pending' => 'đang chờ duyệt',
                            'processing' => 'đang chuẩn bị',
                            'shipped' => 'đang được giao',
                            'completed' => 'đã giao thành công',
                            'canceled' => 'đã bị hủy',
                        ];

                        // Kiểm tra xem có đơn hàng nào ở trạng thái này không
                        foreach ($statusLabels as $status => $message) {
                            if ($orders->contains('status', $status)) {
                                $statusMessages[] = $message;
                            }
                        }
                    @endphp
                    <!-- Icon header -->
                    <div class="wrap-icon-header flex-w flex-r-m">
                        @if (auth('frontend')->check())
                            <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti"
                                id="notification-icon">
                                <i class="fa-regular fa-bell"></i>

                                @if (!$orders->isEmpty())
                                    <span class="notification-dot"></span>
                                @endif
                            </div>
                            <div class="notification-dropdown" id="notification-dropdown">
                                <div class="notification-header">Thông báo đơn hàng</div>
                                <ul>
                                    @if (!$orders->isEmpty())
                                        @foreach ($orders as $order)
                                            <li>
                                                <div class="notification-icon">
                                                    <i class="fa-solid fa-box"></i>
                                                </div>
                                                <div class="notification-text">
                                                    Đơn hàng #{{ $order->id }} -
                                                    <span class="badge badge-{{ $order->status }}">
                                                        {{ $statusLabels[$order->status] ?? 'Không xác định' }}
                                                    </span>
                                                </div>
                                            </li>
                                        @endforeach
                                    @else
                                        <li>
                                            <div class="notification-text">Không có đơn hàng nào</div>
                                        </li>
                                    @endif

                                </ul>
                            </div>
                            <div class="cart-content">
                                <x-cart-component></x-cart-component>
                            </div>
                        @endif

                        <a href="{{ route('fr.login') }}"
                            class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10">
                            @auth('frontend')
                                <!-- Nếu đã đăng nhập, hiển thị icon đăng xuất và thực hiện hành động đăng xuất -->
                                <form action="{{ route('fr.logout') }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="icon-btn">
                                        <i class="fa-solid fa-right-from-bracket"></i> <!-- Icon đăng xuất -->
                                    </button>
                                </form>
                            @else
                                <!-- Nếu chưa đăng nhập, hiển thị icon tài khoản -->
                                <i class="zmdi zmdi-account"></i> <!-- Icon tài khoản -->
                            @endauth
                        </a>


                    </div>
                </nav>
            </div>
        </div>

        <!-- Header Mobile -->
        <div class="wrap-header-mobile">
            <!-- Logo moblie -->
            <div class="logo-mobile">
                <a href="index.html">
                    <img src="/template/admin/dist/img/download.jpg" alt="AdminLTE Logo"
                        class="brand-image img-circle elevation-3"
                        style="opacity: .8; width: 50px; height: 120px; border-radius: 50%; margin-top:10px;">
                    <span class="brand-text"
                        style="font-family: 'Lobster', cursive; font-size: 32px; color: #ff6347; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); padding-left: 60px;">PmouShop</span>
                </a>
            </div>

            <!-- Icon header -->
            <div class="wrap-icon-header flex-w flex-r-m m-r-15">

                @if (auth('frontend')->check())
                    <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti"
                        id="notification-icon">
                        <i class="fa-regular fa-bell"></i>

                        @if (!$orders->isEmpty())
                            <span class="notification-dot"></span>
                        @endif
                    </div>
                    <div class="notification-dropdown" id="notification-dropdown">
                        <div class="notification-header">Thông báo đơn hàng</div>
                        <ul>
                            @if (!$orders->isEmpty())
                                @foreach ($orders as $order)
                                    <li>
                                        <div class="notification-icon">
                                            <i class="fa-solid fa-box"></i>
                                        </div>
                                        <div class="notification-text">
                                            Đơn hàng #{{ $order->id }} -
                                            <span class="badge badge-{{ $order->status }}">
                                                {{ $statusLabels[$order->status] ?? 'Không xác định' }}
                                            </span>
                                        </div>
                                    </li>
                                @endforeach
                            @else
                                <li>
                                    <div class="notification-text">Không có đơn hàng nào</div>
                                </li>
                            @endif

                        </ul>
                    </div>
                    {{-- <div class="cart-content">
                        <x-cart-component></x-cart-component>
                    </div> --}}
                @endif

                <a href="{{ route('fr.login') }}"
                    class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10">
                    @auth('frontend')
                        <!-- Nếu đã đăng nhập, hiển thị icon đăng xuất và thực hiện hành động đăng xuất -->
                        <form action="{{ route('fr.logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="icon-btn">
                                <i class="fa-solid fa-right-from-bracket"></i> <!-- Icon đăng xuất -->
                            </button>
                        </form>
                    @else
                        <!-- Nếu chưa đăng nhập, hiển thị icon tài khoản -->
                        <i class="zmdi zmdi-account"></i> <!-- Icon tài khoản -->
                    @endauth
                </a>

            </div>

            <!-- Button show menu -->
            <div class="btn-show-menu-mobile hamburger hamburger--squeeze">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </div>
        </div>


        <!-- Menu Mobile -->
        <div class="menu-mobile">

            <ul class="main-menu-m">
                <li class="active-menu">
                    <a href="{{ route('fr.homepage') }}">Trang chủ</a>
                </li>

                <li>
                    <a href="{{ route('fr.product') }}">Cửa hàng</a>
                </li>


                <li>
                    <a href="{{ route('fr.about') }}">Giới thiệu</a>
                </li>

                <li>
                    <a href="{{ route('fr.contact') }}">Liên hệ</a>
                </li>
            </ul>
        </div>

        <!-- Modal Search -->
        <div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
            <div class="container-search-header">
                <button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-search">
                    <img src="/template/images/icons/icon-close2.png" alt="CLOSE">
                </button>

                <form class="wrap-search-header flex-w p-l-15">
                    <button class="flex-c-m trans-04">
                        <i class="zmdi zmdi-search"></i>
                    </button>
                    <input class="plh3" type="text" name="search" placeholder="Search...">
                </form>
            </div>
        </div>
    </header>
</div>


<script>
    document.getElementById("notification-icon").addEventListener("click", function(event) {
        event.stopPropagation(); // Ngăn chặn sự kiện click lan ra ngoài
        document.getElementById("notification-dropdown").classList.toggle("active");
    });

    document.addEventListener("click", function(event) {
        var dropdown = document.getElementById("notification-dropdown");
        var icon = document.getElementById("notification-icon");

        if (!icon.contains(event.target) && !dropdown.contains(event.target)) {
            dropdown.classList.remove("active");
        }
    });
</script>
