@extends('admin.layouts.app')
@section('title', 'Informasi Kamar')

@section('content')


<div class="row">
    @foreach($rooms as $room)
    <div class="col-md-3 mb-4">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <h5 class="card-title">Kamar {{ $room->number }}</h5>
                <p class="text-muted">{{ $room->type }}</p>

                <!-- Status -->
                <div class="dropdown">
                    <button class="btn btn-sm 
                        @if($room->status == 'Available') btn-success 
                        @elseif($room->status == 'Occupied') btn-warning
                        @elseif($room->status == 'Cleaning') btn-secondary
                        @else btn-dark @endif
                        dropdown-toggle" 
                        type="button" id="dropdownMenuButton{{ $room->id }}" 
                        data-bs-toggle="dropdown" aria-expanded="false">
                        {{ $room->status }}
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $room->id }}">
                        @if($room->status == 'Available')
                            <li>
                                <form action="{{ route('checkin', $room->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Check In</button>
                                </form>
                            </li>
                        @elseif($room->status == 'Occupied')
                            <li>
                                <form action="{{ route('checkout', $room->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Check Out</button>
                                </form>
                            </li>
                            <li>
                                <form action="{{ route('rooms.updateStatus', $room->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="status" value="Cleaning">
                                    <button type="submit" class="dropdown-item">Sedang Dibersihkan</button>
                                </form>
                            </li>
                        @elseif($room->status == 'Cleaning' || $room->status == 'Locked')
                            <li>
                                <form action="{{ route('rooms.updateStatus', $room->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="status" value="Available">
                                    <button type="submit" class="dropdown-item">Tandai Tersedia</button>
                                </form>
                            </li>
                        @endif
                    </ul>
                </div>

                <!-- Barcode -->
                <div class="mt-3">
                    {!! DNS1D::getBarcodeHTML($room->barcode_key, 'C39', 1.5, 40) !!}
                    <small class="d-block">{{ $room->barcode_key }}</small>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
