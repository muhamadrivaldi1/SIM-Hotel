{{-- <div class="row row-cols-1 row-cols-md-4 g-4">
    @foreach($rooms as $room)
        <div class="col">
            <div class="card shadow-sm h-100 border-0 rounded-4 overflow-hidden" style="transition: transform 0.3s;">
                <div class="card-body text-center d-flex flex-column">
                    <h5 class="card-title mb-2">
                        <i class="fa fa-bed me-1 text-primary"></i> Kamar {{ $room->number }}
                    </h5>
                    <p class="text-muted mb-3">{{ $room->type }}</p>

                    <span class="badge rounded-pill mb-3 px-3 py-2 
                        @if($room->status == 'Available') bg-success
                        @elseif($room->status == 'Occupied') bg-warning text-dark
                        @elseif($room->status == 'Cleaning') bg-secondary
                        @elseif($room->status == 'Locked') bg-danger
                        @else bg-dark
                        @endif
                        ">
                        {{ $room->status }}
                    </span>

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

<!-- Pagination: hanya tampil jika $rooms adalah Paginator -->
@if($rooms instanceof \Illuminate\Pagination\LengthAwarePaginator)
    <div class="d-flex justify-content-center mt-4">
        {{ $rooms->links('pagination::bootstrap-5') }}
    </div>
@endif --}}
