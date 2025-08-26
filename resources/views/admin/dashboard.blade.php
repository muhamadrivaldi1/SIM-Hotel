@extends('admin.layouts.app')
@section('title', 'Front Office')

@section('content')

<div class="row row-cols-1 row-cols-md-4 g-4">
    @foreach($rooms as $room)
    <div class="col">
        <div class="card shadow-sm h-100 border-0 rounded-4 overflow-hidden" style="transition: transform 0.3s;">
            <div class="card-body text-center d-flex flex-column">
                <!-- Header -->
                <h5 class="card-title mb-2">
                    <i class="fa fa-bed me-1 text-primary"></i> Kamar {{ $room->number }}
                </h5>
                <p class="text-muted mb-3">{{ $room->type }}</p>

                <!-- Status -->
                <span class="badge rounded-pill mb-3 px-3 py-2 
                    @if($room->status == 'Available') bg-success
                    @elseif($room->status == 'Occupied') bg-warning text-dark
                    @elseif($room->status == 'Cleaning') bg-secondary
                    @else bg-dark
                    @endif
                    ">
                    @if($room->status == 'Available') <i class="fa fa-check-circle me-1"></i> @endif
                    @if($room->status == 'Occupied') <i class="fa fa-user me-1"></i> @endif
                    @if($room->status == 'Cleaning') <i class="fa fa-broom me-1"></i> @endif
                    {{ $room->status }}
                </span>

                <!-- Tombol Detail -->
                <div class="mt-auto">
                    <a href="{{ route('rooms.show', $room->id) }}" class="btn btn-primary btn-sm w-100 shadow-sm">
                        <i class="fa fa-eye me-1"></i> Detail Kamar
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="d-flex justify-content-between mt-4">
    <!-- Previous -->
    @if ($rooms->onFirstPage())
        <span class="btn btn-secondary disabled">Previous</span>
    @else
        <a href="{{ $rooms->previousPageUrl() }}" class="btn btn-primary">Previous</a>
    @endif

    <!-- Info halaman -->
    <span class="align-self-center">
        Halaman {{ $rooms->currentPage() }} dari {{ $rooms->lastPage() }}
    </span>

    <!-- Next -->
    @if ($rooms->hasMorePages())
        <a href="{{ $rooms->nextPageUrl() }}" class="btn btn-primary">Next</a>
    @else
        <span class="btn btn-secondary disabled">Next</span>
    @endif
</div>

<style>
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }
    .badge {
        font-size: 0.9rem;
    }
</style>

@endsection

