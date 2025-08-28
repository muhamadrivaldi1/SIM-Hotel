@extends('admin.layouts.app')
@section('title', 'Dashboard')

@section('content')

<div class="row row-cols-1 row-cols-md-4 g-4">

    @foreach($rooms as $room)
    <div class="col">
        <div class="card h-100 border-0 shadow room-card">
            <div class="card-body d-flex flex-column text-center">

                <!-- Nomor & Tipe Kamar -->
                <div class="mb-4">
                    <h5 class="fw-bold">{{ $room->number }}</h5>
                    <p class="text-muted mb-0">{{ $room->type }}</p>
                </div>

                <!-- Tombol Status -->
                <div class="d-grid gap-3 mb-3 button-group">
                    <!-- Check In -->
                    <a href="{{ route('rooms.show', $room->id) }}" 
                       class="btn btn-success btn-lg rounded-pill btn-action w-100"
                       data-action="checkin" data-room="{{ $room->id }}">
                        <i class="fa fa-check-circle me-2"></i> Check In
                    </a>

                    <!-- Check Out -->
                    <form action="{{ route('checkout', $room->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-lg rounded-pill btn-action w-100"
                                data-action="checkout" data-room="{{ $room->id }}">
                            <i class="fa fa-user me-2"></i> Check Out
                        </button>
                    </form>

                    <!-- Cleaning -->
                    <form action="{{ route('rooms.updateStatus', $room->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="Cleaning">
                        <button type="submit" class="btn btn-warning btn-lg rounded-pill btn-action w-100 text-dark"
                                data-action="cleaning" data-room="{{ $room->id }}">
                            <i class="fa fa-broom me-2"></i> Cleaning
                        </button>
                    </form>
                </div>

                <!-- Tombol Detail -->
                {{-- <a href="{{ route('rooms.show', $room->id) }}" 
                   class="btn btn-outline-primary btn-sm mt-auto rounded-pill w-100">
                    <i class="fa fa-eye me-1"></i> Detail Kamar
                </a> --}}

            </div>
        </div>
    </div>
    @endforeach

</div>

<!-- Pagination -->
<div class="d-flex justify-content-between align-items-center mt-4">
    @if ($rooms->onFirstPage())
        <span class="btn btn-light border disabled">Previous</span>
    @else
        <a href="{{ $rooms->previousPageUrl() }}" class="btn btn-primary">Previous</a>
    @endif

    <span>
        Halaman <strong>{{ $rooms->currentPage() }}</strong> dari {{ $rooms->lastPage() }}
    </span>

    @if ($rooms->hasMorePages())
        <a href="{{ $rooms->nextPageUrl() }}" class="btn btn-primary">Next</a>
    @else
        <span class="btn btn-light border disabled">Next</span>
    @endif
</div>

<!-- Styles -->
<style>
.room-card {
    border-radius: 1.25rem;
    transition: transform 0.3s, box-shadow 0.3s;
    background: #ffffff;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

.room-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 16px 40px rgba(0,0,0,0.15);
}

.btn-action {
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.2s ease-in-out;
}

.btn-action:hover {
    transform: scale(1.03);
}

a.btn-outline-primary {
    transition: all 0.2s;
}

a.btn-outline-primary:hover {
    background: #0d6efd;
    color: white;
    transform: scale(1.02);
}
</style>

@endsection
