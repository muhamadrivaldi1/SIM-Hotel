<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Owner')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #eef2f7;
            font-family: 'Poppins', sans-serif;
        }
        .navbar {
            background: linear-gradient(90deg, #1e3c72, #2a5298);
        }
        .navbar .navbar-title {
            color: #fff;
            font-weight: 700;
            font-size: 1.25rem;
            letter-spacing: 0.5px;
        }
        .card {
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }
        /* Custom button owner */
        .btn-owner {
            background: linear-gradient(90deg, #1e3c72, #2a5298);
            color: #fff;
            border: none;
            font-weight: 500;
            border-radius: 8px;
            transition: 0.3s;
        }
        .btn-owner:hover {
            background: linear-gradient(90deg, #2a5298, #1e3c72);
            color: #fff;
        }
        .btn-owner:focus,
        .btn-owner:active,
        .btn-owner.show {
            background: linear-gradient(90deg, #1e3c72, #2a5298) !important;
            color: #fff !important;
            box-shadow: none !important;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <span class="navbar-title">Dashboard Owner</span>
            <div class="dropdown ms-auto">
                <button class="btn btn-owner dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="fa fa-user-circle me-2"></i> {{ Auth::user()->name ?? 'Owner' }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                    
                    <!-- Tombol Kembali -->
                   <li>
    <a class="dropdown-item" href="{{ url()->previous() }}">
        <i class="fa fa-arrow-left me-2"></i> Kembali
    </a>
</li>
                    <li><hr class="dropdown-divider"></li>

                    <!-- Kelola Akun -->
                    <li>
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                            <i class="fa fa-cog me-2"></i> Kelola Akun
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>

                    <!-- Logout -->
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="dropdown-item text-danger" type="submit">
                                <i class="fa fa-sign-out-alt me-2"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid py-4">
        @yield('content')
    </div>

    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
