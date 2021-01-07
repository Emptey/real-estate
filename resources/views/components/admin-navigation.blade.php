<div class="navbar-fixed-top">
    <!-- The only way to do great work is to love what you do. - Steve Jobs -->
    <div class="header text-center">
        <header>
            <h1 style="color: #fff">Logo</h1>
        </header>
    </div>

    <div class="x1-5-margin-top menu-container">
        <nav class="nav flex-column">
            <a class="{{ Route::is('get-dashboard') ? 'active animate__animated animate__fadeIn animate__fast' : '#' }}" href="{{ route('get-dashboard') }}"> <i class="fa fa-tachometer"></i> Dashboard </a>
            <a class="{{ Route::is('get-admin-user-mgnt') ? 'active animate__animated animate__fadeIn animate__fast' : '#' }}" href="{{ route('get-admin-user-mgnt') }}"> <i class="fa fa-users"></i> User Management </a>
            <a class="#" href="#"> <i class="fa fa-building-o"></i> Property Listing</a>
            <a class="#" href="#"> <i class="fa fa-chart-pie"></i> Investment Management</a>
            <a class="#" href="#"> <i class="fa fa-coins"></i> Payment</a>
            <a class="#" href="#"> <i class="fa fa-bell"></i> Notification</a>
        </nav>
    </div>

    <div class="bottom-menu fixed-bottom">
        <a href="#" class="bottom-link"> <i class="fa fa-cog"></i> Settings</a>
        <a href="{{ route('admin-logout') }}" class="bottom-link"> <i class="fa fa-sign-out"></i> Logout</a>
    </div>

</div>