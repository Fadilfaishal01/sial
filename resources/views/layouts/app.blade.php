<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>SIAL | {{ $title ?? 'Dashboard' }}</title>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">

        <!-- Fontawesome -->
        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    </head>
    <body class="app sidebar-mini rtl">
        <header class="app-header"><a class="app-header__logo" href="index.html">SIAL</a>
        <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
            <!-- Navbar Right Menu-->
            <ul class="app-nav">
                <!-- User Menu-->
                <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
                    <ul class="dropdown-menu settings-menu dropdown-menu-right">
                        <li><a class="dropdown-item" href="{{ route('logout') }}"><i class="fa fa-sign-out fa-lg"></i> Logout</a></li>
                    </ul>
                </li>
            </ul>
        </header>

        <!-- Sidebar Menu-->
        <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
        <aside class="app-sidebar">
            <div class="app-sidebar__user">
                <!-- <img class="app-sidebar__user-avatar" src="{{ asset('assets/image/images.png') }}" alt="User Image"> -->
                <div>
                    <p class="app-sidebar__user-name">{{ Auth::user()->name }}</p>
                    <p class="app-sidebar__user-designation">Admin SIAL</p>
                </div>
            </div>
            <ul class="app-menu">
                <li><a class="app-menu__item active" href="index.html"><i class="app-menu__icon fa fa-home"></i><span class="app-menu__label">Dashboard</span></a></li>
                <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-database"></i><span class="app-menu__label">Master Data</span><i class="treeview-indicator fa fa-angle-right"></i></a>
                    <ul class="treeview-menu">
                        <li><a class="treeview-item" href="{{ route('admin.levis.index') }}"><i class="icon fa fa-circle-o"></i> Levis</a></li>
                        <li><a class="treeview-item" href="{{ route('admin.type.index') }}"><i class="icon fa fa-circle-o"></i> Type</a></li>
                        <li><a class="treeview-item" href="{{ route('admin.brand.index') }}"><i class="icon fa fa-circle-o"></i> Brand</a></li>
                    </ul>
                </li>
            </ul>
        </aside>

        <!-- Main Menu -->
        <main class="app-content">
            @yield('main-content')
        </main>

        <script src="{{ asset('assets/js/jquery-3.2.1.min.js') }}"></script>
        <script src="{{ asset('assets/js/popper.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/main.js') }}"></script>
        <!-- Plugins Bs -->
        <script src="{{ asset('assets/js/plugins/pace.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/bootstrap-notify.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/sweetalert.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/bootstrap-datepicker.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/select2.min.js') }}"></script>
        <!-- DataTable -->
        <script src="{{ asset('assets/js/plugins/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/dataTables.bootstrap.min.js') }}"></script>
        @yield('script-native')
    </body>
</html>
