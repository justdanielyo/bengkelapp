@extends('templates.app', ['title' => 'Edit Item || Bengkel'])

@section('content-dinamis')
<!-- action route mengirim $item ['id'] untuk spesifikasi data di route path {id} -->
 @if (Session::get('failed'))
 <div class="alert alert-danger">{{Session::get('failed')}} </div>
 @endif
<form action ="{{ route('bengkels.edit.update', $bengkels ['id']) }}" method ="POST">
    @csrf
    <!-- path : http method route untuk ubah data -->
    @method('PATCH')
    <div class="d-flex">
        <label for="" class="col-md-4 col-form-label">Nama Item</label>
        <input type ="text" class="form-control" id="name" name="name" value="{{ $bengkels['name'] }}">
    </div>
    <!-- jika ada error validasi berhubungan dengan name, tampilkan dibawah input name text merah -->
        @error('name')
        <small class ="text-danger">{{ $message }}</small>
        @enderror
    <div class="flex">
        <label for="type" class="col-md-4 col-form-label">Tipe Obat</label>
        <select name="type" id="type" class="col-md-4 col-form-label">
            <option value="oli" {{ $bengkels['type'] == 'oli' ? 'selected' : ''}}>Oli</option>
            <option value="ban" {{ $bengkels['type'] == 'ban' ? 'selected' : ''}}>Ban Motor</option>
            <option value="fix" {{ $bengkels['type'] == 'fix' ? 'selected' : ''}}>Fix</option>
        </select>
    </div>
    @error('type')
    <small class ="text-danger">{{ $message }}</small>
    @enderror
    <div class="d-flex">
        <label for="price" class="col-md-4 col-form-label">Harga</label>
        <input type ="number" class="form-control" id="price" name="price" value="{{ $bengkels['price'] }}">
        @error('price')
        <small class ="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="d-flex">
        <label for="stock" class="col-md-4 col-form-label">Stock</label>
        <input type ="number" class="form-control" id="stock" name="stock" value="{{ $bengkels['stock'] }}">
        @error('stock')
        <!-- $message : memunculkan error terkait stock -->
        <small class ="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <button type ="submit" class="btn btn-primary">Ubah Data</button>
</form>
@endsection