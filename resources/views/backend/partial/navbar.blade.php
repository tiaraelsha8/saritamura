<nav class="main-header navbar navbar-expand navbar-white navbar-light" style="background-color: #0071b4">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <a href="" class="btn btn-outline-light btn-sm mr-2">
            <i class="fas fa-user mr-2"></i> Profile
        </a>
        <form id="auto-logout-form" method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-light btn-sm">
                <i class="fas fa-sign-out-alt mr-2"></i> Logout
            </button>
        </form>
    </ul>
</nav>

