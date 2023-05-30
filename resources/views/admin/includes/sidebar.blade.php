<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">Pharmacy System</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ Auth::user()->profile_image }}" class="img-circle elevation-2" alt="User Image"
                    style="width: 35px; height: 35px; object-fit: cover;">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
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
                @role('admin')
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}"
                            class="nav-link {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-chart-line"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.pharmacies.index') }}"
                            class="nav-link {{ Route::is('admin.pharmacies.index') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-clinic-medical"></i>
                            <p>
                                Pharmacies
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.doctors.index') }}"
                            class="nav-link {{ Route::is('admin.doctors.index') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-md"></i>
                            <p>
                                Doctors
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.users.index') }}"
                            class="nav-link {{ Route::is('admin.users.index') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user"></i>
                            <p>
                                Users
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.governorates.index') }}"
                            class="nav-link {{ Route::is('admin.governorates.index') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-globe-africa"></i>
                            <p>
                                Governorates
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link {{ Route::is('') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-map"></i>
                            <p>
                                Areas
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link {{ Route::is('') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-map-marker"></i>
                            <p>
                                User Addresses
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link {{ Route::is('') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-pills"></i>
                            <p>
                                Medicines
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link {{ Route::is('') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-shopping-bag"></i>
                            <p>
                                Orders
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link {{ Route::is('') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-wallet"></i>
                            <p>
                                Revenue
                            </p>
                        </a>
                    </li>
                @endrole
                @role('pharmacy')
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}"
                            class="nav-link {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-chart-line"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link {{ Route::is('') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-md"></i>
                            <p>
                                Doctors
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link {{ Route::is('') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-shopping-bag"></i>
                            <p>
                                Orders
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link {{ Route::is('') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-wallet"></i>
                            <p>
                                Revenue
                            </p>
                        </a>
                    </li>
                @endrole
                @role('doctor')
                    <li class="nav-item">
                        <a href="" class="nav-link {{ Route::is('') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-shopping-bag"></i>
                            <p>
                                Orders
                            </p>
                        </a>
                    </li>
                @endrole
                <li class="nav-header">AUTH</li>
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="post" style="display: none;" id="logout-form">@csrf
                    </form>
                    <a href="#" class="nav-link"
                        onclick="if (confirm('Are you sure ?')) document.getElementById('logout-form').submit()">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>
                            Logout
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
