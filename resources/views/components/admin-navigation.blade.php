<div class="navbar-fixed-top">
    <!-- The only way to do great work is to love what you do. - Steve Jobs -->
    <div class="header text-center">
        <header>
            <h1 style="color: #fff">Logo</h1>
        </header>
    </div>

    <div class="x1-5-margin-top menu-container">
        <nav class="nav flex-column">
            <a class="{{ Route::is('get-dashboard') ? 'active animate__animated animate__fadeIn animate__delay-1s' : '#' }}" 
                href="{{ route('get-dashboard') }}"> <i class="fa fa-tachometer"></i> Dashboard </a>
            <a class="{{ Route::is('get-admin-user-mgnt') || Route::is('search-user') || Route::is('add-user') 
                || Route::is('view-user') ? '
                active animate__animated animate__fadeIn animate__delay-1s' : '#' }}" 
                href="{{ route('get-admin-user-mgnt') }}"> <i class="fa fa-users"></i> User Manager </a>
            <a class="{{ Route::is('get-property-listing') || Route::is('search-property') || Route::is('get-add-property') || 
                Route::is('post-add-property-first') || Route::is('get-step-two-property') || Route::is('post-add-property-second') 
                || Route::is('get-step-three-property') || Route::is('post-add-property-third') || Route::is('view-property') 
                || Route::is('get-update-property-setp-one') || Route::is('post-update-property-step-one') || Route::is('get-update-property-step-two')
                || Route::is('post-update-property-step-two') || Route::is('get-update-property-step-three') ?  'active animate__animated animate__fadeIn animate__delay-1s' : '' }}" 
                href="{{ route('get-property-listing') }}"> <i class="fa fa-building-o"></i> Property Listing</a>
            <a class="{{ Route::is('get-admin-investment') || Route::is('search-investment') ? 'active animate__animated animate__fadeIn animate__delay-1s' : '' }}" href="{{ route('get-admin-investment') }}"> <i class="fa fa-chart-pie"></i> Investment Manager</a>
            <a class="#" href="#"> <i class="fa fa-coins"></i> Payment</a>
            <a class="#" href="#"> <i class="fa fa-bell"></i> Notification</a>
        </nav>
    </div>

    <div class="bottom-menu fixed-bottom">
        <a href="#" class="bottom-link"> <i class="fa fa-cog"></i> Settings</a>
        <a href="{{ route('admin-logout') }}" class="bottom-link"> <i class="fa fa-sign-out"></i> Logout</a>
    </div>

</div>