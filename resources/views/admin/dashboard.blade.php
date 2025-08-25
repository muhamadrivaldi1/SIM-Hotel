@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('breadcrumb')
@endsection

@section('content')

<!-- User Dropdown di kanan atas -->
<div class="d-flex justify-content-end mb-4">
    <div class="dropdown">
        <button class="btn btn-outline-primary dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa fa-user"></i> {{ Auth::user()->name }}
        </button>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
            <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fa fa-cog me-2"></i> Kelola Akun</a></li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li>
                <form id="logoutForm" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="button" class="dropdown-item text-danger" id="logoutBtn"><i class="fa fa-sign-out-alt me-2"></i> Logout</button>
                </form>
            </li>
        </ul>
    </div>
</div>

<div class="row g-3">
    <!-- Total Rooms -->
    <div class="col-md-3">
        <div class="card shadow-sm border-0 text-white" style="background: #3498db;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6>Total Rooms</h6>
                        <h3>{{ $rooms->count() }}</h3>
                    </div>
                    <i class="fa fa-bed fa-2x"></i>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0">
                <a href="{{ route('rooms.index') }}" class="text-white small">Lihat detail <i class="fa fa-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <!-- Occupied Rooms -->
    <div class="col-md-3">
        <div class="card shadow-sm border-0 text-white" style="background: #2ecc71;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6>Occupied Rooms</h6>
                        <h3>{{ $rooms->where('status','Occupied')->count() }}</h3>
                    </div>
                    <i class="fa fa-door-closed fa-2x"></i>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0">
                <a href="#" class="text-white small">Lihat detail <i class="fa fa-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <!-- Available Rooms -->
    <div class="col-md-3">
        <div class="card shadow-sm border-0 text-white" style="background: #f1c40f;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6>Available Rooms</h6>
                        <h3>{{ $rooms->where('status','Available')->count() }}</h3>
                    </div>
                    <i class="fa fa-door-open fa-2x"></i>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0">
                <a href="#" class="text-white small">Lihat detail <i class="fa fa-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <!-- Total Guests -->
    @if(isset($guests))
    <div class="col-md-3">
        <div class="card shadow-sm border-0 text-white" style="background: #e74c3c;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6>Total Guests</h6>
                        <h3>{{ $guests->count() }}</h3>
                    </div>
                    <i class="fa fa-users fa-2x"></i>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0">
                <a href="{{ route('guests.index') }}" class="text-white small">Lihat detail <i class="fa fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
    @endif

</div>

<!-- Pendapatan Chart -->
<div class="card mt-4 shadow-sm">
    <div class="card-header bg-white">
        <strong>Grafik Pendapatan</strong>
    </div>
    <div class="card-body">
        <canvas id="incomeChart" height="100"></canvas>
    </div>
</div>

<!-- Recent Check-ins -->
<div class="card mt-4 shadow-sm">
    <div class="card-header bg-white">
        <strong>Check-in Terbaru</strong>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Tamu</th>
                    <th>Kamar</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentCheckins as $checkin)
                <tr>
                    <td>{{ $checkin->guest->name }}</td>
                    <td>{{ $checkin->room->name }}</td>
                    <td>{{ $checkin->checkin_date->format('d M Y') }}</td>
                    <td>{{ $checkin->checkout_date ? $checkin->checkout_date->format('d M Y') : '-' }}</td>
                    <td>
                        @if($checkin->status == 'Checked In')
                        <span class="badge bg-success">Checked In</span>
                        @else
                        <span class="badge bg-secondary">{{ $checkin->status }}</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Chart
    const ctx = document.getElementById('incomeChart').getContext('2d');
    const incomeChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: 'Pendapatan',
                data: @json($chartData),
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Logout konfirmasi
    document.getElementById('logoutBtn').addEventListener('click', function(){
        if(confirm("Apakah Anda yakin ingin logout?")) {
            document.getElementById('logoutForm').submit();
        }
    });
</script>
@endpush
