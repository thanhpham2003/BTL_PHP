<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/admin" class="brand-link">
        <img src="/template/admin/dist/img/download.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">PmouShop</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="/template/admin/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Tìm kiếm"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
       with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fa-solid fa-layer-group"></i>
                        <p class="ml">
                            Danh mục
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('admin/menus/add') }}" class="nav-link">
                                <i class="nav-icon fas fa-plus"></i>
                                <p>Thêm danh mục</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('admin/menus/list') }}" class="nav-link">
                                <i class="nav-icon fas fa-bars"></i>
                                <p>Danh sách danh mục</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fa-solid fa-box"></i>
                        <p>
                            Sản phẩm
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('admin/products/add') }}" class="nav-link">
                                <i class="nav-icon fas fa-plus"></i>
                                <p>Thêm sản phẩm</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('admin/products/list') }}" class="nav-link">
                                <i class="nav-icon fas fa-bars"></i>
                                <p>Danh sách sản phẩm</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fa-solid fa-images"></i>
                        <p>
                            Slider
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.slider.create') }}" class="nav-link">
                                <i class="nav-icon fas fa-plus"></i>
                                <p>Thêm slider</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.slider.list') }}" class="nav-link">
                                <i class="nav-icon fas fa-bars"></i>
                                <p>Danh sách slider</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.order.pending') }}" class="nav-link">
                        <i class="fa-solid fa-truck"></i>
                        <p>
                            Đơn hàng
                            @if (isset($orderCount) && $orderCount > 0)
                                <span class="badge badge-danger">{{ $orderCount }}</span>
                                <!-- Hiển thị số tin nhắn -->
                            @endif
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.review.pending') }}" class="nav-link">
                        <i class="fa-solid fa-feather-pointed"></i>
                        <p>
                            Đánh giá
                            @if (isset($reviewAdminCount) && $reviewAdminCount > 0)
                                <span class="badge badge-danger">{{ $reviewAdminCount }}</span>
                                <!-- Hiển thị số tin nhắn -->
                            @endif
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fa-solid fa-pen-nib"></i>
                        <p>
                            Giới thiệu
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.about.create') }}" class="nav-link">
                                <i class="nav-icon fas fa-plus"></i>
                                <p>Thêm giới thiệu</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.about.list') }}" class="nav-link">
                                <i class="nav-icon fas fa-bars"></i>
                                <p>Danh sách giới thiệu</p>
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.info') }}" class="nav-link">
                        <i class="fa-solid fa-circle-info"></i>
                        <p>
                            Thông tin

                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.contact.pending') }}" class="nav-link">
                        <i class="fa-solid fa-arrow-right-arrow-left"></i>
                        <p>
                            Trao đổi
                            @if (isset($messageCount) && $messageCount > 0)
                                <span class="badge badge-danger">{{ $messageCount }}</span>
                                <!-- Hiển thị số tin nhắn -->
                            @endif
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
