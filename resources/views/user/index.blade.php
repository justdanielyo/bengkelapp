@extends('templates.app', ['title' => 'User || Bengkel'])

@section('content-dinamis')
    <div class="d-block mx-auto my-5">
        <a href="{{ route('user.add') }}" class="btn btn-success mb-3">+ Tambah</a>
        <!-- mengambil pesan yang dikirim controller lewat with -->
        @if (Session::get('success'))
            <div class="alert alert-success my-2"> {{ Session::get('success') }}</div>
        @endif
        <table class="table table-bordered table-striped text-center">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @if (@count($users) > 0)
                    @foreach ($users as $index => $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['email'] }}</td>
                            <td>{{ $item['role'] }}</td>
                            <td class="d-flex justify-content-center py-1">
                                <a href="{{ route('user.edit', $item['id']) }}" class="btn btn-primary me-2">Edit</a>
                                <button class="btn btn-danger"
                                    onclick="showModal('{{ $item->id }}', '{{ $item->name }}')">Hapus</button>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="text-bold">Data User Kosong</td>
                    </tr>
                @endif
            </tbody>
        </table>
        <div class="d-flex justify-content-end mt-3">
            <!-- links() : menampilkan button pagination digunakan hanya ketika di controllernya pake paginate() atau simplePaginate() -->
            {{ $users->links() }}
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="form-delete-user" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Data User</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Apakah Anda Yakin Ingin Menghapus Data <span id="name-user"></span> ?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <!-- save changes dibuat type ="submit" agar form di modal bisa dijalanin action -->
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endsection
    @push('script')
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            // Fungsi untuk menampilkan modal
            function showModal(id, name) {
                // isi untuk action form
                let action = '{{ route('user.delete', ':id') }}';
                action = action.replace(':id', id);
                // buat attribute action pada form
                $('#form-delete-user').attr('action', action);
                // Munculkan modal yang idnya exampleMOdal
                $('#exampleModal').modal('show');
                // InnerText pada element html id nama-obat
                console.log(name);
                $('#name-user').text(name);
            }
        </script>
    @endpush
