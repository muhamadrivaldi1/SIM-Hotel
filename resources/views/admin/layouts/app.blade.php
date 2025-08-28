<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
    body {
        background-color: #f4f6f9;
        font-family: 'Poppins', sans-serif;
    }

    /* Sidebar Kiri */
    .sidebar {
        background: linear-gradient(180deg, #1e3c72, #2a5298);
        color: #fff;
        min-height: 100vh;
        width: 240px;
        box-shadow: 2px 0 12px rgba(0, 0, 0, 0.15);
    }
    .sidebar h4 {
        padding: 12px 0;
        border-bottom: 1px solid rgba(255,255,255,0.1);
        font-weight: 600;
        text-align: center;
        font-size: 1.3rem;
    }
    .sidebar .nav-link {
        color: #ecf0f1;
        padding: 10px 14px;
        margin: 6px 8px;
        border-radius: 10px;
        transition: all 0.3s ease;
        font-weight: 500;
    }
    .sidebar .nav-link i { width: 22px; }
    .sidebar .nav-link:hover {
        background: rgba(255,255,255,0.15);
        color: #fff !important;
        transform: translateX(5px);
    }

    /* Sidebar Kanan */
    .sidebar-owner {
        background: #ffffff;
        min-height: 100vh;
        width: 260px;
        box-shadow: -2px 0 12px rgba(0, 0, 0, 0.08);
        padding: 20px;
        border-radius: 0 15px 15px 0;
    }
    .sidebar-owner h4 {
        font-weight: 700;
        color: #1e3c72;
        text-align: center;
        margin-bottom: 20px;
    }
    .sidebar-owner h5 {
        font-size: 1.4rem;
        font-weight: 700;
        color: #2c3e50;
    }
    .sidebar-owner p {
        color: #555;
        font-weight: 500;
    }
    .sidebar-owner button {
        border-radius: 12px;
        font-weight: 600;
        transition: 0.3s ease;
    }
    .sidebar-owner button:hover {
        background: linear-gradient(90deg, #2a5298, #1e3c72);
        color: #fff;
        transform: scale(1.05);
    }

    /* Main Content */
    .flex-grow-1 {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        padding: 25px;
    }
    h3 {
        font-weight: 700;
        color: #1e3c72;
    }
    .breadcrumb-item a {
        color: #2a5298;
        font-weight: 500;
        text-decoration: none;
    }

    /* User dropdown */
    .btn-user {
        border-radius: 12px;
        font-weight: 500;
        background: linear-gradient(90deg, #1e3c72, #2a5298);
        color: #fff;
    }
    .btn-user:hover {
        background: linear-gradient(90deg, #2a5298, #1e3c72);
        color: #fff;
    }

    /* Modal */
    .modal-content {
        border-radius: 16px;
        border: none;
    }
    .modal-header {
        background: linear-gradient(90deg, #1e3c72, #2a5298);
        color: #fff;
    }
    .modal-footer .btn-success {
        background: linear-gradient(90deg, #2a5298, #1e3c72);
        border: none;
        border-radius: 12px;
        padding: 8px 20px;
        font-weight: 600;
    }
    </style>
</head>
<body>
    <div class="d-flex">

        <!-- Sidebar Kiri -->
        <div class="sidebar p-3">
            <h4>Admin</h4>
            <ul class="nav flex-column mt-4">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}">
                        <i class="fa fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li><hr class="bg-light"></li>
                <!-- Back Office -->
                <li class="nav-item">
                    <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#backOfficeMenu">
                        <span><i class="fa fa-briefcase"></i> Back Office</span>
                        <i class="fa fa-chevron-down small"></i>
                    </a>
                    <div class="collapse" id="backOfficeMenu">
                        <ul class="nav flex-column ms-3 mt-2">
                            <li><a class="nav-link" href="{{ route('hrd.index') }}"><i class="fa fa-user-tie"></i> HRD</a></li>
                            <li><a class="nav-link" href="{{ route('finance.index') }}"><i class="fa fa-dollar-sign"></i> Finance</a></li>
                            <li><a class="nav-link" href="{{ route('laundry.index') }}"><i class="fa fa-tshirt"></i> Laundry</a></li>
                            <li><a class="nav-link" href="{{ route('restaurant.index') }}"><i class="fa fa-utensils"></i> Restaurant</a></li>
                            <li><a class="nav-link" href="{{ route('shifts.index') }}"><i class="fa fa-calendar-alt"></i> Shift</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="flex-grow-1">

            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="mb-0">@yield('title')</h3>

                <div class="dropdown">
                    <button class="btn btn-user d-flex align-items-center" type="button" id="userMenu" data-bs-toggle="dropdown">
                        <i class="fa fa-user-circle me-2"></i> {{ Auth::user()->name ?? 'User' }}
                        <i class="fa fa-chevron-down ms-2 small"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userMenu">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="fa fa-cog me-2"></i> Kelola Akun
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fa fa-sign-out-alt me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb">
                    @yield('breadcrumb')
                </ol>
            </nav>

            <hr class="mb-4">

            <!-- Content -->
            <div>
                @yield('content')
            </div>
        </div>

        <!-- Sidebar Kanan -->
        <div class="sidebar-owner">
            <h4>Owner Panel</h4>
            <p class="mb-1"><i class="fa fa-bed text-primary"></i> Kamar Terpakai Hari Ini</p>
            <h5 id="todayUsed">{{ $roomsUsedToday ?? 0 }}</h5>
            <hr>
            <p class="mt-3 mb-1"><i class="fa fa-calendar-check text-success"></i> Kamar Terpakai Bulan Ini</p>
            <h5 id="monthUsed">{{ $roomsUsedMonth ?? 0 }}</h5>
            <div class="mt-4">
                <button class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#modalOmset">
                    <i class="fa fa-money-bill-wave"></i> Lihat Omset
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Login Owner -->
    <div class="modal fade" id="modalOmset" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg">
                <div class="modal-header">
                    <h5 class="modal-title">Login Owner / Manajer</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('owner.login') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Email / Username</label>
                            <input type="text" name="username" class="form-control" required autofocus>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        @if($errors->any())
                            <div class="alert alert-danger">{{ $errors->first() }}</div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $('#modalOmset form').submit(function(e) {
        e.preventDefault();
        let form = $(this);

        $.ajax({
            url: form.attr('action'),
            method: form.attr('method'),
            data: form.serialize(),
            success: function(res) {
                if(res.success) {
                    window.location.href = res.redirect; // redirect ke dashboard owner
                } else {
                    let alertBox = form.find('.alert');
                    if(alertBox.length === 0){
                        form.find('.modal-body').prepend('<div class="alert alert-danger"></div>');
                        alertBox = form.find('.alert');
                    }
                    alertBox.text(res.message);
                }
            },
            error: function() {
                alert('Terjadi kesalahan server!');
            }
        });
    });
    </script>
</body>
</html>
