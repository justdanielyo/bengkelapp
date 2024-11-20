@extends('templates.app', ['title' => 'Tambah Item || Bengkel'])

@section('content-dinamis')
<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('bengkels.add.store') }}" method="POST">
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
                    <label for="name" class="col-md-4 col-form-label">Nama Item</label>
                    <div class="col-md-8">
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="type" class="col-md-4 col-form-label">Tipe Item</label>
                    <div class="col-md-8">
                        <select name="type" id="type" class="form-select">
                            <option hidden selected disabled>Pilih</option>
                            <option value="oli" {{ old('type') == 'oli' ? 'selected' : ''}}>Oli</option>
                            <option value="ban" {{ old('type') == 'ban' ? 'selected' : ''}}>Ban Motor</option>
                            <option value="fix" {{ old('type') == 'fix' ? 'selected' : ''}}>Fix</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="price" class="col-md-4 col-form-label">Harga Obat</label>
                    <div class="col-md-8">
                        <input type="number" name="price" id="price" class="form-control" value="{{ old('price') }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="stock" class="col-md-4 col-form-label">Stock</label>
                    <div class="col-md-8">
                        <input type="number" name="stock" id="stock" class="form-control" value="{{ old('stock') }}">
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