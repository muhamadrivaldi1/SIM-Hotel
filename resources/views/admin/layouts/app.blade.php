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
        background-color: #eef2f7;
        font-family: 'Poppins', sans-serif;
    }

    /* Sidebar kiri & kanan */
    .sidebar, .sidebar-owner {
        background: linear-gradient(180deg, #1e3c72, #2a5298);
        color: #fff;
        min-height: 100vh;
        width: 240px;
        box-shadow: 3px 0 10px rgba(0, 0, 0, 0.15);
    }
    .sidebar h4, .sidebar-owner h4 {
        padding: 10px 0;
        border-bottom: 1px solid rgba(255,255,255,0.1);
        font-weight: 600;
        color: #fafafa;
        letter-spacing: 1px;
        text-align: center;
    }
    .sidebar .nav-link {
        color: #ecf0f1;
        margin: 6px 0;
        padding: 10px 12px;
        border-radius: 8px;
        transition: all 0.3s ease;
        font-weight: 500;
    }
    .sidebar .nav-link i {
        width: 22px;
    }
    .sidebar .nav-link:hover {
        background: rgba(255,255,255,0.1);
        color: #fff !important;
        transform: translateX(5px);
    }
    .sidebar .collapse-inner .nav-link {
        padding-left: 25px;
    }
    .sidebar .collapse-inner .nav-link:hover {
        background-color: rgba(255,255,255,0.15);
    }

    /* Sidebar kanan */
    .sidebar-owner {
        width: 260px;
        box-shadow: -3px 0 10px rgba(0, 0, 0, 0.15);
    }
    .sidebar-owner h5 {
        font-size: 1.3rem;
        font-weight: 600;
    }
    .sidebar-owner p {
        font-size: 0.9rem;
        margin-bottom: 2px;
    }
    .sidebar-owner button {
        border-radius: 25px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .sidebar-owner button:hover {
        background: #3ab6ab;
        color: #2c3e50;
        transform: scale(1.05);
    }

    /* Konten utama */
    .flex-grow-1 {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }
    h3 {
        font-weight: 700;
        color: #2c3e50;
    }
    .breadcrumb {
        background: transparent;
        padding-left: 0;
    }
    .breadcrumb-item a {
        color: #2a5298;
        font-weight: 500;
    }

    /* Modal Login Owner */
    .modal-content {
        border: none;
        border-radius: 16px;
        overflow: hidden;
        font-family: 'Poppins', sans-serif;
    }
    .modal-header {
        background: linear-gradient(90deg, #1e3c72, #2a5298);
        color: #fff;
    }
    .modal-footer .btn-success {
        background: linear-gradient(90deg, #2a5298, #1e3c72);
        border: none;
        font-weight: 600;
        border-radius: 25px;
        padding: 8px 20px;
    }
    .modal-footer .btn-success:hover {
        background: linear-gradient(90deg, #1e3c72, #16365f);
        transform: scale(1.03);
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
                    <hr>
                </li>
                <!-- Back Office -->
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#backOfficeMenu">
                        <i class="fa fa-briefcase"></i> Back Office
                        <i class="fa fa-chevron-down float-end"></i>
                    </a>
                    <div class="collapse" id="backOfficeMenu">
                        <ul class="nav flex-column ms-3 collapse-inner">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('hrd.index') }}">
                                    <i class="fa fa-user-tie"></i> HRD
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('finance.index') }}">
                                    <i class="fa fa-dollar-sign"></i> Finance
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('laundry.index') }}">
                                    <i class="fa fa-tshirt"></i> Laundry
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('restaurant.index') }}">
                                    <i class="fa fa-utensils"></i> Restaurant
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('shifts.index') }}">
                                    <i class="fa fa-calendar-alt"></i> Shift
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="flex-grow-1 p-4">
            <h3>@yield('title')</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    @yield('breadcrumb')
                </ol>
            </nav>
            <div class="w-100">
                <hr style="margin-top: 10px; margin-bottom: 20px; border-top: 2px solid #2a5298;">
            </div>

            @yield('content')
        </div>

        <!-- Sidebar Kanan -->
        <div class="sidebar-owner p-3">
            <h4>Owner</h4>
            <div class="mt-4">
            <p class="mb-1"><i class="fa fa-bed text-light"></i> Kamar Terpakai Hari Ini:</p>
            <h5 id="todayUsed" class="fw-bold text-light">{{ $roomsUsedToday ?? 0 }}</h5>
            <hr>
            <p class="mt-3 mb-1"><i class="fa fa-calendar-check text-light"></i> Kamar Terpakai Bulan Ini:</p>
            <h5 id="monthUsed" class="fw-bold text-light">{{ $roomsUsedMonth ?? 0 }}</h5>

            <div class="mt-4">
                <button class="btn btn-light w-100" data-bs-toggle="modal" data-bs-target="#modalOmset">
                <i class="fa fa-money-bill-wave text-success"></i> Lihat Omset
                </button>
            </div>
            </div>
        </div>
    </div>

    <!-- Modal Login Owner -->
    <div class="modal fade" id="modalOmset" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 shadow">
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
                            <div class="alert alert-danger">
                                {{ $errors->first() }}
                            </div>
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
                // Tampilkan pesan error di modal
                let alertBox = form.find('.alert');
                if(alertBox.length === 0){
                    form.find('.modal-body').prepend('<div class="alert alert-danger"></div>');
                    alertBox = form.find('.alert');
                }
                alertBox.text(res.message);
            }
        },
        error: function(xhr) {
            alert('Terjadi kesalahan server!');
        }
    });
});
</script>
</body>
</html>
