<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{$title}}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="https://cdn-icons-png.flaticon.com/512/149/149071.png">
    @stack('style')
    <style>
        body.dark-mode {
            background-color: #121212;
            color: #ffffff;
        }
        .navbar.bg-body-tertiary {
            background-color: #1e1e1e !important;
        }
        .navbar .nav-link {
            color: #ffffff !important;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Bengkel</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        @if (Auth::check())
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('welcome') ? 'active' : '' }}" aria-current="page" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('landing-page') ? 'active' : '' }}" aria-current="page" href="{{ route('landing-page') }}">Landing</a>
                </li>
                @if (Auth:: user()->role == 'admin')
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('bengkels') ? 'active' : '' }}" aria-current="page" href="{{ route('bengkels') }}">Data Item</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('user') ? 'active' : '' }}" aria-current="page" href="{{ route('user') }}">Kelola Akun</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('orders.admin') }}" class="nav-link">Data Pembelian</a>
                </li>
                @endif
                @if (Auth::user()->role == 'kasir')
                <li class="nav-item">
                    <a href="{{ route('orders') }}" class="nav-link">Pembelian</a>
                </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}">Logout</a>
                </li>
                <li class="nav-item">
                    <button id="dark-mode-toggle" class="btn btn-outline-secondary">Dark Mode</button>
                </li>
            </ul>
            <form class="d-flex" role="search" action="{{ route('bengkels') }}" method="GET">
                <input class="form-control me-2" type="text" placeholder="Search-Item" aria-label="Search" name="search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
            <form class="d-flex" role="search" action="{{ route('user') }}" method="GET">
                <input class="form-control me-2" type="text" placeholder="Search-User " aria-label="Search" name="search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
        @endif
    </div>
</nav>
@yield('content-dinamis')

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('dark-mode-toggle').addEventListener('click', function() {
        document.body.classList.toggle('dark-mode');

        if (document.body.classList.contains('dark-mode')) {
            localStorage.setItem('theme', 'dark');
        } else {
            localStorage.setItem('theme', 'light');
        }
    });

    window.onload = function() {
        const theme = localStorage.getItem('theme');
        if (theme === 'dark') {
            document.body.classList.add('dark-mode');
        }
    };
</script>
@stack('script')
</body>
</html>