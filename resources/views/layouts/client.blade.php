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
    <!-- Date picker -->
    <link rel="stylesheet" type="text/css" href="{{asset('theme')}}/plugins/datepicker/datepicker3.css" />
    <!-- summernote -->
    <link rel="stylesheet" href="{{asset('theme')}}/plugins/summernote/summernote-bs4.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('theme')}}/dist/css/adminlte.min.css">
    <!-- custom css -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    @stack('styles')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
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
                            <a href="{{ route('client.editPassword', $subdomain) }}"
                                class="btn btn-default btn-flat">Change Password</a>
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
                <span class="brand-text font-weight-bold">{{'Client Panel' }}</span>
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

                        @if(Auth::user()->hasRole('admin') ||
                        Auth::user()->can(['read-roles', 'create-roles','update-roles','delete-roles']))

                        <li class="nav-header text-uppercase">Permission Roles</li>

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
                                @if(Auth::user()->hasRole('admin') ||
                                Auth::user()->can(['create-roles']))
                                <li class="nav-item">
                                    <a href="{{route('roles.create', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['roles.create'])}}">
                                        <i class="fas fa-plus nav-icon"></i>
                                        <p>Add Role</p>
                                    </a>
                                </li>
                                @endif

                                @if(Auth::user()->hasRole('admin') ||
                                Auth::user()->can(['read-roles']))
                                <li class="nav-item">
                                    <a href="{{route('roles.index', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['roles.edit', 'roles.index'])}}">
                                        <i class="fas fa-list nav-icon"></i>
                                        <p>Role List</p>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </li>
                        @endif

                        @if(Auth::user()->hasRole('admin') ||
                        Auth::user()->can(['read-users', 'create-users','update-users','delete-users']))

                        <li class="nav-header text-uppercase">User Section</li>
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
                                @if(Auth::user()->hasRole('admin') ||
                                Auth::user()->can(['create-users']))
                                <li class="nav-item">
                                    <a href="{{route('users.create', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['users.create'])}}">
                                        <i class="fas fa-plus nav-icon"></i>
                                        <p>Add user</p>
                                    </a>
                                </li>
                                @endif

                                @if(Auth::user()->hasRole('admin') ||
                                Auth::user()->can(['read-users']))
                                <li class="nav-item">
                                    <a href="{{route('users.index', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['users.edit', 'users.index', 'users.change.password'])}}">
                                        <i class="fas fa-list nav-icon"></i>
                                        <p>User List</p>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </li>
                        @endif

                        @if(Auth::user()->hasRole('admin') ||
                        Auth::user()->can([
                        'read-material-categories','create-material-categories','update-material-categories','delete-material-categories',
                        'read-product-categories','create-product-categories','update-product-categories','delete-product-categories',
                        'read-materials','create-materials','update-materials','delete-materials',
                        'read-products','create-products','update-products','delete-products',
                        'read-productions','create-productions','update-productions','delete-productions',
                        'read-production-cost-categories','create-production-cost-categories','update-production-cost-categories','delete-production-cost-categories','read-product-transfers','create-product-transfers','update-product-transfers','delete-product-transfers',
                        ]))
                        <li class="nav-header text-uppercase">Warehouse Section</li>

                        @if(Auth::user()->hasRole('admin') ||
                        Auth::user()->can([
                        'read-material-categories','create-material-categories','update-material-categories','delete-material-categories',
                        'read-product-categories','create-product-categories','update-product-categories','delete-product-categories'
                        ]))
                        <li
                            class="nav-item has-treeview {{Helper::menuOpenClass(Route::currentRouteName(), ['material-categories.create','material-categories.index', 'material-categories.edit', 'product-categories.create','product-categories.index', 'product-categories.edit'])}}">
                            <a href="#"
                                class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['material-categories.create','material-categories.index', 'material-categories.edit',  'product-categories.create','product-categories.index', 'product-categories.edit'])}}">
                                <i class="nav-icon fas fa-th-large"></i>
                                <p>
                                    Categories
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @if(Auth::user()->hasRole('admin') ||
                                Auth::user()->can([
                                'read-material-categories','create-material-categories','update-material-categories','delete-material-categories'
                                ]))
                                <li class="nav-item">
                                    <a href="{{route('material-categories.index', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['material-categories.create','material-categories.index', 'material-categories.edit',])}}">
                                        <i class="fas fa-truck-loading nav-icon"></i>
                                        <p>Material Categories</p>
                                    </a>
                                </li>
                                @endif

                                @if(Auth::user()->hasRole('admin') ||
                                Auth::user()->can(['read-product-categories','create-product-categories','update-product-categories','delete-product-categories'
                                ]))
                                <li class="nav-item">
                                    <a href="{{route('product-categories.index', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), [ 'product-categories.create','product-categories.index', 'product-categories.edit'])}}">
                                        <i class="fas fa-boxes nav-icon"></i>
                                        <p>Product Categories</p>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </li>
                        @endif

                        @if(Auth::user()->hasRole('admin') ||
                        Auth::user()->can(['read-materials','create-materials','update-materials','delete-materials'
                        ]))
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
                                @if(Auth::user()->hasRole('admin') ||
                                Auth::user()->can(['create-materials']))
                                <li class="nav-item">
                                    <a href="{{route('materials.create', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['materials.create'])}}">
                                        <i class="fas fa-plus nav-icon"></i>
                                        <p>Add Material</p>
                                    </a>
                                </li>
                                @endif

                                @if(Auth::user()->hasRole('admin') ||
                                Auth::user()->can(['read-materials']))
                                <li class="nav-item">
                                    <a href="{{route('materials.index', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['materials.index', 'materials.edit'])}}">
                                        <i class="fas fa-list nav-icon"></i>
                                        <p>Manage Materials</p>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </li>
                        @endif

                        @if(Auth::user()->hasRole('admin') ||
                        Auth::user()->can(['read-products','create-products','update-products','delete-products']))

                        <li class="nav-item has-treeview {{Helper::menuOpenClass(Route::currentRouteName(),
                ['products.create','products.index', 'products.edit', 'products.show'])}}">
                            <a href="#" class="nav-link {{Helper::activeClass(Route::currentRouteName(),
                ['products.create','products.index', 'products.edit', 'products.show'])}}">
                                <i class="nav-icon fas fa-boxes"></i>
                                <p>
                                    Product Inventories
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @if(Auth::user()->hasRole('admin') ||
                                Auth::user()->can(['create-products']))
                                <li class="nav-item">
                                    <a href="{{route('products.create', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['products.create'])}}">
                                        <i class="fas fa-plus nav-icon"></i>
                                        <p>Add Product</p>
                                    </a>
                                </li>
                                @endif
                                @if(Auth::user()->hasRole('admin') ||
                                Auth::user()->can(['read-products']))
                                <li class="nav-item">
                                    <a href="{{route('products.index', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['products.index', 'products.edit', 'products.show'])}}">
                                        <i class="fas fa-list nav-icon"></i>
                                        <p>Product List</p>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </li>
                        @endif

                        @if(Auth::user()->hasRole('admin') ||
                        Auth::user()->can(['read-product-transfers','create-product-transfers','update-product-transfers','delete-product-transfers']))

                        <li
                            class="nav-item has-treeview {{Helper::menuOpenClass(Route::currentRouteName(),
                ['product-transfers.create','product-transfers.index', 'product-transfers.edit', 'product-transfers.show','product-transfers.addProductCreate','product-transfers.transferReject'])}}">
                            <a href="#"
                                class="nav-link {{Helper::activeClass(Route::currentRouteName(),
                ['product-transfers.create','product-transfers.index', 'product-transfers.edit', 'product-transfers.show','product-transfers.addProductCreate'])}}">
                                <i class="nav-icon fas fa-truck-moving"></i>
                                <p>
                                    Product Transfers
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @if(Auth::user()->hasRole('admin') ||
                                Auth::user()->can(['create-product-transfers']))
                                <li class="nav-item">
                                    <a href="{{route('product-transfers.create', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['product-transfers.create'])}}">
                                        <i class="fas fa-plus nav-icon"></i>
                                        <p>Add Product Transfer</p>
                                    </a>
                                </li>
                                @endif
                                @if(Auth::user()->hasRole('admin') ||
                                Auth::user()->can(['read-product-transfers']))
                                <li class="nav-item">
                                    <a href="{{route('product-transfers.index', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['product-transfers.index', 'product-transfers.edit', 'product-transfers.show'])}}">
                                        <i class="fas fa-list nav-icon"></i>
                                        <p>Product Transfer List</p>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </li>
                        @endif

                        @if(Auth::user()->hasRole('admin') ||
                        Auth::user()->can(['read-productions','create-productions','update-productions','delete-productions']))

                        <li
                            class="nav-item has-treeview {{Helper::menuOpenClass(Route::currentRouteName(),
            ['productions.create','productions.index', 'productions.edit', 'productions.show', 'productions.materials.add', 'productions.materials.edit',
             'productions.showCompleteForm', 'productions.costs.create', 'productions.costs.edit','productions.addToInventory'])}}">
                            <a href="#"
                                class="nav-link {{Helper::activeClass(Route::currentRouteName(),
            ['productions.create','productions.index', 'productions.edit', 'productions.show', 'productions.materials.add', 'productions.materials.edit',
             'productions.showCompleteForm', 'productions.costs.create', 'productions.costs.edit','productions.addToInventory'])}}">
                                <i class="nav-icon fas fa-box-open"></i>
                                <p>
                                    Productions
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @if(Auth::user()->hasRole('admin') ||
                                Auth::user()->can(['create-productions']))
                                <li class="nav-item">
                                    <a href="{{route('productions.create', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['productions.create', 'productions.materials.add'])}}">
                                        <i class="fas fa-plus nav-icon"></i>
                                        <p>New Production</p>
                                    </a>
                                </li>
                                @endif

                                @if(Auth::user()->hasRole('admin') ||
                                Auth::user()->can(['read-productions']))
                                <li class="nav-item">
                                    <a href="{{route('productions.index', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['productions.index', 'productions.edit', 'productions.show','productions.addToInventory'])}}">
                                        <i class="fas fa-list nav-icon"></i>
                                        <p>Productions List</p>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </li>
                        @endif


                        @if(Auth::user()->hasRole('admin') ||
                        Auth::user()->can(['read-production-cost-categories','create-production-cost-categories','update-production-cost-categories','delete-production-cost-categories']))

                        <li
                            class="nav-item has-treeview {{Helper::menuOpenClass(Route::currentRouteName(),
            ['production-cost-categories.index', 'production-cost-categories.edit', 'production-cost-categories.create'])}}">
                            <a href="#"
                                class="nav-link {{Helper::activeClass(Route::currentRouteName(),
            ['production-cost-categories.index', 'production-cost-categories.edit', 'production-cost-categories.create'])}}">
                                <i class="nav-icon fas fa-dollar-sign"></i>
                                <p>
                                    Cost Categories
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @if(Auth::user()->hasRole('admin') ||
                                Auth::user()->can(['create-production-cost-categories']))
                                <li class="nav-item">
                                    <a href="{{route('production-cost-categories.create', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['production-cost-categories.create'])}}">
                                        <i class="fas fa-plus nav-icon"></i>
                                        <p>New Cost Category</p>
                                    </a>
                                </li>
                                @endif

                                @if(Auth::user()->hasRole('admin') ||
                                Auth::user()->can(['read-production-cost-categories']))
                                <li class="nav-item">
                                    <a href="{{route('production-cost-categories.index', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['production-cost-categories.index', 'production-cost-categories.edit'])}}">
                                        <i class="fas fa-list nav-icon"></i>
                                        <p>Cost Category List</p>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </li>
                        @endif

                        @endif


                        @if(Auth::user()->hasRole('admin') ||
                        Auth::user()->can(['read-branches','create-branches','update-branches','delete-branches','read-branch-product-inventories','create-branch-product-inventories','update-branch-product-inventories','delete-branch-product-inventories']))
                        <li class="nav-header text-uppercase">Branch Section</li>

                        @if(Auth::user()->hasRole('admin') ||
                        Auth::user()->can(['read-branches','create-branches','update-branches','delete-branches']))
                        <li
                            class="nav-item has-treeview {{Helper::menuOpenClass(Route::currentRouteName(), ['branches.create','branches.index', 'branches.edit', 'branches.show','branch-users.create'])}}">
                            <a href="#"
                                class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['branches.create','branches.index', 'branches.edit', 'branches.show','branch-users.create'])}}">
                                <i class="nav-icon fas fa-store"></i>
                                <p>
                                    Branches
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @if(Auth::user()->hasRole('admin') ||
                                Auth::user()->can(['create-branches']))
                                <li class="nav-item">
                                    <a href="{{route('branches.create', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['branches.create'])}}">
                                        <i class="fas fa-plus nav-icon"></i>
                                        <p>Add Branch</p>
                                    </a>
                                </li>
                                @endif

                                @if(Auth::user()->hasRole('admin') ||
                                Auth::user()->can(['read-branches']))
                                <li class="nav-item">
                                    <a href="{{route('branches.index', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['branches.index', 'branches.edit', 'branches.show'])}}">
                                        <i class="fas fa-list nav-icon"></i>
                                        <p>Branch List</p>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </li>
                        @endif

                        @if(Auth::user()->hasRole('admin') ||
                        Auth::user()->can(['read-branch-product-inventories','create-branch-product-inventories','update-branch-product-inventories','delete-branch-product-inventories']))
                        <li
                            class="nav-item has-treeview {{Helper::menuOpenClass(Route::currentRouteName(), ['branch-product-inventories.create','branch-product-inventories.index', 'branch-product-inventories.edit', 'branch-product-inventories.show'])}}">
                            <a href="#"
                                class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['branch-product-inventories.create','branch-product-inventories.index', 'branch-product-inventories.edit', 'branch-product-inventories.show'])}}">
                                <i class="nav-icon fas fa-boxes"></i>
                                <p>
                                    Product Inventories
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @if(Auth::user()->hasRole('admin') ||
                                Auth::user()->can(['create-branch-product-inventories']))
                                <li class="nav-item">
                                    <a href="{{route('branch-product-inventories.create', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['branch-product-inventories.create'])}}">
                                        <i class="fas fa-plus nav-icon"></i>
                                        <p>Add Product Inventory</p>
                                    </a>
                                </li>
                                @endif

                                @if(Auth::user()->hasRole('admin') ||
                                Auth::user()->can(['read-branch-product-inventories']))
                                <li class="nav-item">
                                    <a href="{{route('branch-product-inventories.index', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['branch-product-inventories.index', 'branch-product-inventories.edit', 'branch-product-inventories.show'])}}">
                                        <i class="fas fa-list nav-icon"></i>
                                        <p>Product Inventory List</p>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </li>
                        @endif

                        @if(Auth::user()->hasRole('admin') ||
                                Auth::user()->can(['read-product-transfer-receives']))
                                <li class="nav-item">
                                    <a href="{{route('product-transfer-receives.index', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['product-transfer-receives.index','product-transfer-receives.create','product-transfer-receives.show','product-transfer-receives.receivedReject'])}}">
                                        <i class="fas fa-handshake nav-icon"></i>
                                        <p>Product Transfer Received</p>
                                    </a>
                                </li>
                                @endif

                        @endif

                        @if(Auth::user()->hasRole('admin') ||
                        Auth::user()->can([
                        'read-accounts','create-accounts','update-accounts','delete-accounts',
                        'read-purchases','create-purchases','update-purchases','delete-purchases',
                        'read-suppliers','create-suppliers','update-suppliers','delete-suppliers',
                        'read-costs','create-costs','update-costs','delete-costs',
                        'read-costs','create-costs','update-costs','delete-costs',
                        'read-expenses','create-expenses','update-expenses','delete-expenses'
                        ]))
                        <li class="nav-header text-uppercase">Accounting Section</li>

                        @if(Auth::user()->hasRole('admin') ||
                        Auth::user()->can([
                        'read-accounts','create-accounts','update-accounts','delete-accounts']))
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
                                @if(Auth::user()->hasRole('admin') ||
                                Auth::user()->can(['create-accounts']))
                                <li class="nav-item">
                                    <a href="{{route('accounts.create', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['accounts.create'])}}">
                                        <i class="fas fa-plus nav-icon"></i>
                                        <p>Add Account</p>
                                    </a>
                                </li>
                                @endif
                                @if(Auth::user()->hasRole('admin') ||
                                Auth::user()->can([
                                'read-accounts','create-accounts','update-accounts','delete-accounts']))
                                <li class="nav-item">
                                    <a href="{{route('accounts.index', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['accounts.index', 'accounts.edit', 'accounts.show'])}}">
                                        <i class="fas fa-list nav-icon"></i>
                                        <p>Account List</p>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </li>
                        @endif

                        @if(Auth::user()->hasRole('admin') ||
                        Auth::user()->can([
                        'read-purchases','create-purchases','update-purchases','delete-purchases']))

                        <li class="nav-item has-treeview {{Helper::menuOpenClass(Route::currentRouteName(),
                ['purchases.create','purchases.index', 'purchases.edit', 'purchases.show', 'purchases.materials.add',
                'purchases.materials.edit', 'purchases.receives.create', 'purchases.bills.create',
                'costs.index', 'costs.edit'])}}">

                            <a href="#" class="nav-link {{Helper::activeClass(Route::currentRouteName(),
                ['purchases.create','purchases.index', 'purchases.edit', 'purchases.show', 'purchases.materials.add',
                'purchases.materials.edit', 'purchases.receives.create',  'purchases.bills.create',
                'costs.index', 'costs.edit'])}}">

                                <i class="nav-icon fas fa-money-bill"></i>
                                <p>
                                    Purchase Orders(PO)
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @if(Auth::user()->hasRole('admin') ||
                                Auth::user()->can(['create-purchases']))
                                <li class="nav-item">
                                    <a href="{{route('purchases.create', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['purchases.create', 'purchases.materials.add'])}}">
                                        <i class="fas fa-plus nav-icon"></i>
                                        <p>Add Purchase</p>
                                    </a>
                                </li>
                                @endif

                                @if(Auth::user()->hasRole('admin') ||
                                Auth::user()->can(['read-purchases']))
                                <li class="nav-item">
                                    <a href="{{route('purchases.index', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['purchases.index', 'purchases.edit',  'purchases.show', 'purchases.materials.edit'])}}">
                                        <i class="fas fa-list nav-icon"></i>
                                        <p>Purchase List</p>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </li>
                        @endif

                        @if(Auth::user()->hasRole('admin') ||
                        Auth::user()->can([
                        'read-costs','create-costs','update-costs','delete-costs']))
                        <li
                            class="nav-item has-treeview {{Helper::menuOpenClass(Route::currentRouteName(), ['costs.create','costs.index', 'costs.edit'])}}">
                            <a href="#"
                                class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['costs.create','costs.index', 'costs.edit'])}}">
                                <i class="nav-icon fas fa-id-card"></i>
                                <p>
                                    Purchase Costs
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @if(Auth::user()->hasRole('admin') ||
                                Auth::user()->can(['create-costs']))
                                <li class="nav-item">
                                    <a href="{{route('costs.create', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['costs.create'])}}">
                                        <i class="fas fa-plus nav-icon"></i>
                                        <p>Add Cost</p>
                                    </a>
                                </li>
                                @endif
                                @if(Auth::user()->hasRole('admin') ||
                                Auth::user()->can(['read-costs']))
                                <li class="nav-item">
                                    <a href="{{route('costs.index', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['costs.index', 'costs.edit'])}}">
                                        <i class="fas fa-list nav-icon"></i>
                                        <p>Cost List</p>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </li>
                        @endif


                        @if(Auth::user()->hasRole('admin') ||
                        Auth::user()->can(['read-expenses','create-expenses','update-expenses','delete-expenses']))
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
                                @if(Auth::user()->hasRole('admin') ||
                                Auth::user()->can(['create-expenses']))
                                <li class="nav-item">
                                    <a href="{{route('expenses.create', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['expenses.create'])}}">
                                        <i class="fas fa-plus nav-icon"></i>
                                        <p>Add Expense</p>
                                    </a>
                                </li>
                                @endif

                                @if(Auth::user()->hasRole('admin') ||
                                Auth::user()->can(['read-expenses']))
                                <li class="nav-item">
                                    <a href="{{route('expenses.index', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['expenses.index', 'expenses.edit'])}}">
                                        <i class="fas fa-list nav-icon"></i>
                                        <p>Expense List</p>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </li>
                        @endif

                        @if(Auth::user()->hasRole('admin') ||
                        Auth::user()->can([
                        'read-suppliers','create-suppliers','update-suppliers','delete-suppliers'
                        ]))
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

                                @if(Auth::user()->hasRole('admin') ||
                                Auth::user()->can(['create-suppliers']))
                                <li class="nav-item">
                                    <a href="{{route('suppliers.create', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['suppliers.create'])}}">
                                        <i class="fas fa-plus nav-icon"></i>
                                        <p>Add Supplier</p>
                                    </a>
                                </li>
                                @endif

                                @if(Auth::user()->hasRole('admin') ||
                                Auth::user()->can(['read-suppliers']))
                                <li class="nav-item">
                                    <a href="{{route('suppliers.index', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['suppliers.index', 'suppliers.edit', 'suppliers.show'])}}">
                                        <i class="fas fa-list nav-icon"></i>
                                        <p>Supplier List</p>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </li>
                        @endif

                        @endif

                        @if(Auth::user()->hasRole('admin') ||
                        Auth::user()->can([
                        'read-units', 'create-units','update-units','delete-units',
                        'read-transaction-categories',
                        'create-transaction-categories','update-transaction-categories','delete-transaction-categories',
                        'read-cost-types', 'create-cost-types','update-cost-types','delete-cost-types'
                        ]))


                        <li class="nav-header text-uppercase">Settings Section</li>

                        @if(Auth::user()->hasRole('admin') ||
                        Auth::user()->can([
                        'read-units', 'create-units','update-units','delete-units'
                        ]))
                        <li
                            class="nav-item has-treeview {{Helper::menuOpenClass(Route::currentRouteName(), ['units.create','units.index', 'units.edit'])}}">
                            <a href="#"
                                class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['units.create','units.index', 'units.edit'])}}">
                                <i class="nav-icon fas fa-id-card"></i>
                                <p>
                                    Units
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @if(Auth::user()->hasRole('admin') ||
                                Auth::user()->can(['create-units']))
                                <li class="nav-item">
                                    <a href="{{route('units.create', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['units.create'])}}">
                                        <i class="fas fa-plus nav-icon"></i>
                                        <p>Add Unit</p>
                                    </a>
                                </li>
                                @endif

                                @if(Auth::user()->hasRole('admin') ||
                                Auth::user()->can(['read-units']))
                                <li class="nav-item">
                                    <a href="{{route('units.index', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['units.edit', 'units.index'])}}">
                                        <i class="fas fa-list nav-icon"></i>
                                        <p>Unit List</p>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </li>
                        @endif

                        @if(Auth::user()->hasRole('admin') ||
                        Auth::user()->can(['read-cost-types',
                        'create-cost-types','update-cost-types','delete-cost-types'
                        ]))
                        <li
                            class="nav-item has-treeview {{Helper::menuOpenClass(Route::currentRouteName(), ['cost-types.create','cost-types.index', 'cost-types.edit'])}}">
                            <a href="#"
                                class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['cost-types.create','cost-types.index', 'cost-types.edit'])}}">
                                <i class="nav-icon fas fa-id-card"></i>
                                <p>
                                    Cost Types
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @if(Auth::user()->hasRole('admin') ||
                                Auth::user()->can(['create-cost-types']))
                                <li class="nav-item">
                                    <a href="{{route('cost-types.create', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['cost-types.create'])}}">
                                        <i class="fas fa-plus nav-icon"></i>
                                        <p>Add Cost Type</p>
                                    </a>
                                </li>
                                @endif

                                @if(Auth::user()->hasRole('admin') ||
                                Auth::user()->can(['read-cost-types']))
                                <li class="nav-item">
                                    <a href="{{route('cost-types.index', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['cost-types.edit', 'cost-types.index'])}}">
                                        <i class="fas fa-list nav-icon"></i>
                                        <p>Cost Type List</p>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </li>
                        @endif

                        @if(Auth::user()->hasRole('admin') ||
                        Auth::user()->can(['create-transaction-categories','update-transaction-categories','delete-transaction-categories'
                        ]))
                        <li
                            class="nav-item has-treeview {{Helper::menuOpenClass(Route::currentRouteName(), ['transaction-categories.create','transaction-categories.index', 'transaction-categories.edit'])}}">
                            <a href="#"
                                class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['transaction-categories.create','transaction-categories.index', 'transaction-categories.edit'])}}">
                                <i class="nav-icon fas fa-id-card"></i>
                                <p>
                                    Transaction Categories
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @if(Auth::user()->hasRole('admin') ||
                                Auth::user()->can(['create-transaction-categories']))
                                <li class="nav-item">
                                    <a href="{{route('transaction-categories.create', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['transaction-categories.create'])}}">
                                        <i class="fas fa-plus nav-icon"></i>
                                        <p>Add Transaction Category</p>
                                    </a>
                                </li>
                                @endif

                                @if(Auth::user()->hasRole('admin') ||
                                Auth::user()->can(['read-transaction-categories']))
                                <li class="nav-item">
                                    <a href="{{route('transaction-categories.index', $subdomain)}}"
                                        class="nav-link {{Helper::activeClass(Route::currentRouteName(), ['transaction-categories.edit', 'transaction-categories.index'])}}">
                                        <i class="fas fa-list nav-icon"></i>
                                        <p>Transaction Category List</p>
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
                    IT Ltd</a>.</strong> All rights reserved.
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
    <script type="text/javascript" src="{{asset('theme')}}/plugins/datepicker/bootstrap-datepicker.js"></script>
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
            placeholder: 'Choose an option',
            theme: 'bootstrap4'
        });
    })

    </script>


    @stack('scripts')
</body>

</html>
