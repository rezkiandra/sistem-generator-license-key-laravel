<nav id="sidebar" class="sidebar js-sidebar">
  <div class="sidebar-content js-simplebar">
    <a class="sidebar-brand" href="index.html">
      <span class="align-middle">{{ 'Post Scheduler' }}</span>
    </a>

    <ul class="sidebar-nav">
      <li class="sidebar-header">
        Pages
      </li>

      <li class="sidebar-item {{ request()->routeIs('admin.licenses', 'license.*') ? 'active' : '' }}">
        <a class="sidebar-link" href="{{ route('admin.licenses') }}">
          <i class="align-middle" data-feather="key"></i> <span class="align-middle">{{ 'License Keys' }}</span>
        </a>
      </li>

      <li class="sidebar-item {{ request()->routeIs('admin.api-consume') ? 'active' : '' }}">
        <a class="sidebar-link" href="{{ route('admin.api-consume') }}">
          <i class="align-middle" data-feather="git-branch"></i> <span class="align-middle">{{ 'APIs Consume' }}</span>
        </a>
      </li>
    </ul>
  </div>
</nav>
