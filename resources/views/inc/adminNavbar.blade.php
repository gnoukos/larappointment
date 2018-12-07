<nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <a class="navbar-brand mr-1" href="/admin">LarAppointment</a>

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Navbar -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-user-circle fa-fw"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">Settings</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
            </div>
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
            <a class="nav-link" href="/createAppointment">
                <i class="fas fa-plus"></i>
                <span>New Appointment</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/manageAppointments">
                <i class="fas fa-list"></i>
                <span>Appointment Types</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/" target="_blank">
                <i class="fas fa-fw fa-home"></i>
                <span>Home</span>
            </a>
        </li>
    </ul>