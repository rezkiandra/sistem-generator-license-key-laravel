<nav class="navbar navbar-expand navbar-light navbar-bg">
  <a class="sidebar-toggle js-sidebar-toggle">
    <i class="hamburger align-self-center"></i>
  </a>

  <div class="navbar-collapse collapse">
    <ul class="navbar-nav navbar-align">
      <li class="nav-item dropdown">

        <a class="nav-link dropdown-toggle d-none d-sm-inline-block text-uppercase" href="javascript:void(0)"
          data-bs-toggle="dropdown">
          <i class="align-middle me-1" data-feather="user"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-end">
          <a class="dropdown-item" href="{{ route('admin.profile') }}">
            <i class="align-middle me-1" data-feather="user"></i>
            Profile
          </a>
          <div class="dropdown-divider"></div>
          <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="dropdown-item">
              <i class="align-middle me-1" data-feather="log-out"></i>
              Logout
            </button>
          </form>
        </div>
      </li>
    </ul>
  </div>
</nav>
