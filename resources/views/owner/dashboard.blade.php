@extends('owner.layouts.app')

@section('title', 'Dashboard Owner')

@section('content')
<div class="container-fluid">
    <!-- Judul -->
    <div class="mb-4 text-center">
        <h2 class="fw-bold text-primary">Selamat Datang, Owner!</h2>
        <p class="text-muted">Berikut adalah ringkasan aktivitas dan performa hotel Anda.</p>
    </div>

    <!-- Statistik Kamar -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card bg-gradient-primary text-white shadow h-100">
                <div class="card-body text-center">
                    <i class="fa fa-bed fa-2x mb-2"></i>
                    <h6 class="fw-semibold">Kamar Terpakai Hari Ini</h6>
                    <h2 class="fw-bold">{{ $roomsUsedToday ?? 0 }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-gradient-success text-white shadow h-100">
                <div class="card-body text-center">
                    <i class="fa fa-calendar-check fa-2x mb-2"></i>
                    <h6 class="fw-semibold">Kamar Terpakai Bulan Ini</h6>
                    <h2 class="fw-bold">{{ $roomsUsedMonth ?? 0 }}</h2>
                </div>
            </div>
        </div>
        <!-- Tambahan info (opsional, biar simetris) -->
        <div class="col-md-3">
            <div class="card bg-gradient-warning text-white shadow h-100">
                <div class="card-body text-center">
                    <i class="fa fa-users fa-2x mb-2"></i>
                    <h6 class="fw-semibold">Total Pengunjung</h6>
                    <h2 class="fw-bold">{{ $totalVisitors ?? 0 }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-gradient-info text-white shadow h-100">
                <div class="card-body text-center">
                    <i class="fa fa-wallet fa-2x mb-2"></i>
                    <h6 class="fw-semibold">Total Pendapatan</h6>
                    <h2 class="fw-bold">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik -->
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card shadow h-100">
                <div class="card-header bg-primary text-white fw-semibold">
                    <i class="fa fa-chart-line me-2"></i> Pengunjung Bulanan
                </div>
                <div class="card-body">
                    <canvas id="visitorChart" height="150"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow h-100">
                <div class="card-header bg-success text-white fw-semibold">
                    <i class="fa fa-chart-bar me-2"></i> Pendapatan Bulanan
                </div>
                <div class="card-body">
                    <canvas id="revenueChart" height="150"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Chart pengunjung
    new Chart(document.getElementById('visitorChart'), {
        type: 'line',
        data: {
            labels: @json($labels),
            datasets: [{
                label: 'Jumlah Pengunjung',
                data: @json($visitorData),
                borderColor: '#1e3c72',
                backgroundColor: 'rgba(30, 60, 114, 0.2)',
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#1e3c72',
                pointRadius: 5
            }]
        },
        options: {
            plugins: {
                legend: { display: true, labels: { color: '#1e3c72' } }
            }
        }
    });

    // Chart pendapatan
    new Chart(document.getElementById('revenueChart'), {
        type: 'bar',
        data: {
            labels: @json($labels),
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: @json($revenueData),
                backgroundColor: '#2a5298'
            }]
        },
        options: {
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { ticks: { color: '#2a5298' } },
                x: { ticks: { color: '#2a5298' } }
            }
        }
    });
});
</script>
@endsection

<style>
    /* Gradient card tambahan */
    .bg-gradient-primary {
        background: linear-gradient(90deg, #1e3c72, #2a5298);
    }
    .bg-gradient-success {
        background: linear-gradient(90deg, #28a745, #218838);
    }
    .bg-gradient-warning {
        background: linear-gradient(90deg, #ffc107, #e0a800);
    }
    .bg-gradient-info {
        background: linear-gradient(90deg, #17a2b8, #117a8b);
    }
</style>
