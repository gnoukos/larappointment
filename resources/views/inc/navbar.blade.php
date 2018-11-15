<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand ml-md-5" href="/">LarAppointment</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto mr-md-5">
            <li class="nav-item">
                <a class="nav-link text-dark mr-md-1" href="/">Home</a>
            </li>
            @auth
                @if(auth()->user()->role=='admin')
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="about.html">Admin</a>
                    </li>
                @endif
            @endauth
            @auth

                @if(auth()->user()->role=='user')
                    <li class="nav-item">
                        <a class="nav-link text-dark mr-md-1" href="/dashboard">{{auth()->user()->name}}</a>
                    </li>
                @endif

            @endauth
            @guest
            <li class="nav-item">
                <a class="btn btn-outline-primary mr-md-1 d-none d-lg-block" href="#" data-toggle="modal" data-target="#loginModal">Login <i class="fas fa-sign-in-alt"></i></a>
            </li>

            <li class="nav-item">
                <a class="nav-link mr-md-1 d-lg-none text-primary" href="#" data-toggle="modal" data-target="#loginModal">Login <i class="fas fa-sign-in-alt"></i></a>
            </li>
            <li class="nav-item">
                <a class="btn btn-light mr-md-1 d-none d-lg-block" href="#" data-toggle="modal" data-target="#signupModal">Sign Up</a>
            </li>
            <li class="nav-item">
                <a class="nav-link mr-md-1 d-lg-none text-primary" href="#" data-toggle="modal" data-target="#signupModal">Sign Up</a>
            </li>
            @endguest
            @auth
            <li class="nav-item">
                <a class="btn btn-outline-primary mr-md-1 d-none d-lg-block" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout <i class="fas fa-sign-out-alt"></i></a>
            </li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            <li class="nav-item">
                <a class="nav-link mr-md-1 d-lg-none text-primary" href="#">Logout <i class="fas fa-sign-out-alt"></i></a>
            </li>
            @endauth
        </ul>
    </div>
</nav>