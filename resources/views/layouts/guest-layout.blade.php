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
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }
    </style>
</head>

<body>
    <div class="page">
        <nav class="navbar navbar-expand-lg bg-white shadow">
            <div class="container-xl">
                <div class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
                    <a href="." class="h1 m-0">
                        <img src="{{ asset('assets/images/logo_upi.png') }}" width="165" height="48" alt="Tabler"
                            class="navbar-brand-image">
                        <img src="{{ asset('assets/images/logo_tekkom.png') }}" width="165" height="48" alt="Tabler"
                            class="navbar-brand-image">
                    </a>
                    <h1 class="d-flex m-0 text-primary">E-Triage</h1>
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Triage</a>
                        </li>
                    </ul>
                    <div class="d-flex">
                        <button class="btn btn-outline-primary" type="submit">Login</button>
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
