@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<h3>Selamat datang, Owner!</h3>
<p>Ini adalah dashboard khusus owner.</p>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-center bg-primary text-white">
            <div class="card-body">
                <h5>Kamar Terpakai Hari Ini</h5>
                <h3>{{ $roomsUsedToday ?? 0 }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center bg-success text-white">
            <div class="card-body">
                <h5>Kamar Terpakai Bulan Ini</h5>
                <h3>{{ $roomsUsedMonth ?? 0 }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card p-3">
            <h5>Pengunjung Bulanan</h5>
            <canvas id="visitorChart" height="150"></canvas>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card p-3">
            <h5>Pendapatan Bulanan</h5>
            <canvas id="revenueChart" height="150"></canvas>
        </div>
    </div>
</div>

<form action="{{ route('owner.logout') }}" method="POST" class="mt-3">
    @csrf
    <button class="btn btn-danger">Logout</button>
</form>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Grafik Pengunjung
    new Chart(document.getElementById('visitorChart'), {
        type: 'line',
        data: {
            labels: @json($labels),
            datasets: [{
                label: 'Jumlah Pengunjung',
                data: @json($visitorData),
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: true } },
            scales: { y: { beginAtZero: true } }
        }
    });

    // Grafik Pendapatan
    new Chart(document.getElementById('revenueChart'), {
        type: 'bar',
        data: {
            labels: @json($labels),
            datasets: [{
                label: 'Pendapatan',
                data: @json($revenueData),
                backgroundColor: 'rgba(75, 192, 192, 0.7)'
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: true } },
            scales: { y: { beginAtZero: true } }
        }
    });
});
</script>
@endsection
