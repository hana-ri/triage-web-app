<header class="navbar navbar-expand-md d-none d-lg-flex d-print-none">
    <div class="container-xl">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu"
            aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-nav flex-row order-md-last">
            <div class="d-none d-md-flex">
                <a class="btn nav-link px-0 hide-theme-dark toggleTheme me-3" title="Enable dark mode" data-bs-toggle="tooltip"
                    data-bs-placement="bottom">
                    <i class="ti ti-moon fs-2"></i>
                </a>
                <a class="btn nav-link px-0 hide-theme-light toggleTheme me-3" title="Enable light mode" data-bs-toggle="tooltip"
                    data-bs-placement="bottom">
                    <i class="ti ti-sun fs-2"></i>
                </a>
            </div>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                    aria-label="Open user menu">
                    <span class="avatar avatar-sm"
                        style="background-image: url({{ asset('assets/images/002m.jpg') }})"></span>
                    <div class="d-none d-xl-block ps-2">
                        <div>{{ auth()->user()->getShortenedNameAttribute() }}</div>
                        <div class="mt-1 small text-secondary">{{ auth()->user()->roles()->first()->name }}</div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <a href="{{ route('admin.users.profile.edit') }}" class="dropdown-item">My
                        profile</a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item">Logout</a>
                </div>
            </div>
        </div>
        <div class="collapse navbar-collapse" id="navbar-menu">
            <div>
                {{-- TBA --}}
            </div>
        </div>
    </div>
</header>
