@extends('admin.layouts.app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">

            {{-- Notifikasi --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card shadow-lg border-0 rounded-3 p-4 text-center">

                <h4 class="fw-bold mb-1">Kamar {{ $room->number }}</h4>
                <h6 class="text-muted mb-3">{{ $room->type }}</h6>

                {{-- Status --}}
                <p>
                    <span class="badge px-3 py-1 fs-6
                        @if($room->status === 'Available') bg-success
                        @elseif($room->status === 'Occupied') bg-danger
                        @elseif($room->status === 'Cleaning') bg-warning text-dark
                        @elseif($room->status === 'Locked') bg-dark
                        @elseif($room->status === 'Maintenance') bg-secondary text-white
                        @else bg-secondary @endif">
                        {{ $room->status }}
                    </span>
                </p>

                <div class="d-grid gap-2 mt-3">

                    {{-- Jika status Maintenance --}}
                    @if($room->status === 'Maintenance')
                        <form action="{{ route('rooms.updateStatus', $room->id) }}" method="POST"
                              onsubmit="return confirm('Apakah kamar sudah selesai perawatan?')">
                            @csrf @method('PUT')
                            <input type="hidden" name="status" value="Available">
                            <button type="submit" class="btn btn-success btn-md rounded-pill w-100 py-2">
                                <i class="fa fa-check-circle me-1"></i> Selesai Maintenance
                            </button>
                        </form>

                    {{-- Jika status Cleaning --}}
                    @elseif($room->status === 'Cleaning')
                        <form action="{{ route('rooms.updateStatus', $room->id) }}" method="POST"
                              onsubmit="return confirm('Apakah kamar sudah selesai dibersihkan?')">
                            @csrf @method('PUT')
                            <input type="hidden" name="status" value="Available">
                            <button type="submit" class="btn btn-success btn-md rounded-pill w-100 py-2">
                                <i class="fa fa-check-circle me-1"></i> Selesai Cleaning
                            </button>
                        </form>

                    {{-- Jika status Available atau Locked --}}
                    @else
                        {{-- Tombol Check In --}}
                        <a href="{{ route('checkin.index') }}" 
                           class="btn btn-success btn-md rounded-pill w-100 py-2"
                           {{ $room->status !== 'Available' ? 'disabled' : '' }}>
                           <i class="fa fa-sign-in-alt me-1"></i> Check In
                        </a>

                        {{-- Tombol Check Out --}}
                        <form action="{{ route('checkouts.store', $room->id) }}" method="POST"
                              onsubmit="return confirm('Yakin ingin Check-Out kamar ini?')">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-md rounded-pill w-100 py-2"
                                {{ $room->status !== 'Occupied' ? 'disabled' : '' }}>
                                <i class="fa fa-sign-out-alt me-1"></i> Check Out
                            </button>
                        </form>

                        {{-- Tombol Cleaning --}}
                        <form action="{{ route('rooms.updateStatus', $room->id) }}" method="POST">
                            @csrf @method('PUT')
                            <input type="hidden" name="status" value="Cleaning">
                            <button type="submit" class="btn btn-warning btn-md rounded-pill w-100 py-2 text-dark"
                                {{ !in_array($room->status, ['Available','Locked']) ? 'disabled' : '' }}>
                                <i class="fa fa-broom me-1"></i> Cleaning
                            </button>
                        </form>

                        {{-- Tombol Maintenance --}}
                        <form action="{{ route('rooms.updateStatus', $room->id) }}" method="POST">
                            @csrf @method('PUT')
                            <input type="hidden" name="status" value="Maintenance">
                            <button type="submit" class="btn btn-secondary btn-md rounded-pill w-100 py-2 text-white"
                                {{ in_array($room->status, ['Occupied', 'Maintenance']) ? 'disabled' : '' }}>
                                <i class="fa fa-tools me-1"></i> Maintenance
                            </button>
                        </form>
                    @endif

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
