<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>{{ $title ?? 'default title' }} - {{ env('APP_NAME') }}</title>
    <!-- CSS files -->
    <link href="{{ asset('assets/vendor/tabler/css/tabler.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendor/tabler/css/tabler-vendors.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendor/tabler-icon/tabler-icons.min.css') }}" rel="stylesheet" />
    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }

        .navbar-brand-image {
            height: 3rem;
            width: auto;
        }

        .nav-link {
            font-size: 1rem;
        }
        section.hero {
            padding: 125px 0;
        }

        .text-label,
        .text-hero-bold,
        .text-hero-regular {
            margin: 24px 0;
        }

        .text-label {
            font-size: 16px;
            font-weight: var(--font-weight-regular);
            line-height: 28px;
        }

        .text-hero-bold {
            font-size: 45px;
            font-weight: var(--font-weight-bold);
            line-height: 74px;
        }

        .text-hero-regular {
            font-size: 16px;
            font-weight: var(--font-weight-regular);
            line-height: 31px;
        }

        .cta .btn {
            font-size: 16px;
            font-weight: var(--font-weight-bold);
            line-height: 25px;
            border-radius: 7px;
        }

        .triage-body {
            padding: 65px 0;
        }
    </style>
    @stack('styles')
</head>

<body>
    <div class="page">
        <nav class="navbar navbar-expand-lg fixed-top bg-white shadow">
            <div class="container-xl">
                <div class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
                    <a href="{{ route('home') }}" class="h1 m-0">
                        <img src="{{ asset('assets/images/logo_upi.png') }}" width="165" height="48"
                            alt="Tabler" class="navbar-brand-image">
                        <img src="{{ asset('assets/images/logo_tekkom.png') }}" width="165" height="48"
                            alt="Tabler" class="navbar-brand-image">
                    </a>
                    {{-- <h1 class="d-flex m-0 text-primary">E-Triase</h1> --}}
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item {{ request()->route()->named('home') ? 'active' : '' }}">
                            <a class="nav-link {{ request()->route()->named('home') ? 'active' : '' }}" aria-current="page"
                                href="/">Beranda</a>
                        </li>
                        <li class="nav-item {{ request()->route()->named('triage.*') ? 'active' : '' }}">
                            <a class="nav-link {{ request()->route()->named('triage.*') ? 'active' : '' }}"
                                href="{{ route('triage.step.one') }}">Demo Artificial Triase</a>
                        </li>
                    </ul>
                    <div class="d-flex">
                        @if (!Auth::guest())
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary" type="submit">Dashboard</a>
                        @else
                        <a href="{{ route('login') }}" class="btn btn-outline-primary" type="submit">Login</a>
                        @endif
                    </div>
                </div>
            </div>
        </nav>
        <div class="page-wrapper">
            {{ $slot }}
        </div>
    </div>
    <!-- Libs JS -->
    @stack('script')
    <!-- Tabler Core -->
    <script src="{{ asset('assets/vendor/tabler/js/tabler.min.js') }}" defer></script>

</body>

</html>
