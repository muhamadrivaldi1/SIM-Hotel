@extends('admin.layouts.app')
@section('title', '')

@section('content')
<div class="container my-5">
    <h2 class="mb-4 text-center">Check-In Kamar via Barcode</h2>

    <!-- Notifikasi -->
    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

    <!-- Form Scan Barcode Cepat -->
    <div class="card mb-5 p-4 shadow-sm mx-auto form-card">
       <form action="{{ route('checkin.barcode') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="barcode" class="form-label">Scan Barcode Kamar</label>
        <input type="text" id="barcode" name="barcode" class="form-control" autofocus placeholder="Scan atau masukkan kode kamar">
    </div>
    <button type="submit" class="btn btn-primary w-100">
        <i class="fa fa-sign-in-alt me-1"></i> Check-In via Barcode
    </button>
    <br><br>
           <!-- Tombol Kembali ke Dashboard kecil di kiri -->
               <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm">
                   <i class="fa fa-arrow-left me-1"></i> Kembali
               </a>
    </div>
</form>
    
    {{-- <h4 class="mb-4 text-center">Daftar Kamar Tersedia</h4>
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

                    <!-- Check-In Button -->
                    <form action="{{ route('checkin.store', $room->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success w-100 btn-lg rounded-pill">
                            <i class="fa fa-sign-in-alt me-1"></i> Check-In
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-center">Tidak ada kamar tersedia.</p>
        @endforelse
    </div> --}}
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

.form-card {
    max-width: 500px;
    padding: 2rem 1.5rem;
}

/* Media Query untuk Desktop */
@media (min-width: 992px) {
    .room-card {
        max-width: 360px;
        padding: 3rem 2rem;
    }
    .form-card {
        max-width: 600px;
        padding: 3rem 2rem;
    }
}
</style>

@endsection
