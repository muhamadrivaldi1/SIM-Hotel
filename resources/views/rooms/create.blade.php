@extends('admin.layouts.app')
@section('title', 'Tambah Kamar')

@section('content')
<h3>Tambah Kamar Baru</h3>

<form action="{{ route('rooms.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label class="form-label">Nomor Kamar</label>
        <input type="text" name="number" class="form-control" value="{{ old('number') }}" required>
        @error('number')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Tipe Kamar</label>
        <input type="text" name="type" class="form-control" value="{{ old('type') }}" required>
        @error('type')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select" required>
            <option value="Available" @if(old('status')=='Available') selected @endif>Available</option>
            <option value="Occupied" @if(old('status')=='Occupied') selected @endif>Occupied</option>
            <option value="Locked" @if(old('status')=='Locked') selected @endif>Locked</option>
        </select>
        @error('status')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{ route('rooms.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection
