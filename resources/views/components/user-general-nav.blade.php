<div>
    <!-- Act only according to that maxim whereby you can, at the same time, will that it should become a universal law. - Immanuel Kant -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <button class="navbar-toggler" style="border:1px solid #fff"  type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon" ></span>
            </button>
            
            <div class="collapse navbar-collapse navbar-right" id="navbarTogglerDemo03">
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item ">
                        <a class="nav-link {{ Route::is('get-user-login') || Route::is('post-user-login') || Route::is('get-user-two-fa') ? 'active' : '' }}" aria-current="page" href="{{ route('get-user-login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('get-user-register') || Route::is('post-user-register') || Route::is('get-user-register-step-two') || Route::is('post-user-register-step-two') || Route::is('get-user-register-three') ? 'active ' : '' }}" href="{{ route('get-user-register') }}">Register</a>
                    </li>
                   
                </ul>
            </div>
            
        </div>
    </nav>
</div>