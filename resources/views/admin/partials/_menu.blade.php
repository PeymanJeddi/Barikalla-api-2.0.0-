<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('admin.index') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="/images/logo-32.png" alt="">
            </span>
            <span class="app-brand-text demo menu-text fw-bold ms-2">باریکلا</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="bx menu-toggle-icon d-none d-xl-block fs-4 align-middle"></i>
            <i class="bx bx-x d-block d-xl-none bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-divider mt-0"></div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboards -->
        <li class="menu-header small text-uppercase"><span class="menu-header-text">پنل مدیریت</span></li>
        <li class="menu-item {{ isMenuActive('admin.index', 'active open') }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bxs-home-circle"></i>
                <div>خانه</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ isMenuActive('admin.index', 'active') }}">
                    <a href="{{ route('admin.index') }}" class="menu-link">
                        <div>داشبورد</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item {{ isMenuActive(['admin.users.index', 'admin.users.create', 'admin.users.edit'], 'active open') }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bxs-user"></i>
                <div>کاربران</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ isMenuActive('admin.users.index', 'active') }}">
                    <a href="{{ route('admin.users.index') }}" class="menu-link">
                        <div>لیست</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item">
            <a href="{{ route('logout') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-exit"></i>
                <div>خروج</div>
            </a>
        </li>


        <!-- Admin users -->
        {{-- Begin:: menu item --}}
        {{-- <li
            class="menu-item {{ isMenuActive(['admin.users.index', 'admin.users.create', 'admin.users.edit'], 'active open') }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bxs-user"></i>
                <div>کاربران</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ isMenuActive('admin.users.index', 'active') }}">
                    <a href="{{ route('admin.users.index') }}" class="menu-link">
                        <div>لیست کاربران</div>
                    </a>
                </li>
                <li class="menu-item {{ isMenuActive('admin.users.create', 'active') }}">
                    <a href="{{ route('admin.users.create') }}" class="menu-link">
                        <div>ایجاد کاربر</div>
                    </a>
                </li>
            </ul>
        </li> --}}
        {{-- End:: menu item --}}
    </ul>
</aside>
