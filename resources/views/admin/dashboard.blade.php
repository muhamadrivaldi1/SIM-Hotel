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
                <div class="d-grid gap-3 mb-3">
                    @php
                        $statusClass = match($room->status) {
                            'Available' => 'btn-success',
                            'Occupied' => 'btn-danger',
                            'Cleaning' => 'btn-warning text-dark',
                            default => 'btn-secondary',
                        };
                    @endphp

                    <a href="{{ route('rooms.show', $room->id) }}" 
                       class="btn btn-lg rounded-pill w-100 {{ $statusClass }}"
                       data-room="{{ $room->id }}">
                        {{ $room->status }}
                    </a>
                </div>

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

.btn-lg {
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.2s ease-in-out;
}

.btn-lg:hover {
    transform: scale(1.03);
}
</style>

@endsection
