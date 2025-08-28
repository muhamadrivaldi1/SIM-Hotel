@extends('admin.layouts.auth')

@section('title', 'Login')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-sm" style="width: 400px;">
        <div class="card-header text-center bg-primary text-white">
            <h4>Login</h4>
        </div>
        <div class="card-body">
            
            {{-- Error validasi --}}
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Error dari proses login gagal --}}
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        class="form-control" 
                        value="{{ old('email') }}" 
                        required 
                        autofocus>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        class="form-control" 
                        required>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
