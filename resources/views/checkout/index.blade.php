@extends('admin.layouts.app')
@section('title', 'Check-Out Kamar')

@section('content')
<div class="container my-5">
    <h2 class="mb-4 text-center">Check-Out Kamar</h2>

    <!-- Notifikasi -->
    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

    <h4 class="mb-4 text-center">Daftar Kamar yang Bisa Check-Out</h4>
    <div class="row justify-content-center">
        @forelse($rooms as $room)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm p-4 text-center mx-auto room-card">
                    <h4 class="fw-bold">Kamar {{ $room->number }}</h4>
                    <p class="text-muted mb-3">Tipe: {{ $room->type }}</p>

                    <!-- Barcode visual -->
                    <div class="mb-3 overflow-auto" style="max-width:100%;">
                        {!! DNS1D::getBarcodeHTML($room->barcode_key, 'C39', 1.8, 60) !!}
                    </div>
                    <p class="small mb-3"><strong>Kode Barcode:</strong> {{ $room->barcode_key }}</p>

                    <!-- Check-Out Button -->
                    <form action="{{ route('checkout', $room->id) }}" method="POST" class="mb-2">
                        @csrf
                        <button type="submit" class="btn btn-danger w-100 btn-lg rounded-pill">
                            <i class="fa fa-sign-out-alt me-1"></i> Check-Out
                        </button>
                    </form>

                    <!-- Detail Kamar -->
                    <a href="{{ route('rooms.show', $room->id) }}" class="btn btn-outline-primary w-100 btn-lg rounded-pill">
                        <i class="fa fa-eye me-1"></i> Detail Kamar
                    </a>
                </div>
            </div>
        @empty
            <p class="text-center">Tidak ada kamar untuk check-out.</p>
        @endforelse
    </div>
</div>

<style>
.room-card {
    border-radius: 1.5rem;
    transition: transform 0.3s, box-shadow 0.3s;
    background: #ffffff;
    padding: 2rem 1.5rem;
}

.room-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 16px 40px rgba(0,0,0,0.18);
}

/* Media Query untuk Desktop */
@media (min-width: 992px) {
    .room-card {
        max-width: 360px;
        padding: 3rem 2rem;
    }
}
</style>
@endsection
