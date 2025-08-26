@extends('admin.layouts.app')
@section('title', 'Detail Kamar')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <!-- Header -->
                <div class="card-header bg-gradient bg-primary text-white d-flex align-items-center">
                    <i class="fa fa-bed fa-lg me-2"></i>
                    <h5 class="mb-0">Detail Kamar {{ $room->number }}</h5>
                </div>

                <!-- Body -->
                <div class="card-body p-4">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Tipe Kamar</p>
                            <h6 class="fw-bold">{{ $room->type }}</h6>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <p class="text-muted mb-1">Status</p>
                            <span class="badge fs-6
                                @if($room->status == 'Available') bg-success
                                @elseif($room->status == 'Occupied') bg-danger
                                @elseif($room->status == 'Cleaning') bg-warning text-dark
                                @elseif($room->status == 'Locked') bg-secondary
                                @else bg-dark
                                @endif
                                px-3 py-2 rounded-pill">
                                {{ $room->status }}
                            </span>
                        </div>
                    </div>

                    <!-- Barcode -->
                    <div class="text-center mb-4">
                        <p class="fw-semibold mb-2">Barcode</p>
                        <div class="bg-light p-3 d-inline-block rounded-3 shadow-sm">
                            {!! DNS1D::getBarcodeHTML($room->barcode_key, 'C39', 1.5, 50) !!}
                        </div>
                        <p class="text-muted small mt-2">{{ $room->barcode_key }}</p>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="text-center mt-4">
                        @if($room->status == 'Available')
                            <!-- Check In -->
                            <form action="{{ route('checkin', $room->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Check In</button>
                            </form>

                            <!-- Locked dengan Barcode -->
                            <form action="{{ route('rooms.lockWithBarcode', $room->id) }}" method="POST" class="d-inline mt-2">
                                @csrf
                                <input type="text" name="barcode" placeholder="Scan barcode di sini" class="form-control d-inline-block w-auto" required>
                                <button type="submit" class="btn btn-dark btn-lg rounded-pill px-4 shadow-sm ms-2">
                                    <i class="fa fa-lock me-1"></i> Kunci Kamar
                                </button>
                            </form>

                        @elseif($room->status == 'Occupied')
                            <!-- Check Out -->
                            <form action="{{ route('checkout', $room->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Check Out</button>
                            </form>

                            <!-- Cleaning -->
                            <form action="{{ route('rooms.updateStatus', $room->id) }}" method="POST" class="d-inline">
                                @csrf @method('PUT')
                                <input type="hidden" name="status" value="Cleaning">
                                <button type="submit" class="btn btn-secondary btn-lg rounded-pill px-4 shadow-sm ms-2">
                                    <i class="fa fa-broom me-1"></i> Sedang Dibersihkan
                                </button>
                            </form>

                        @elseif($room->status == 'Cleaning' || $room->status == 'Locked')
                            <!-- Tandai Available -->
                            <form action="{{ route('rooms.updateStatus', $room->id) }}" method="POST" class="d-inline">
                                @csrf @method('PUT')
                                <input type="hidden" name="status" value="Available">
                                <button type="submit" class="btn btn-primary btn-lg rounded-pill px-4 shadow-sm">
                                    <i class="fa fa-check-circle me-1"></i> Tandai Tersedia
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Audio untuk feedback -->
<audio id="successSound" src="{{ asset('sounds/success.mp3') }}"></audio>
<audio id="errorSound" src="{{ asset('sounds/error.mp3') }}"></audio>

<!-- Alert + suara -->
@if(session('error'))
<script>
    alert("{{ session('error') }}");
    document.getElementById('errorSound').play();
</script>
@endif

@if(session('success'))
<script>
    alert("{{ session('success') }}");
    document.getElementById('successSound').play();
</script>
@endif
@endsection

<!-- Alert + beep JS tanpa file -->
<script>
function speak(text) {
    const utterance = new SpeechSynthesisUtterance(text);
    utterance.lang = 'id-ID'; // Bahasa Indonesia
    window.speechSynthesis.speak(utterance);
}

@if(session('error'))
alert("{{ session('error') }}");
speak("Kunci Salah!");
@endif

@if(session('success'))
alert("{{ session('success') }}");
speak("Kunci Berhasil!");
@endif
</script>
