<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <!-- <img src="../../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> -->
        <span class="brand-text font-weight-light">{{ auth()->user()->first_name }}
            {{ auth()->user()->last_name }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <!-- User image can be added here -->
            </div>
            <div class="info">
                <a href="#" class="d-block">
                    <h3>{{ __('site.pos system') }}</h3>
                </a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Dashboard Link -->
                <li class="nav-item">
                    <a href="{{ route('dashboard.index') }}" class="nav-link">
                        <i class="fa-solid fa-house mr-2"></i>
                        <p>
                            {{ __('site.dashboard') }}
                        </p>
                    </a>
                </li>

                <!-- Categories Link -->
                @if(auth()->user()->hasPermissionTo('read_categories'))
                <li class="nav-item mt-1">
                    <a href="{{ route('dashboard.categories.index') }}" class="nav-link">
                        <i class="fa-solid fa-list mr-2"></i>
                        <span class="badge badge-info right">{{ App\Models\Category::count() }}</span>
                        <p>
                            {{ __('site.categories') }}
                        </p>
                    </a>
                </li>
                @endif

                <!-- Products Link -->
                @if(auth()->user()->hasPermissionTo('read_products'))
                <li class="nav-item mt-1">
                    <a href="{{ route('dashboard.products.index') }}" class="nav-link">
                        <i class="fa-solid fa-layer-group mr-2"></i>
                        <span class="badge badge-info right">{{ App\Models\Product::count() }}</span>
                        <p>
                            {{ __('site.products') }}
                        </p>
                    </a>
                </li>
                @endif

                <!-- Clients Link -->
                @if(auth()->user()->hasPermissionTo('read_clients'))
                <li class="nav-item mt-1">
                    <a href="{{ route('dashboard.clients.index') }}" class="nav-link">
                        <i class="fa-solid fa-person-walking-luggage mr-2"></i>
                        <span class="badge badge-info right">{{ App\Models\Client::count() }}</span>
                        <p>
                            {{ __('site.clients') }}
                        </p>
                    </a>
                </li>
                @endif

                <!-- Orders Link -->
                @if(auth()->user()->hasPermissionTo('read_orders'))
                <li class="nav-item mt-1">
                    <a href="{{ route('dashboard.orders.index') }}" class="nav-link">
                        <i class="fa-brands fa-first-order-alt mr-2"></i>
                        <span class="badge badge-info right">{{ App\Models\Order::count() }}</span>
                        <p>
                            {{ __('site.orders') }}
                        </p>
                    </a>
                </li>
                @endif

                <!-- Users Link -->
                @if(auth()->user()->hasPermissionTo('read_users'))
                <li class="nav-item mt-1">
                    <a href="{{ route('dashboard.users.index') }}" class="nav-link">
                        <i class="fa-regular fa-user mr-2"></i>
                        <span class="badge badge-info right">{{ App\Models\User::role('admin')->count() }}</span>
                        <p>
                            {{ __('site.users') }}
                        </p>
                    </a>
                </li>
                @endif

                <!-- Logout Link -->
                <li class="nav-item mt-3">
                    <a href="{{ route('logout') }}" class="nav-link">
                        <i class="fa-solid fa-right-from-bracket mr-2"></i>
                        <p>
                            {{ __('site.logout') }}
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>