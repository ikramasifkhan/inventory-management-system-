@php
    use Illuminate\Support\Facades\Route;
    $prefix = request()->route()->getPrefix();
    $route = Route::current()->getName();
@endphp
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{route('home')}}" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">Contact</a>
        </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
        <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <span class=""><b>{{auth()->user()->name}}</b></span>
            </a>
            <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('home')}}" class="brand-link">
        <img src="{{asset('public/backend')}}/dist/img/AdminLTELogo.png" alt="AdminLTE Logo"
             class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">Admin Dashboard</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img
                    src="{{(!empty(auth()->user()->image))?url('public/uploads/user_image/'.auth()->user()->image):url('public/uploads/no_image.jpg')}}"
                    class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="{{route('home')}}" class="d-block">{{auth()->user()->name}}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item has-treeview menu-open">
                    <a href="{{route('home')}}" class="nav-link {{$route == 'home'?'active':''}}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>

                </li>
                <li class="nav-item has-treeview {{($prefix == '/users' ?'menu-open':'')}}">
                    <a href="#" class="nav-link {{($prefix == '/users' ?'active':'')}}">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            Manage Users
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('users.view')}}"
                               class="nav-link {{($route == 'users.view' ?'active':'')}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>View user</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview {{($prefix == '/profiles' ?'menu-open':'')}}">
                    <a href="#" class="nav-link {{($prefix == '/profiles' ?'active':'')}}">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            Manage your profile
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('profiles.view')}}"
                               class="nav-link {{($route == 'profiles.view' ?'active':'')}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>View your profile</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('profiles.password.view')}}"
                               class="nav-link {{($route == 'profiles.password.view' ?'active':'')}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Change your password</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview {{($prefix == '/suppliers' ?'menu-open':'')}}">
                    <a href="#" class="nav-link {{($prefix == '/suppliers' ?'active':'')}}">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            Manage suppliers
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('suppliers.view')}}"
                               class="nav-link {{($route == 'suppliers.view' ?'active':'')}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>View suppliers</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview {{($prefix =='/customers' ? 'menu-open': '')}}">
                    <a href="#" class="nav-link {{($prefix =='/customers' ? 'active': '')}}">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            Manage customer
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('customers.view')}}"
                               class="nav-link {{($route == 'customers.view'?'active':'')}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>View customers</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview {{($prefix =='/units' ? 'menu-open': '')}}">
                    <a href="#" class="nav-link {{($prefix =='/units' ? 'active': '')}}">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            Manage units
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('units.view')}}" class="nav-link {{($route == 'units.view'?'active':'')}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>View units</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview {{($prefix =='/categories' ? 'menu-open': '')}}">
                    <a href="#" class="nav-link {{($prefix =='/categories' ? 'active': '')}}">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            Manage categories
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('categories.view')}}"
                               class="nav-link {{($route == 'categories.view'?'active':'')}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>View categories</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview {{($prefix =='/products' ? 'menu-open': '')}}">
                    <a href="#" class="nav-link {{($prefix =='/products' ? 'active': '')}}">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            Manage products
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('products.view')}}"
                               class="nav-link {{($route == 'products.view'?'active':'')}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>View products</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview {{($prefix =='/purchases' ? 'menu-open': '')}}">
                    <a href="#" class="nav-link {{($prefix =='/purchases' ? 'active': '')}}">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            Manage purchase
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('purchases.view')}}"
                               class="nav-link {{($route == 'purchases.view'?'active':'')}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>View purchase</p>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('purchases.pending.list')}}"
                               class="nav-link {{($route == 'purchases.pending.list'?'active':'')}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Approval purchase</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview {{($prefix =='/invoice' ? 'menu-open': '')}}">
                    <a href="#" class="nav-link {{($prefix =='/invoice' ? 'active': '')}}">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            Manage invoice
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('invoice.view')}}"
                               class="nav-link {{($route == 'invoice.view'?'active':'')}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>View invoice</p>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('invoice.pending.list')}}"
                               class="nav-link {{($route == 'invoice.pending.list'?'active':'')}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pending invoice</p>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('invoice.print.list')}}"
                               class="nav-link {{($route == 'invoice.print.list'?'active':'')}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pint invoice</p>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('invoice.daily.report')}}"
                               class="nav-link {{($route == 'invoice.daily.report'?'active':'')}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Daily invoice report</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview {{($prefix =='/stock' ? 'menu-open': '')}}">
                    <a href="#" class="nav-link {{($prefix =='/stock' ? 'active': '')}}">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            Manage stock
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('stock.report')}}"
                               class="nav-link {{($route == 'stock.report'?'active':'')}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Stock report</p>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('stock.report.supplierOrProductWise')}}"
                               class="nav-link {{($route == 'stock.report.supplierOrProductWise'?'active':'')}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Supplier/product</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>
