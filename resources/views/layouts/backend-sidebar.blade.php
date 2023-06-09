<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
with font-awesome or any other icon font library -->
        <li class="nav-item menu-open">
            <a href="{{ route('dashboard.index') }}" class="nav-link active mb-2">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    Dashboard
                    <i class="right fas fa-angle-left drop"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item mb-2">
                    <a href="{{ route('dashboard.index') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Home</p>
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="{{ route('user') }}" class="nav-link {{ request()->is('user') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-alt"></i>
                        <p>User</p>
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="{{ route('foods') }}" class="nav-link {{ request()->is('foods') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-hamburger"></i>
                        <p>Foods</p>
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="{{ route('tables') }}" class="nav-link {{ request()->is('tables') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tablet"></i>
                        <p>Meja</p>
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="{{ route('orders') }}" class="nav-link {{ request()->is('orders') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-list"></i>
                        <p>Orders</p>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</nav>
