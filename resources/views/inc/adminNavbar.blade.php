<nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <a class="navbar-brand mr-1" href="/admin">LarAppointment</a>

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Navbar -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown no-arrow">
            <li class="nav-item">
                <a class="btn btn-outline-primary mr-md-1 d-none d-lg-block" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout <i class="fas fa-sign-out-alt"></i></a>
            </li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <li class="nav-item">
                <a class="nav-link mr-md-1 d-lg-none text-primary" href="#">Logout <i class="fas fa-sign-out-alt"></i></a>
            </li>
        </li>
    </ul>

</nav>
<div id="wrapper">
    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="/admin">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/hierarchy">
                <i class="fas fa-fw fa-table"></i>
                <span>Hierarchy</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/levels">
                <i class="fas fa-level-down-alt"></i>
                <span>Levels</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/createAppointment">
                <i class="fas fa-plus"></i>
                <span>New Category</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/manageAppointments">
                <i class="fas fa-list"></i>
                <span>Categories</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/" target="_blank">
                <i class="fas fa-fw fa-home"></i>
                <span>Home</span>
            </a>
        </li>
    </ul>