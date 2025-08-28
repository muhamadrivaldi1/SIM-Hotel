@extends('admin.layouts.app')
@section('title', '')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card shadow-lg border-0 rounded-4 overflow-hidden text-center p-4">
                <h2 class="fw-bold display-4 mb-2">Kamar {{ $room->number }}</h2>
                <h4 class="fw-bold text-muted">{{ $room->type }}</h4>

                <div class="d-grid gap-3 mt-4">
                    
                    <form action="{{ route('checkin', $room->id) }}" method="POST">
                        @csrf
                        <button type="submit" 
                            class="btn btn-lg rounded-pill shadow-sm w-100 
                            {{ $room->status === 'Available' ? 'btn-success' : 'btn-secondary' }}" 
                            {{ $room->status === 'Available' ? '' : 'disabled' }}>
                            <i class="fa fa-sign-in-alt me-1"></i> Check In
                        </button>
                    </form>

                    <form action="{{ route('checkout', $room->id) }}" method="POST">
                        @csrf
                        <button type="submit" 
                            class="btn btn-lg rounded-pill shadow-sm w-100 
                            {{ $room->status === 'Occupied' ? 'btn-danger' : 'btn-secondary' }}" 
                            {{ $room->status === 'Occupied' ? '' : 'disabled' }}>
                            <i class="fa fa-sign-out-alt me-1"></i> Check Out
                        </button>
                    </form>

                    <form action="{{ route('rooms.updateStatus', $room->id) }}" method="POST">
                        @csrf @method('PUT')
                        <input type="hidden" name="status" value="Cleaning">
                        <button type="submit" 
                            class="btn btn-lg rounded-pill shadow-sm w-100 
                            {{ $room->status === 'Occupied' ? 'btn-warning' : 'btn-secondary' }}" 
                            {{ $room->status === 'Occupied' ? '' : 'disabled' }}>
                            <i class="fa fa-broom me-1"></i> Bersihkan
                        </button>
                    </form>

                    <form action="{{ route('rooms.updateStatus', $room->id) }}" method="POST">
                        @csrf @method('PUT')
                        <input type="hidden" name="status" value="Available">
                        <button type="submit" 
                            class="btn btn-lg rounded-pill shadow-sm w-100 
                            {{ in_array($room->status, ['Cleaning','Locked']) ? 'btn-primary' : 'btn-secondary' }}" 
                            {{ in_array($room->status, ['Cleaning','Locked']) ? '' : 'disabled' }}>
                            <i class="fa fa-check-circle me-1"></i> Tandai Tersedia
                        </button>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
