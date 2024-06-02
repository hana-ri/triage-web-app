<aside class="navbar navbar-vertical navbar-expand-lg" data-bs-theme="dark">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu"
            aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand navbar-brand-autodark">
            <a href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('assets/images/logo_upi.png') }}" width="165" height="48" alt="Tabler"
                    class="navbar-brand-image">
                <img src="{{ asset('assets/images/logo_tekkom_2.png') }}" width="165" height="48" alt="Tabler"
                    class="navbar-brand-image">
            </a>
        </h1>
        <div class="navbar-nav flex-row d-lg-none">
            <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                    aria-label="Open user menu">
                    <span class="avatar avatar-sm"
                        style="background-image: url({{ asset('assets/images/002m.jpg') }})"></span>
                    <div class="d-none d-xl-block ps-2">
                        <div>{{ auth()->user()->name }}</div>
                        <div class="mt-1 small text-secondary">{{ auth()->user()->roles()->first()->name }}</div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <a href="{{ route('admin.users.profile.edit') }}" class="dropdown-item">Profile</a>
                    <div class="dropdown-divider"></div>
                    <div class="d-md-flex d-lg-none">
                        <a href="#" class="dropdown-item hide-theme-dark toggleTheme" title="Enable dark mode"
                            data-bs-toggle="tooltip" data-bs-placement="bottom">
                            <span class="me-1">Dark Mode</span> <i class="ti ti-moon fs-5"></i>
                        </a>
                        <a href="#" class="dropdown-item hide-theme-light toggleTheme" title="Enable light mode"
                            data-bs-toggle="tooltip" data-bs-placement="bottom">
                            <span class="me-1">Light Mode</span> <i class="ti ti-sun fs-5"></i>
                        </a>
                    </div>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item">Logout</a>
                </div>
            </div>
        </div>
        <div class="collapse navbar-collapse" id="sidebar-menu">
            <ul class="navbar-nav pt-lg-3">
                <li class="nav-item {{ request()->route()->named('admin.dashboard') ? 'active' : '' }}">
                    <a class="nav-link {{ request()->route()->named('admin.dashboard') ? 'active' : '' }}"
                        href="{{ route('admin.dashboard') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="ti ti-emergency-bed fs-2"></i>
                        </span>
                        <span class="nav-link-title"> Triage</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->route()->named('admin.users.index') ? 'active' : '' }}">
                    <a class="nav-link {{ request()->route()->named('admin.users.index') ? 'active' : '' }}"
                        href="{{ route('admin.users.index') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="ti ti-user fs-2"></i>
                        </span>
                        <span class="nav-link-title"> User</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->route()->named('admin.roles.index') ? 'active' : '' }}">
                    <a class="nav-link {{ request()->route()->named('admin.roles.index') ? 'active' : '' }}"
                        href="{{ route('admin.roles.index') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="ti ti-shield-code fs-2"></i>
                        </span>
                        <span class="nav-link-title"> Roles & permissions</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->route()->named('admin.settings.index') ? 'active' : '' }}">
                    <a class="nav-link {{ request()->route()->named('admin.settings.index') ? 'active' : '' }}"
                        href="{{ route('admin.settings.index') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="ti ti-settings fs-2"></i>
                        </span>
                        <span class="nav-link-title"> Setting</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</aside>
