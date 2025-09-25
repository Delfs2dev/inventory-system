<!DOCTYPE html>
<html>
<head>
    <title>Inventory System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 rounded">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/dashboard') }}">Inventory System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <!-- Left side (Menu) -->
                <ul class="navbar-nav me-auto">
    @auth
        @if(Auth::user()->role === 'admin')
            <!-- Admin only menu -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="menuDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Menu
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('categories.index') }}">Categories</a></li>
                    <li><a class="dropdown-item" href="{{ route('products.index') }}">Products</a></li>
                </ul>
            </li>
        @endif
    @endauth
</ul>


                <!-- Right side (Auth Buttons / User Info) -->
                <div class="d-flex align-items-center">
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-success">Sign Up</a>
                    @endguest

                    @auth
                        <span class="me-3 text-white">
    👤 {{ Auth::user()->name }}
    @if(Auth::user()->role === 'admin')
        <span class="badge bg-danger ms-2">Admin</span>
    @elseif(Auth::user()->role === 'staff')
        <span class="badge bg-primary ms-2">Staff</span>
    @endif
</span>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-danger">Logout</button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div>
        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
