<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f5f7fa;
        }
        .sidebar {
            background: linear-gradient(to bottom, #2c3e50, #34495e);
            color: #fff;
            min-height: 100vh;
            width: 240px;
            transition: width 0.3s;
        }
        .sidebar .nav-link {
            color: #ecf0f1;
            margin-bottom: 5px;
            border-radius: 5px;
        }
        .sidebar .nav-link:hover {
            background-color: #1abc9c;
            color: #fff;
        }
        .sidebar .nav-link i {
            width: 20px;
        }
        .sidebar h4 {
            padding: 10px 0;
            border-bottom: 1px solid rgba(255,255,255,0.2);
        }
        .sidebar .collapse-inner .nav-link:hover {
            background-color: #16a085;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar p-3">
            <h4 class="text-center">Hotel Admin</h4>

            <!-- Menu Utama -->
            <ul class="nav flex-column mt-4">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}">
                        <i class="fa fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>

                {{-- <!-- Front Office -->
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#frontOfficeMenu" role="button" aria-expanded="false" aria-controls="frontOfficeMenu">
                        <i class="fa fa-concierge-bell"></i> Front Office
                        <i class="fa fa-chevron-down float-end"></i>
                    </a>
                    <div class="collapse" id="frontOfficeMenu">
                        <ul class="nav flex-column ms-3 collapse-inner">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('rooms.index') }}">
                                    <i class="fa fa-bed"></i> Rooms
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('guests.index') }}">
                                    <i class="fa fa-users"></i> Guests
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('checkins.index') }}">
                                    <i class="fa fa-sign-in-alt"></i> Check In
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('checkout.index') }}">
                                    <i class="fa fa-sign-out-alt"></i> Check Out
                                </a>
                            </li>
                        </ul>
                    </div>
                </li> --}}

                <!-- Back Office -->
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#backOfficeMenu" role="button" aria-expanded="false" aria-controls="backOfficeMenu">
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

        <!-- Main content -->
        <div class="flex-grow-1 p-4">
            <h3>@yield('title')</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    @yield('breadcrumb')
                </ol>
            </nav>

            @yield('content')
        </div>
    </div>

    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


