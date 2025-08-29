@extends('admin.layouts.app')
@section('title','Finance')
@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-between mb-3">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTransaction">
            <i class="bi bi-plus-lg"></i> Add Transaction
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Description</th>
                        <th>Date</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($finances as $finance)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $finance->transaction_type }}</td>
                        <td>${{ number_format($finance->amount,2) }}</td>
                        <td>{{ $finance->description }}</td>
                        <td>{{ \Carbon\Carbon::parse($finance->date)->format('d M Y') }}</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-warning me-1" data-bs-toggle="modal" data-bs-target="#editTransaction{{ $finance->id }}">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <form action="{{ route('finance.destroy',$finance->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $finances->links() }}
    </div>
</div>

<!-- Include modals -->
@include('finance.modals')
@endsection
