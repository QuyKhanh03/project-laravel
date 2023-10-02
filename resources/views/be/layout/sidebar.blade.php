<!--**********************************
            Sidebar start
        ***********************************-->
<div class="deznav">
    <div class="deznav-scroll">
        <ul class="metismenu" id="menu">
            <li><a class="ai-icon" href="{{ route('admin.dashboard') }}" aria-expanded="false">
                    <i class="flaticon-381-networking"></i>
                    <span class="nav-text">Bảng điều khiển</span>
                </a>
            </li>
            <li>
                <a class="has-arrow ai-icon" href="javascript:void(0);" aria-expanded="false">
                    <i class="fab fa-product-hunt"></i>
                    <span class="nav-text">Quản lý sản phẩm</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('brands.index') }}">Danh sách thương hiệu</a></li>
                    <li><a href="{{ route('products.index') }}">Danh sách sản phẩm</a></li>
                    <li><a href="{{ route('categories.index') }}">Danh mục sản phẩm</a></li>
                </ul>
            </li>
            <li>
                <a class="has-arrow ai-icon" href="javascript:void(0);" aria-expanded="false">
                    <i class="fas fa-box-open"></i>
                    <span class="nav-text">Quản đơn hàng</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('orders.index') }}">Danh sách đơn hàng</a></li>
                </ul>
            </li>

            <li>
                <a class="has-arrow ai-icon" href="javascript:void(0);" aria-expanded="false">
                    <i class="fas fa-users"></i>
                    <span class="nav-text">Quản lý người dùng</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('users.index') }}">Danh sách người dùng</a></li>
                    <li><a href="{{ route('roles.index') }}">Danh sách vai trò</a></li>
                    <li><a href="{{ route('permissions.index') }}">Danh sách quyền</a></li>
                </ul>
            </li>

            <li>

                <a class="ai-icon" href="{{ route('fe.home.index') }}" target="_blank">
                    <i class="flaticon-381-enter"></i>
                    <span class="nav-text">Xem trang web</span>
                </a>
            </li>

        </ul>
        <div class="copyright">
            <p>Bản quyền © {{ date('Y') }} Phạm Ngọc Khánh - Luyện Huy Hướng </p>
        </div>
    </div>
</div>
<!--**********************************
        Sidebar end
    ***********************************-->
