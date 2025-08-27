@extends('admin.layouts.app')
@section('title', 'Dashboard')

@section('content')

<div class="row row-cols-1 row-cols-md-4 g-4">
    @foreach($rooms as $room)
    <div class="col">
        <div class="card shadow h-100 border-0 rounded-4 overflow-hidden room-card">
            <div class="card-body text-center d-flex flex-column">

                <!-- Nomor & Tipe Kamar -->
                <div class="mb-3">
                    <h5 class="text-dark mb-1">Kamar {{ $room->number }}</h5>
                    <p class="fw-bold text-secondary small mb-0">{{ $room->type }}</p>
                </div>

                <!-- Status sebagai tombol -->
                <div class="mb-3">
                    @if($room->status == 'Available')
                        <!-- Tombol Check In -->
                        <form action="{{ route('checkin', $room->id) }}" method="POST" class="mb-2">
                            @csrf
                            <button type="submit" class="btn btn-success w-100 status-btn">
                                <i class="fa fa-check-circle me-2"></i> Check In
                            </button>
                        </form>

                        <!-- Tombol Cleaning -->
                        <form action="{{ route('rooms.updateStatus', $room->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="Cleaning">
                            <button type="submit" class="btn btn-secondary w-100 status-btn text-dark">
                                <i class="fa fa-broom me-2"></i> Dibersihkan
                            </button>
                        </form>

                    @elseif($room->status == 'Occupied')
                        <!-- Tombol Check Out -->
                        <form action="{{ route('checkout', $room->id) }}" method="POST" class="mb-2">
                            @csrf
                            <button type="submit" class="btn btn-danger w-100 status-btn">
                                <i class="fa fa-user me-2"></i> Check Out
                            </button>
                        </form>

                        <!-- Tombol Cleaning -->
                        <form action="{{ route('rooms.updateStatus', $room->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="Cleaning">
                            <button type="submit" class="btn btn-secondary w-100 status-btn text-dark">
                                <i class="fa fa-broom me-2"></i> Dibersihkan
                            </button>
                        </form>

                    @elseif($room->status == 'Cleaning')
                        <!-- Tombol Tandai Selesai -->
                        <form action="{{ route('rooms.updateStatus', $room->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="Available">
                            <button type="submit" class="btn btn-warning w-100 status-btn">
                                <i class="fa fa-exclamation-triangle me-2"></i> Sedang Dibersihkan
                            </button>
                        </form>

                    @else
                        <!-- Tombol Default (Tersedia) -->
                        <form action="{{ route('rooms.updateStatus', $room->id) }}" method="POST" class="mb-2">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="Available">
                            <button type="submit" class="btn btn-secondary w-100 status-btn">
                                <i class="fa fa-door-open me-2"></i> Tandai Tersedia
                            </button>
                        </form>

                        <!-- Tombol Cleaning -->
                        <form action="{{ route('rooms.updateStatus', $room->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="Cleaning">
                            <button type="submit" class="btn btn-secondary w-100 status-btn text-dark">
                                <i class="fa fa-broom me-2"></i> Dibersihkan
                            </button>
                        </form>
                    @endif
                </div>

                <!-- Tombol Detail -->
                <div class="mt-auto">
                    <a href="{{ route('rooms.show', $room->id) }}" 
                       class="btn btn-outline-primary w-100 shadow-sm detail-btn">
                        <i class="fa fa-eye me-1"></i> Detail Kamar
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Pagination -->
<div class="d-flex justify-content-between mt-4">
    @if ($rooms->onFirstPage())
        <span class="btn btn-light border disabled">Previous</span>
    @else
        <a href="{{ $rooms->previousPageUrl() }}" class="btn btn-primary">Previous</a>
    @endif

    <span class="align-self-center">
        Halaman <strong>{{ $rooms->currentPage() }}</strong> dari {{ $rooms->lastPage() }}
    </span>

    @if ($rooms->hasMorePages())
        <a href="{{ $rooms->nextPageUrl() }}" class="btn btn-primary">Next</a>
    @else
        <span class="btn btn-light border disabled">Next</span>
    @endif
</div>

<style>
    .room-card {
        transition: all 0.3s ease-in-out;
        background: #ffffff; /* lebih kontras dari background dashboard */
        border: 1px solid #e5e5e5;
    }
    .room-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 28px rgba(0,0,0,0.12);
    }
    .status-btn {
        border-radius: 30px;
        font-weight: 600;
        font-size: 0.9rem;
        padding: 10px 16px;
        transition: all 0.2s ease-in-out;
    }
    .status-btn:hover {
        opacity: 0.9;
        transform: scale(1.02);
    }
    .detail-btn {
        border-radius: 30px;
        transition: all 0.2s;
    }
    .detail-btn:hover {
        background: #0d6efd;
        color: white;
    }
</style>

@endsection
