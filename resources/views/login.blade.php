@extends('templates.app', ['title' => 'Login || Bengkel'])

@section('content-dinamis')
    <form action="{{ route('login.auth') }}" class="card w-75 d-block mx-auto my-3" method="POST">
        @csrf
        @if (Session::get('failed'))
            <div class="alert alert-danger">{{ Session::get('failed') }}</div>
        @endif
        @if (Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        <div class="card-body">
            <h3 class="card-title tex-center">Login</h3>
            <div class="form-group">
                <label for="email" class="form-label">Email : </label>
                <input type="email" name="email" id="email" class="form-control">
                @error('email')
                    <span class="text-danger">{{ $message }}"></span>
                @enderror
            </div>
            <div class="form-group">
                <label for="password" class="form-label">Password : </label>
                <input type="password" name="password" id="password" class="form-control">
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </div>
    </form>
@endsection