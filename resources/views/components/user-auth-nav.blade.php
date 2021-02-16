<div class="top-nav-container">
    <!-- It is quality rather than quantity that matters. - Lucius Annaeus Seneca -->
    <a class="navbar-brand" href="#">Navbar</a>

    <div class="user-initial align-baseline">
        {{ !is_null(\Auth::user()) ? ucfirst(substr(\Auth::user()->full_name, 0, 1)) : '' }}
    </div>

    <nav class="nav flex-column">
            <a class="auth-links {{ Route::is('get-user-dashboard') ? 'active' : '' }}" href="{{ route('get-user-dashboard') }}"> 
                <span class="iconify menu-icon" data-icon="codicon:home" data-inline="false"></span>
                Dashboard
            </a>
            <a class="auth-links {{ Route::is('get-user-profile') || Route::is('get-edit-user-profile') ? 'active' : '' }}" href="{{ route('get-user-profile') }}"> 
                <span class="iconify menu-icon" data-icon="bx:bx-user" data-inline="false"></span>
                Profile 
            </a>
            <a class="auth-links  {{ Route::is('get-user-portfolio') || Route::is('post-user-portfolio') || Route::is('get-user-portfolio-investment') ? 'active' : '' }}" href="{{ route('get-user-portfolio') }}"> 
                <span class="iconify menu-icon" data-icon="la:suitcase" data-inline="false"></span>
                Portfolio
            </a>
            <a class="auth-links {{ Route::is('get-user-transaction') || Route::is('search-user-transaction') ? 'active' : '' }} " href="{{ route('get-user-transaction') }}"> 
                <span class="iconify menu-icon" data-icon="si-glyph:time-reload" data-inline="false"></span>
                Transactions
            </a>
            <a class="auth-links {{ Route::is('get-user-settings') ? 'active' : '' }} " href="{{ route('get-user-settings') }}"> 
                <span class="iconify menu-icon" data-icon="clarity:cog-line" data-inline="false"></span>
                Settings
            </a>
        </nav>
</div>