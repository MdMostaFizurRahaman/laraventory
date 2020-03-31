<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>{{config('app.name', 'Laraventory')}} | @yield('title')</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{asset('theme')}}/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('theme')}}/dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('theme')}}/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{asset('theme')}}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- custom css -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    @stack('styles')
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        {{--
        @include('layouts.client-partials.nav')
        @include('layouts.client-partials.sidebar') --}}
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
                        <img src="{{asset('theme')}}/dist/img/user2-160x160.jpg"
                            class="user-image img-circle elevation-2" alt="User Image">
                        <span class="d-none d-md-inline">{{Auth::user()->name}}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right user-layout">
                        <!-- User image -->
                        <li class="user-header bg-primary">
                            <img src="{{asset('theme')}}/dist/img/user2-160x160.jpg" class="img-circle elevation-2"
                                alt="User Image">

                            <p>
                                {{Auth::user()->name}}
                                <small>{{Auth::user()->email}}</small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <a href="#" class="btn btn-default btn-flat">Profile</a>
                            <a class="btn btn-default btn-flat float-right" href="#" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">Sign out</a>
                            <form id="logout-form" action="{{ route('logout', $subdomain) }}" method="POST"
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
            <a href="{{route('client.home', $subdomain)}}" class="brand-link">
                <img src="{{asset('theme')}}/dist/img/AdminLTELogo.png" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light"><b>{{'Client Panel' }}</b></span>
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
                            <a href="{{route('client.home', $subdomain)}}"
                                class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['client.home'])}}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>

                        <li class="nav-header text-uppercase">Warehouse Section</li>
                        <li
                            class="nav-item has-treeview {{Helper::menuOpenClass(Route::currentRouteName(), ['material-categories.index', 'material-categories.edit', 'product-categories.index', 'product-categories.edit'])}}">
                            <a href="#"
                                class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['material-categories.index', 'material-categories.edit', 'product-categories.index', 'product-categories.edit'])}}">
                                <i class="nav-icon fas fa-th-large"></i>
                                <p>
                                    Categories
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('material-categories.index', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['material-categories.index', 'material-categories.edit',])}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Material Categories</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('product-categories.index', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['product-categories.index', 'product-categories.edit'])}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Product Categories</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li
                            class="nav-item has-treeview {{Helper::menuOpenClass(Route::currentRouteName(), ['materials.create','materials.index', 'materials.edit'])}}">
                            <a href="#"
                                class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['materials.create','materials.index', 'materials.edit'])}}">
                                <i class="nav-icon fas fa-truck-loading"></i>
                                <p>
                                    Materials
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('materials.create', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['materials.create'])}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add Material</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('materials.index', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['materials.index', 'materials.edit'])}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Manage Materials</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview {{Helper::menuOpenClass(Route::currentRouteName(),
                ['products.create','products.index', 'products.edit', 'products.show'])}}">
                            <a href="#" class="nav-link {{Helper::activeClass(Route::currentRouteName(),
                ['products.create','products.index', 'products.edit', 'products.show'])}}">
                                <i class="nav-icon fas fa-boxes"></i>
                                <p>
                                    Products
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('products.create', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['products.create'])}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add Products</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('products.index', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['products.index', 'products.edit', 'products.show'])}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Manage Products</p>
                                    </a>
                                </li>

                            </ul>
                        </li>
                        <li
                            class="nav-item has-treeview {{Helper::menuOpenClass(Route::currentRouteName(),
            ['productions.create','productions.index', 'productions.edit', 'productions.show', 'productions.materials.add', 'productions.materials.edit',
             'productions.showCompleteForm', 'production-cost-categories.index', 'production-cost-categories.edit', 'productions.costs.create', 'productions.costs.edit'])}}">
                            <a href="#"
                                class="nav-link {{Helper::activeClass(Route::currentRouteName(),
            ['productions.create','productions.index', 'productions.edit', 'productions.show', 'productions.materials.add', 'productions.materials.edit',
             'productions.showCompleteForm', 'production-cost-categories.index', 'production-cost-categories.edit', 'productions.costs.create', 'productions.costs.edit'])}}">
                                <i class="nav-icon fas fa-box-open"></i>
                                <p>
                                    Productions
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('productions.create', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['productions.create', 'productions.materials.add'])}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>New Production</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('productions.index', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['productions.index', 'productions.edit', 'productions.show'])}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Manage Productions</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('production-cost-categories.index', $subdomain)}}" class="nav-link {{Helper::activeClass(Route::currentRouteName(),
                        ['production-cost-categories.index', 'production-cost-categories.edit'])}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Cost Categories</p>
                                    </a>
                                </li>
                            </ul>
                        </li>


                        <li class="nav-header text-uppercase">Branch Section</li>
                        <li
                            class="nav-item has-treeview {{Helper::menuOpenClass(Route::currentRouteName(), ['branches.create','branches.index', 'branches.edit', 'branches.show'])}}">
                            <a href="#"
                                class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['branches.create','branches.index', 'branches.edit', 'branches.show'])}}">
                                <i class="nav-icon fas fa-store"></i>
                                <p>
                                    Branches
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('branches.create', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['branches.create'])}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add Branch</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('branches.index', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['branches.index', 'branches.edit', 'branches.show'])}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Manage Branches</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-header text-uppercase">Accounting Section</li>
                        <li
                            class="nav-item has-treeview {{Helper::menuOpenClass(Route::currentRouteName(), ['accounts.create','accounts.index', 'accounts.edit', 'accounts.show'])}}">
                            <a href="#"
                                class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['accounts.create','accounts.index', 'accounts.edit', 'accounts.show'])}}">
                                <i class="nav-icon fas fa-university"></i>
                                <p>
                                    Accounts
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('accounts.create', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['accounts.create'])}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add Accounts</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('accounts.index', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['accounts.index', 'accounts.edit', 'accounts.show'])}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Manage Accounts</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview {{Helper::menuOpenClass(Route::currentRouteName(),
                ['purchases.create','purchases.index', 'purchases.edit', 'purchases.materials.add',
                'purchases.materials.edit', 'purchases.receives.create', 'purchases.bills.create',
                'costs.index', 'costs.edit'])}}">

                            <a href="#" class="nav-link {{Helper::activeClass(Route::currentRouteName(),
                ['purchases.create','purchases.index', 'purchases.edit','purchases.materials.add',
                'purchases.materials.edit', 'purchases.receives.create',  'purchases.bills.create',
                'costs.index', 'costs.edit'])}}">

                                <i class="nav-icon fas fa-money-bill"></i>
                                <p>
                                    Purchases
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('purchases.create', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['purchases.create', 'purchases.materials.add'])}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add Purchases</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('purchases.index', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['purchases.index', 'purchases.edit', 'purchases.materials.edit'])}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Purchase History</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('costs.index', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['costs.index', 'costs.edit'])}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Purchase Costs</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li
                            class="nav-item has-treeview {{Helper::menuOpenClass(Route::currentRouteName(), ['expenses.create','expenses.index', 'expenses.edit'])}}">
                            <a href="#"
                                class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['expenses.create','expenses.index', 'expenses.edit'])}}">
                                <i class="nav-icon fas fa-wallet"></i>
                                <p>
                                    Expenses
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('expenses.create', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['expenses.create'])}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add Expense</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('expenses.index', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['expenses.index', 'expenses.edit'])}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Expense History</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li
                            class="nav-item has-treeview {{Helper::menuOpenClass(Route::currentRouteName(), ['suppliers.create','suppliers.index', 'suppliers.edit', 'suppliers.show'])}}">
                            <a href="#"
                                class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['suppliers.create','suppliers.index', 'suppliers.edit', 'suppliers.show'])}}">
                                <i class="nav-icon fas fa-user-tie"></i>
                                <p>
                                    Suppliers
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('suppliers.create', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['suppliers.create'])}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add Supplier</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('suppliers.index', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['suppliers.index', 'suppliers.edit', 'suppliers.show'])}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Manage Suppliers</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-header text-uppercase">Admin Section</li>
                        <li
                            class="nav-item has-treeview {{Helper::menuOpenClass(Route::currentRouteName(), ['users.create','users.index', 'users.edit', 'users.change.password'])}}">
                            <a href="#"
                                class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['users.create','users.index', 'users.edit', 'users.change.password'])}}">
                                <i class="nav-icon fa fa-users"></i>
                                <p>
                                    Users
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('users.create', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['users.create'])}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add user</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('users.index', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['users.edit', 'users.index', 'users.change.password'])}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Manage Users</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li
                            class="nav-item has-treeview {{Helper::menuOpenClass(Route::currentRouteName(), ['roles.create','roles.index', 'roles.edit'])}}">
                            <a href="#"
                                class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['roles.create','roles.index', 'roles.edit'])}}">
                                <i class="nav-icon fas fa-id-card"></i>
                                <p>
                                    Roles
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('roles.create', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['roles.create'])}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add Role</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('roles.index', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['roles.edit', 'roles.index'])}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Manage Roles</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li
                            class="nav-item has-treeview {{Helper::menuOpenClass(Route::currentRouteName(),
                ['units.index', 'units.edit', 'currencies.index', 'currencies.edit', 'banks.index', 'banks.edit', 'transaction-categories.index', 'transaction-categories.edit','cost-types.index', 'cost-types.edit'])}}">
                            <a href="#"
                                class="nav-link {{Helper::activeClass(Route::currentRouteName(),
                ['units.index', 'units.edit', 'currencies.index', 'currencies.edit', 'banks.index', 'banks.edit', 'transaction-categories.index', 'transaction-categories.edit', 'cost-types.index', 'cost-types.edit'])}}">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>
                                    Settings
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('units.index', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['units.index', 'units.edit',])}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Units</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('currencies.index', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['currencies.index', 'currencies.edit'])}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Currencies</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('banks.index', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['banks.index', 'banks.edit'])}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Banks</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('cost-types.index', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['cost-types.index', 'cost-types.edit'])}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Cost Types</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('transaction-categories.index', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['transaction-categories.index', 'transaction-categories.edit'])}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Transaction Categories</p>
                                    </a>
                                </li>
                            </ul>
                        </li>


                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>


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
    <!-- Bootstrap 4 -->
    <script src="{{asset('theme')}}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('theme')}}/dist/js/adminlte.min.js"></script>

    <!-- Select2 -->
    <script src="{{asset('theme')}}/plugins/select2/js/select2.full.min.js"></script>

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
