@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <h5 class="card-title">Total Rooms</h5>
                <p class="card-text">{{ $rooms->count() }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h5 class="card-title">Occupied Rooms</h5>
                <p class="card-text">{{ $rooms->where('status','Occupied')->count() }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning mb-3">
            <div class="card-body">
                <h5 class="card-title">Available Rooms</h5>
                <p class="card-text">{{ $rooms->where('status','Available')->count() }}</p>
            </div>
        </div>
    </div>
</div>

<h3 class="mt-4">Recent Rooms</h3>
<table class="table table-striped mt-2">
    <thead>
        <tr>
            <th>#</th>
            <th>Room Name</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($rooms as $room)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $room->name }}</td>
            <td>{{ $room->status }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
