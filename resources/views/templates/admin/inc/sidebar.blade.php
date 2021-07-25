<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <a href="javascript:void(0)" class="nav-link">
                <div class="nav-profile-text d-flex flex-column">
                    <span class="font-weight-bold mb-2">{{ Auth::check() ? Auth::user()->name : '' }}</span>
                    <span class="text-secondary text-small">
                        @if (Auth::check())
                            @if (Auth::user()->role == 1)
                                Quản trị viên
                            @elseif(Auth::user()->role == 2)
                                Biên tập viên
                            @elseif(Auth::user()->role == 3)
                                Cộng tác viên
                            @endif
                        @endif
                    </span>
                </div>
                @if (Auth::check())
                    @if (Auth::user()->email == 'minhlam1996vn@gmail.com')
                        <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
                    @endif
                @endif
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.index.index') }}">
                <span class="menu-title">Bảng điều khiển</span>
                <i class="mdi mdi-home menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <span class="menu-title">Sản phẩm</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-apps menu-icon"></i>
            </a>
            <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.product.add-product') }}">Thêm
                            mới</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.product.list-product') }}">Danh
                            sách</a>
                    </li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.cat-product.index') }}">Danh mục</a>
                    </li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.brand-product.index') }}">Thương
                            hiệu</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#general-pages" aria-expanded="false"
                aria-controls="general-pages">
                <span class="menu-title">Bài viết</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-library-books menu-icon"></i>
            </a>
            <div class="collapse" id="general-pages">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.post.add-post') }}">Thêm mới</a>
                    </li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.post.list-post') }}">Danh sách</a>
                    </li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.cat-post.index') }}">Danh mục</a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#sale-basic" aria-expanded="false" aria-controls="ui-basic">
                <span class="menu-title">Khuyến mãi</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-sale menu-icon"></i>
            </a>
            <div class="collapse" id="sale-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.sale.add-sale') }}">Thêm
                            mới</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.sale.list-sale') }}">Danh
                            sách</a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.order.list-order') }}">
                <span class="menu-title">Đơn hàng</span>
                <i class="mdi mdi-wallet-travel menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.comment.list-comment') }}">
                <span class="menu-title">Bình luận</span>
                <i class="mdi mdi-comment-processing menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#general-user" aria-expanded="false"
                aria-controls="general-user">
                <span class="menu-title">Người dùng</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-account-multiple menu-icon"></i>
            </a>
            <div class="collapse" id="general-user">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.user.add-user') }}">Thêm mới</a>
                    </li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.user.list-user') }}">Danh sách</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('auth.auth.logout') }}">
                <span class="menu-title">Đăng xuất</span>
                <i class="mdi mdi-power menu-icon"></i>
            </a>
        </li>
    </ul>
</nav>
