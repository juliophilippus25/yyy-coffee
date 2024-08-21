<!-- Sidebar Start -->
<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="{{ route('dashboard') }}" class="text-nowrap logo-img">
                <img src="modernize/assets/images/logos/dark-logo.svg" width="180" alt="" />
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8"></i>
            </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('dashboard') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-dashboard"></i>
                        </span>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                @if (auth()->user()->roles == 'Admin')
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('categories.index') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-category"></i>
                            </span>
                            <span class="hide-menu">Categories</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('payments.index') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-credit-card"></i>
                            </span>
                            <span class="hide-menu">Payments</span>
                        </a>
                    </li>
                @endif
                @if (auth()->user()->roles == 'Admin' or auth()->user()->roles == 'Staff')
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('products.index') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-shopping-cart"></i>
                            </span>
                            <span class="hide-menu">Products</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="./ui-buttons.html" aria-expanded="false">
                            <span>
                                <i class="ti ti-truck-delivery"></i>
                            </span>
                            <span class="hide-menu">Transactions</span>
                        </a>
                    </li>
                @endif

                @if (auth()->user()->roles == 'Admin')
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="./ui-buttons.html" aria-expanded="false">
                            <span>
                                <i class="ti ti-report"></i>
                            </span>
                            <span class="hide-menu">Reports</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('users.index') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-user"></i>
                            </span>
                            <span class="hide-menu">Users</span>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
<!--  Sidebar End -->
