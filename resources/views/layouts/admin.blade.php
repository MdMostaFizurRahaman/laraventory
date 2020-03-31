<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>{{config('app.name', 'Laraventory')}} | @yield('title')</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{asset('theme')}}/plugins/fontawesome-free/css/all.min.css">

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset('theme')}}/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{asset('theme')}}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('theme')}}/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{asset('theme')}}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{asset('theme')}}/plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="{{asset('theme')}}/plugins/summernote/summernote-bs4.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('theme')}}/dist/css/adminlte.min.css">
    <!-- custom css -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    @stack('styles')
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        {{-- @include('layouts.admin-partials.nav') --}}
        {{-- @include('layouts.admin-partials.sidebar') --}}

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            @auth
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown user-menu show">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                        <img src="{{asset('images/User-Avatar.png')}}" class="user-image img-circle elevation-2"
                            alt="User Image">
                        <span class="d-none d-md-inline">{{Auth::user()->name}}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right user-layout">
                        <!-- User image -->
                        <li class="user-header bg-gray">
                            <img src="{{asset('images/User-Avatar.png')}}" class="img-circle elevation-2"
                                alt="User Image">

                            <p>
                                {{Auth::user()->name}}
                                <small>{{Auth::user()->email}}</small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <a href="{{ route('admin.editPassword') }}" class="btn btn-default btn-flat">Change
                                Password</a>
                            <a class="btn btn-default btn-flat float-right" href="#" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">Sign out</a>
                            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
            @endauth
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{route('admin.home')}}" class="brand-link">
                <img src="{{asset('theme')}}/dist/img/AdminLTELogo.png" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-bold">{{'Admin Panel' }}</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column nav-legacy nav-child-indent" data-widget="treeview"
                        role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="{{route('admin.home')}}"
                                class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['admin.home'])}}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>

                        @if(Auth::guard('admin')->user()->hasRole('admin') ||
                        Auth::guard('admin')->user()->can(['create-admins', 'read-admins',
                        'update-admins', 'delete-admins']))
                        <li class="nav-header text-uppercase">Admin Section</li>

                        <li
                            class="nav-item has-treeview {{Helper::menuOpenClass(Route::currentRouteName(), ['admins.create','admins.index', 'admins.edit'])}}">
                            <a href="#"
                                class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['admins.create','admins.index', 'admins.edit'])}}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Admin Users
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @if(Auth::guard('admin')->user()->hasRole('admin') ||
                                Auth::guard('admin')->user()->can(['create-admins']))
                                <li class="nav-item">
                                    <a href="{{route('admins.create')}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['admins.create'])}}">
                                        <i class="fas fa-plus nav-icon"></i>
                                        <p>Add Admin User</p>
                                    </a>
                                </li>
                                @endif

                                @if(Auth::guard('admin')->user()->hasRole('admin') ||
                                Auth::guard('admin')->user()->can(['read-admins']))
                                <li class="nav-item">
                                    <a href="{{route('admins.index')}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['admins.edit', 'admins.index'])}}">
                                        <i class="fas fa-list nav-icon"></i>
                                        <p>Admin User List</p>
                                    </a>
                                </li>
                                @endif

                            </ul>
                        </li>
                        @endif

                        @if(Auth::guard('admin')->user()->hasRole('admin') ||
                        Auth::guard('admin')->user()->can(['read-clients', 'create-clients',
                        'update-clients',
                        'delete-clients','read-client-users','create-client-users','update-client-users','delete-client-users']))

                        <li class="nav-header text-uppercase">Client Section</li>
                        @if(Auth::guard('admin')->user()->hasRole('admin') ||
                        Auth::guard('admin')->user()->can(['read-clients', 'create-clients',
                        'update-clients', 'delete-clients']))
                        <li
                            class="nav-item has-treeview {{Helper::menuOpenClass(Route::currentRouteName(), ['clients.create','clients.index', 'clients.edit', 'clients.show'])}}">
                            <a href="#"
                                class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['clients.create','clients.index', 'clients.edit', 'clients.show'])}}">
                                <i class="nav-icon fas fa-user-tie"></i>
                                <p>
                                    Clients
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @if(Auth::guard('admin')->user()->hasRole('admin') ||
                                Auth::guard('admin')->user()->can(['create-clients']))
                                <li class="nav-item">
                                    <a href="{{route('clients.create')}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['clients.create'])}}">
                                        <i class="fas fa-plus nav-icon"></i>
                                        <p>Add Client</p>
                                    </a>
                                </li>
                                @endif

                                @if(Auth::guard('admin')->user()->hasRole('admin') ||
                                Auth::guard('admin')->user()->can(['read-clients']))
                                <li class="nav-item">
                                    <a href="{{route('clients.index')}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['clients.edit', 'clients.index', 'clients.show'])}}">
                                        <i class="fas fa-list nav-icon"></i>
                                        <p>Client List</p>
                                    </a>
                                </li>
                                @endif

                            </ul>
                        </li>
                        @endif

                        @if(Auth::guard('admin')->user()->hasRole('admin') ||
                        Auth::guard('admin')->user()->can(['read-client-users', 'create-client-users',
                        'update-client-users', 'delete-client-users']))
                        <li
                            class="nav-item has-treeview {{Helper::menuOpenClass(Route::currentRouteName(), ['client-users.create','client-users.index', 'client-users.edit',  'client-users.change.password'])}}">
                            <a href="#"
                                class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['client-users.create','client-users.index', 'client-users.edit',  'client-users.change.password'])}}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Client Users
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @if(Auth::guard('admin')->user()->hasRole('admin') ||
                                Auth::guard('admin')->user()->can(['create-client-users']))
                                <li class="nav-item">
                                    <a href="{{route('client-users.create')}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['client-users.create'])}}">
                                        <i class="fas fa-plus nav-icon"></i>
                                        <p>Add Client User</p>
                                    </a>
                                </li>
                                @endif

                                @if(Auth::guard('admin')->user()->hasRole('admin') ||
                                Auth::guard('admin')->user()->can(['read-client-users']))
                                <li class="nav-item">
                                    <a href="{{route('client-users.index')}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['client-users.edit', 'client-users.index',  'client-users.change.password'])}}">
                                        <i class="fas fa-list nav-icon"></i>
                                        <p>Client User List</p>
                                    </a>
                                </li>
                                @endif

                            </ul>
                        </li>
                        @endif

                        @endif

                        @if(Auth::guard('admin')->user()->hasRole('admin') ||
                        Auth::guard('admin')->user()->can(['read-client-permissions', 'create-client-permissions',
                        'update-client-permissions', 'delete-client-permissions', 'read-admin-permissions',
                        'create-admin-permissions','update-admin-permissions','delete-admin-permissions']))

                        <li class="nav-header text-uppercase">ACL Section</li>

                        @if(Auth::guard('admin')->user()->hasRole('admin') ||
                        Auth::guard('admin')->user()->can(['read-admin-permissions',
                        'create-admin-permissions','update-admin-permissions','delete-admin-permissions']))

                        <li
                            class="nav-item has-treeview {{Helper::menuOpenClass(Route::currentRouteName(), ['admin-permissions.create','admin-permissions.index', 'admin-permissions.edit'])}}">
                            <a href="#"
                                class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['admin-permissions.create','admin-permissions.index', 'admin-permissions.edit'])}}">
                                <i class="nav-icon fas fa-user-shield"></i>
                                <p>
                                    Admin Permission Groups
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @if(Auth::guard('admin')->user()->hasRole('admin') ||
                                Auth::guard('admin')->user()->can(['create-admin-permissions']))
                                <li class="nav-item">
                                    <a href="{{route('admin-permissions.create')}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['admin-permissions.create'])}}">
                                        <i class="fas fa-plus nav-icon"></i>
                                        <p>Add Permission Group</p>
                                    </a>
                                </li>
                                @endif

                                @if(Auth::guard('admin')->user()->hasRole('admin') ||
                                Auth::guard('admin')->user()->can(['read-admin-permissions']))
                                <li class="nav-item">
                                    <a href="{{route('admin-permissions.index')}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['admin-permissions.edit', 'admin-permissions.index'])}}">
                                        <i class="fas fa-list nav-icon"></i>
                                        <p>Permission Group List</p>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </li>
                        @endif


                        @if(Auth::guard('admin')->user()->hasRole('admin') ||
                        Auth::guard('admin')->user()->can(['read-client-permissions', 'create-client-permissions',
                        'update-client-permissions', 'delete-client-permissions']))

                        <li
                            class="nav-item has-treeview {{Helper::menuOpenClass(Route::currentRouteName(), ['permissions.create','permissions.index', 'permissions.edit'])}}">
                            <a href="#"
                                class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['permissions.create','permissions.index', 'permissions.edit'])}}">
                                <i class="nav-icon fas fa-user-lock"></i>
                                <p>
                                    Client Permission Groups
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @if(Auth::guard('admin')->user()->hasRole('admin') ||
                                Auth::guard('admin')->user()->can(['create-client-permissions']))
                                <li class="nav-item">
                                    <a href="{{route('permissions.create')}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['permissions.create'])}}">
                                        <i class="fas fa-plus nav-icon"></i>
                                        <p>Add permission</p>
                                    </a>
                                </li>
                                @endif

                                @if(Auth::guard('admin')->user()->hasRole('admin') ||
                                Auth::guard('admin')->user()->can(['read-client-permissions']))
                                <li class="nav-item">
                                    <a href="{{route('permissions.index')}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['permissions.edit', 'permissions.index'])}}">
                                        <i class="fas fa-list nav-icon"></i>
                                        <p>Permission Group List</p>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </li>
                        @endif

                        @endif


                        @if(Auth::user()->hasRole('admin') ||
                        Auth::user()->can(['read-banks',
                        'create-banks','update-banks','delete-banks','read-currencies',
                        'create-currencies','update-currencies','delete-currencies'
                        ]))
                        <li class="nav-header text-uppercase">Settings Section</li>

                        @if(Auth::user()->hasRole('admin') ||
                        Auth::user()->can(['read-banks',
                        'create-banks','update-banks','delete-banks'
                        ]))
                        <li
                            class="nav-item has-treeview {{Helper::menuOpenClass(Route::currentRouteName(), ['banks.create','banks.index', 'banks.edit'])}}">
                            <a href="#"
                                class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['banks.create','banks.index', 'banks.edit'])}}">
                                <i class="nav-icon fas fa-id-card"></i>
                                <p>
                                    Banks
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @if(Auth::user()->hasRole('admin') ||
                                Auth::user()->can(['create-banks']))
                                <li class="nav-item">
                                    <a href="{{route('banks.create')}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['banks.create'])}}">
                                        <i class="fas fa-plus nav-icon"></i>
                                        <p>Add Bank</p>
                                    </a>
                                </li>
                                @endif

                                @if(Auth::user()->hasRole('admin') ||
                                Auth::user()->can(['read-banks']))
                                <li class="nav-item">
                                    <a href="{{route('banks.index')}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['banks.edit', 'banks.index'])}}">
                                        <i class="fas fa-list nav-icon"></i>
                                        <p>Bank List</p>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </li>
                        @endif


                        @if(Auth::user()->hasRole('admin') ||
                        Auth::user()->can(['read-currencies',
                        'create-currencies','update-currencies','delete-currencies'
                        ]))
                        <li
                            class="nav-item has-treeview {{Helper::menuOpenClass(Route::currentRouteName(), ['currencies.create','currencies.index', 'currencies.edit'])}}">
                            <a href="#"
                                class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['currencies.create','currencies.index', 'currencies.edit'])}}">
                                <i class="nav-icon fas fa-id-card"></i>
                                <p>
                                    Currencies
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @if(Auth::user()->hasRole('admin') ||
                                Auth::user()->can(['create-currencies']))
                                <li class="nav-item">
                                    <a href="{{route('currencies.create')}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['currencies.create'])}}">
                                        <i class="fas fa-plus nav-icon"></i>
                                        <p>Add Currency</p>
                                    </a>
                                </li>
                                @endif

                                @if(Auth::user()->hasRole('admin') ||
                                Auth::user()->can(['read-currencies']))
                                <li class="nav-item">
                                    <a href="{{route('currencies.index')}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['currencies.edit', 'currencies.index'])}}">
                                        <i class="fas fa-list nav-icon"></i>
                                        <p>Currency List</p>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </li>
                        @endif


                        @endif

                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Main Content Goes Here -->
        <div class="content-wrapper">
            @yield('content')
        </div>

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
                Make Some Beautiful
            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; {{date('Y')}} <a href="https://annanovas.com" target="_blank">AnnaNovas
                    IT</a>.</strong> All rights reserved.
        </footer>



    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="{{asset('theme')}}/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{asset('theme')}}/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('theme')}}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="{{asset('theme')}}/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

    <!-- Summernote -->
    <script src="{{asset('theme')}}/plugins/summernote/summernote-bs4.min.js"></script>
    <!-- Select2 -->
    <script src="{{asset('theme')}}/plugins/select2/js/select2.full.min.js"></script>
    <!-- daterangepicker -->
    <script src="{{asset('theme')}}/plugins/moment/moment.min.js"></script>
    <script src="{{asset('theme')}}/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Custom File Input -->
    <script src="{{asset('theme')}}/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('theme')}}/dist/js/adminlte.min.js"></script>
    <script>
        $(function () {

        $('ul.user-layout').on('click', function (event) {
            event.stopPropagation();
        })

        $('[data-toggle="tooltip"]').tooltip()
        $('.select2').select2({
            theme: 'bootstrap4'
        });
    })

    </script>


    @stack('scripts')
</body>

</html>
