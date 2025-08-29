@extends('admin.layouts.app')
@section('title','HRD')
@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEmployee">
            <i class="bi bi-plus-lg"></i> Add Employee
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
                        <th>Name</th>
                        <th>Position</th>
                        <th>Salary</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($employees as $emp)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $emp->name }}</td>
                        <td>{{ $emp->position }}</td>
                        <td>${{ number_format($emp->salary,2) }}</td>
                        <td>
                            @if($emp->status === 'Active')
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-warning me-1" data-bs-toggle="modal" data-bs-target="#editEmployee{{ $emp->id }}">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <form action="{{ route('hrd.destroy',$emp->id) }}" method="POST" class="d-inline">
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
        {{ $employees->links() }}
    </div>
</div>

<!-- Modals Add & Edit -->
@include('hrd.modals')
@endsection
