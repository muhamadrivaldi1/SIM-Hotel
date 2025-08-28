@extends('admin.layouts.app')
@section('title', 'QR Code Kamar')

@section('content')
<div class="container text-center my-5">
    <div class="card shadow-lg border-0 rounded-4 p-4">
        <h2 class="fw-bold mb-3">Kamar {{ $room->number }}</h2>
        <h4 class="text-muted mb-4">{{ $room->type }}</h4>

        <!-- QR Code -->
        <div class="d-flex justify-content-center mb-4">
            {!! QrCode::size(250)->generate($qrData) !!}
        </div>

        <p class="text-muted">Scan kode ini untuk informasi kamar.</p>

        <a href="{{ route('rooms.show', $room->id) }}" class="btn btn-primary rounded-pill">
            <i class="fa fa-arrow-left me-1"></i> Kembali ke Detail
        </a>
    </div>
</div>
@endsection
