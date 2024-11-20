<!-- Extends template 'app' dengan title 'Edit User || bengkel' -->
@extends('templates.app', ['title' => 'Edit User || Bengkel'])

<!-- Section 'content-dinamis' yang berisi konten utama halaman edit user -->
@section('content-dinamis')

  <!-- Cek jika ada pesan error di session -->
  @if (Session::get('failed'))
    <!-- Tampilkan pesan error di atas form -->
    <div class="alert alert-danger">{{Session::get('failed')}} </div>
  @endif

  <!-- Form edit user dengan action route 'user.edit.update' dan method 'POST' -->
  <form action="{{ route('user.edit.update', $users['id']) }}" method="POST">
    <!-- CSRF token untuk mencegah serangan CSRF -->
    @csrf

    <!-- Method 'PATCH' untuk mengupdate data user -->
    @method('PATCH')

    <!-- Field 'Nama' dengan label dan input text -->
    <div class="d-flex">
      <label for="name" class="col-md-4 col-form-label">Nama</label>
      <input type="text" class="form-control" id="name" name="name" value="{{ $users['name'] }}">
    </div>

    <!-- Cek jika ada error validasi pada field 'Nama' -->
    @error('name')
      <!-- Tampilkan pesan error di bawah input 'Nama' -->
      <small class="text-danger">{{ $message }}</small>
    @enderror

    <!-- Field 'Email' dengan label dan input email -->
    <div class="d-flex">
      <label for="email" class="col-md-4 col-form-label">Email : </label>
      <input type="email" class="form-control" id="email" name="email" value="{{ $users['email'] }}">
    </div>

    <!-- Cek jika ada error validasi pada field 'Email' -->
    @error('email')
      <!-- Tampilkan pesan error di bawah input 'Email' -->
      <small class="text-danger">{{ $message }}</small>
    @enderror

    <!-- Field 'Tipe Pengguna' dengan label dan select option -->
    <div class="flex">
      <label for="type-role" class="col-md-4 col-form-label">Tipe Pengguna : </label>
      <select name="type-role" id="type-role" class="col-md-4 col-form-label">
        <!-- Option 'Admin' dengan value 'admin' -->
        <option value="admin" {{ $users['type-role'] == 'admin' ? 'selected' : ''}}>Admin</option>
        <!-- Option 'Kasir' dengan value 'kasir' -->
        <option value="kasir" {{ $users['type-role'] == 'kasir' ? 'selected' : ''}}>Kasir</option>
      </select>
    </div>

    <!-- Cek jika ada error validasi pada field 'Tipe Pengguna' -->
    @error('type-role')
      <!-- Tampilkan pesan error di bawah select option 'Tipe Pengguna' -->
      <small class="text-danger">{{ $message }}</small>
    @enderror

    <!-- Field 'Password' dengan label dan input password -->
    <div class="d-flex">
      <label for="password" class="col-md-4 col-form-label">Password : </label>
      <input type="text" class="form-control" id="password" name="password" value="{{ $users['password'] }}">
    </div>

    <!-- Cek jika ada error validasi pada field 'Password' -->
    @error('password')
      <!-- Tampilkan pesan error di bawah input 'Password' -->
      <small class="text-danger">{{ $message }}</small>
    @enderror

    <!-- Tombol submit untuk mengupdate data user -->
    <button type="submit" class="btn btn-primary">Ubah Data</button>
  </form>
@endsection