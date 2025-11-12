<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset('assets/img/user-profile.png') }} " class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ \Auth::user()->name  }}</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form (Optional) -->
        <!-- <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
            </div>
        </form> -->
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
            <li><a href="{{ route('admin.user') }}"><i class="fa fa-user-secret"></i> <span>System Users</span></a></li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-cubes"></i> <span>ViTrox Products</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.vitrox.vitDashboard') }}"><i class="fa fa-circle-o"></i> Dashboard</a></li>
                    <li><a href="{{ route('admin.vitrox.machines') }}"><i class="fa fa-circle-o"></i> SMT Machines</a></li>
                    <li><a href="{{ route('admin.vitrox.aoi') }}"><i class="fa fa-circle-o"></i> AOI Parts</a></li>
                    <li><a href="{{ route('admin.vitrox.spi') }}"><i class="fa fa-circle-o"></i> SPI Parts</a></li>
                    <li><a href="{{ route('admin.vitrox.axi') }}"><i class="fa fa-circle-o"></i> AXI Parts</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-cubes"></i> <span>ICT Products</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o"></i> Dashboard</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> ICT Parts</a></li>
                    <!-- <li><a href="#"><i class="fa fa-circle-o"></i> Genrad</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Agilent</a></li> -->
                </ul>
            </li>


        </ul>
    </section>
</aside>