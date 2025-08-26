@extends('admin.layouts.app')
@section('title', 'Daftar Kamar')

@section('content')
<a href="{{ route('rooms.create') }}" class="btn btn-primary mb-3">Tambah Kamar</a>

<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>No</th>
            <th>Nomor Kamar</th>
            <th>Tipe</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($rooms as $room)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $room->number }}</td>
            <td>{{ $room->type }}</td>
            <td>
                @if($room->status == 'Available')
                    <span class="badge bg-success">{{ $room->status }}</span>
                @elseif($room->status == 'Occupied')
                    <span class="badge bg-warning">{{ $room->status }}</span>
                @else
                    <span class="badge bg-secondary">{{ $room->status }}</span>
                @endif
            </td>
            <td>
                <a href="{{ route('rooms.edit', $room->id) }}" class="btn btn-sm btn-info">Edit</a>
                <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
