@extends('templates.app', ['title' => 'Order || Bengkel'])

@section('content-dinamis')
    <form action="{{ route('orders.store') }}" method="POST" class="card d-block mx-auto my-4 p-5">
        <div class="container my-5">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8 col-sm-12">
                    <form action="" method="POST" class="card p-4 shadow-sm">
                        @csrf
                        <h1 class="text-center mb-4">Buat Pembelian</h1>
                        @if (Session::get('success'))
                            <div class="alert alert-success">{{ Session::get('success') }}</div>
                        @endif
                        @if (Session::get('failed'))
                            <div class="alert alert-danger">{{ Session::get('failed') }}</div>
                        @endif
                        <div class="form-group mb-3">
                            <label for="name_customer" class="form-label">Nama Pembeli</label>
                            <input type="text" name="name_customer" id="name_customer" class="form-control"
                                placeholder="Masukkan Nama Pembeli" value="{{ old('name_customer') }}">
                            @error('name_customer')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        @if (old('bengkels'))
                            @foreach (old('bengkels') as $no => $item)
                                <div class="form-group mb-3" id="bengkels-{{ $no }}">
                                    <label for="bengkels" class="form-label">Obat {{ $no + 1 }}
                                        @if ($no > 0)
                                            <span style="cursor: pointer; font-weight: bold; padding: 5px; color: red;"
                                                onclick="deleteSelect('bengkels-{{ $no }}')">Hapus</span>
                                        @endif
                                    </label>
                                    <select name="bengkels[]" id="bengkel" class="form-select">
                                        <option disabled selected hidden>Pilih Obat</option>
                                        @foreach ($bengkels as $bengkel)
                                            <option value="{{ $bengkel['id'] }}"
                                                {{ $item == $bengkel['id'] ? 'selected' : '' }}>{{ $bengkel['name'] }}
                                                - Rp. {{ number_format($bengkel['price'], 0, ',', '.') }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endforeach
                        @else
                            <div class="form-group mb-3">
                                <label for="bengkels" class="form-label">Obat 1:</label>
                                <select name="bengkels[]" id="bengkel" class="form-select">
                                    <option disabled selected hidden>Pilih Obat</option>
                                    @foreach ($bengkels as $bengkel)
                                        <option value="{{ $bengkel['id'] }}">{{ $bengkel['name'] }} - Rp.
                                            {{ number_format($bengkel['price'], 0, ',', '.') }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <div id="bengkels-more"></div>
                        <div class="text-center mb-4">
                            <span class="text-primary fw-bold" style="cursor: pointer;" id="btn-more">+ Tambah Obat</span>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary w-100">Buat Pesanan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        let no = {{ old('bengkels') ? count(old('bengkels')) + 1 : 2 }};
        $('#btn-more').on("click", function() {
            let elSelect = `<div class="form-group mb-3" id="bengkels-${no}">
            <label for="bengkels" class="form-label">Obat ${no} <span style="cursor: pointer; font-weight: bold; padding: 5px; color: red;" onclick="deleteSelect('bengkels-${no}')">X</span>:</label>
            <select name="bengkels[]" id="bengkel" class="form-select">
                <option disabled selected hidden>---Pilih---</option>
                @foreach ($bengkels as $bengkel)
                <option value="{{ $bengkel['id'] }}">{{ $bengkel['name'] }} - Rp. {{ number_format($bengkel['price'], 0, ',', '.') }}</option>
                @endforeach
            </select>
        </div>`;

            $("#bengkels-more").append(elSelect);
            no++;
        });

        function deleteSelect(elementId) {
            let elementIdForDelete = "#" + elementId;
            $(elementIdForDelete).remove();
            no--;
        }
    </script>
@endpush
