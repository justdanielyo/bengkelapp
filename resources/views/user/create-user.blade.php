@extends('templates.app', ['title' => 'Buat Akun || Bengkel'])

@section('content-dinamis')
<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('user.add.store') }}" method="POST">
                @csrf
                @if (Session::get('failed'))
                <div class="alert alert-danger my-2"> {{Session::get('failed')}}</div>
                @endif
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ol>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ol>
                </div>
                @endif
                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label">Nama : </label>
                    <div class="col-md-8">
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-md-4 col-form-label">Email : </label>
                    <div class="col-md-8">
                        <input type="text" name="email" id="email" class="form-control" value="{{ old('email') }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="password" class="col-md-4 col-form-label">Password : </label>
                    <div class="col-md-8">
                        <input type="password" name="password" id="password" class="form-control" value="{{ old('email') }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="type-role" class="col-md-4 col-form-label">Tipe Pengguna : </label>
                    <div class="col-md-8">
                        <select name="type-role" id="type-role" class="form-select">
                            <option hidden selected disabled>Pilih</option>
                            <option value="admin" {{ old('type-role') == 'admin' ? 'selected' : ''}}>Admin</option>
                            <option value="kasir" {{ old('type-role') == 'kasir' ? 'selected' : ''}}>Kasir</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-block btn-success">Kirim Data</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection