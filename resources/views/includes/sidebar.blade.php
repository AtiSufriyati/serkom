<div class="sidebar sidebar-dark sidebar-main sidebar-expand-md">
    <!-- Sidebar mobile toggler -->
    <!-- <div class="sidebar-mobile-toggler text-center">
        <a href="#" class="sidebar-mobile-main-toggle">
            <i class="icon-arrow-left8"></i>
        </a> -->
        <!-- Navigation -->
        <!-- <a href="#" class="sidebar-mobile-expand">
            <i class="icon-screen-full"></i>
            <i class="icon-screen-normal"></i>
        </a>
    </div> -->
    <!-- /sidebar mobile toggler -->
    <!-- Sidebar content -->
    <div class="sidebar-content">
        <!-- User menu -->
        <!-- <div class="sidebar-user">
            <div class="card-body">
                <div class="media">
                    <div class="mr-3">
                 
                                <a href="">
                                    <img src="" width="38" height="38" class="rounded-circle" alt="">
                                </a>
                        
                        </a>
                    </div>

                    <div class="media-body">
                        <div class="media-title font-weight-semibold">Sufriyati</div>
                        <div class="font-size-xs opacity-50">
                            <i class="icon-tree6 font-size-sm"></i> 
                        </div>
                    </div>

                    {{-- <div class="ml-3 align-self-center">
                        <a href="#" class="text-white"><i class="icon-cog3"></i></a>
                    </div> --}}
                </div>
            </div>
        </div> -->
        <!-- /user menu -->

        <input type="text" name="route_url" value = "{{$route_url}}">
        <!-- Main navigation -->
        <div class="card card-sidebar-mobile">
            <ul class="nav nav-sidebar" data-nav-type="accordion">
                <!-- MENU -->
                <div id="sidebar" class="active">
                    <div class="sidebar-wrapper active">
                        <div class="sidebar-header">
                            <div class="d-flex justify-content-between">
                                <div class="logo">
                                    <!-- <a href="index.html"><img src="assets/images/logo/logo.png" alt="Logo" srcset=""></a> -->
                                </div>
                                <div class="toggler">
                                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="sidebar-menu">
                            <ul class="menu">
                                <!-- <li class="sidebar-title">Menu</li> -->
                                <li
                                    class="sidebar-item menu-home">
                                    <a href="{{ route('home') }}" class='sidebar-link'>
                                        <i class="bi bi-grid-fill"></i>
                                        <span>Home</span>
                                    </a>
                                </li>

                                <li
                                    class="sidebar-item menu-customer">
                                    <a href="{{ route('customer') }}" class='sidebar-link'>
                                        <i class="bi bi-person-badge-fill"></i>
                                        <span >Customer</span>
                                    </a>
                                </li>
                                <li
                                    class="sidebar-item menu-user">
                                    <a href="{{ route('user') }}" class='sidebar-link'>
                                        <i class="bi bi-person-badge-fill"></i>
                                        <span>User</span>
                                    </a>
                                </li>
                                <li
                                    class="sidebar-item menu-price">
                                    <a href="{{route('price')}}" class='sidebar-link'>
                                        <i class="bi bi-cash"></i>
                                        <span>Price</span>
                                    </a>
                                </li>
                                <li
                                    class="sidebar-item menu-level">
                                    <a href="{{route('level')}}" class='sidebar-link'>
                                        <i class="bi bi-puzzle"></i>
                                        <span>Level</span>
                                    </a>
                                </li>
                                <li
                                    class="sidebar-item menu-payment">
                                    <a href="{{route('payment')}}" class='sidebar-link'>
                                        <i class="bi bi-cash"></i>
                                        <span>Payment</span>
                                    </a>
                                </li>
                                <!-- <li
                                    class="sidebar-item menu-usage">
                                    <a href="{{route('usage')}}" class='sidebar-link'>
                                        <i class="bi bi-bar-chart-fill"></i>
                                        <span>Usage</span>
                                    </a>
                                </li> -->
                                <li
                                    class="sidebar-item">
                                    <a href="{{route('auth.logout')}}" class='sidebar-link'>
                                        <!-- <i class="bi bi-bar-chart-fill"></i> -->
                                        <span>Log Out</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
                    </div>
                </div>
            </ul>
        </div>
        <!-- /main navigation -->

    </div>
    <!-- /sidebar content -->

</div>

