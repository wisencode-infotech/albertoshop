<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu">Pages</li>

                <li>
                    <a href="{{ route('backend.home') }}" class="waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span key="t-calendar">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-store"></i>
                        <span key="t-ecommerce">Category</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('backend.category.create') }}" key="t-products">Add New</a></li>
                        <li><a href="{{ route('backend.category.index') }}" key="t-product-detail">All</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-store"></i>
                        <span key="t-ecommerce">Site Banners</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('backend.site-banner.create') }}" key="t-products">Add New</a></li>
                        <li><a href="{{ route('backend.site-banner.index') }}" key="t-product-detail">All</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-store"></i>
                        <span key="t-ecommerce">Products</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('backend.product.create') }}" key="t-products">Add New</a></li>
                        <li><a href="{{ route('backend.product.index') }}" key="t-product-detail">All</a></li>
                    </ul>
                </li>

                <li>
                    <a href="{{ route('backend.settings.index') }}" class="waves-effect">
                        <i class="bx bx-cog"></i>
                        <span key="t-calendar">Settings</span>
                    </a>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
