@extends('templates.app', ['title' => 'Order || Bengkel'])

@section('content-dinamis')
    <div class="container mt-3">
        <div class="d-flex justify-content-between mb-3">
            <form action="{{ route('orders') }}" method="GET" class="d-flex" role="search">
                <input type="date" name="date" value="{{ request('date') }}" class="form-control me-2" placeholder="Select Date">
                <button type="submit" class="btn btn-primary">Cari Data</button>
                <a href="{{ route('orders') }}" class="btn btn-secondary ms-2">Clear</a>
            </form>
        </div>

        <div class="d-flex justify-content-end">
            <a href="{{ route('orders.export-excel') }}" class="btn btn-success">Export Excel</a>
        </div>

        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th>Pembeli</th>
                    <th>Obat</th>
                    <th>Total Bayar</th>
                    <th>Kasir</th>
                    <th>Tanggal Beli</th>
                </tr>
            </thead>
            <tbody>
                @php $no = $orders->firstItem(); @endphp
                @foreach ($orders as $item)
                    @php 
                        // Hitung PPN
                        $ppn = !empty($item['total_price']) ? $item['total_price'] * 0.1 : 0; 
                        $total_with_ppn = $item['total_price'] + $ppn; // Total harga termasuk PPN
                    @endphp
                    <tr>
                        <td class="text-center">{{ $no++ }}</td>
                        <td>{{ $item['name_customer'] }}</td>
                        <td>
                            <ol>
                                @foreach ($item['bengkels'] as $bengkel)
                                    <li>
                                        {{ $bengkel['name_bengkel'] }}
                                        ({{ number_format($bengkel['price'], 0, ',', '.') }}) : Rp.
                                        {{ number_format($bengkel['subprice'], 0, ',', '.') }} 
                                        <small>qty {{ $bengkel['qty'] }}</small>
                                    </li>
                                @endforeach
                            </ol>
                        </td>
                        <td>Rp. {{ number_format($total_with_ppn, 0, ',', '.') }}</td> <!-- Menampilkan total harga + PPN -->
                        <td>{{ $item['user']['name'] }}</td>
                        <td>{{ \Carbon\Carbon::parse($item['created_at'])->format('d F Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-end">
            @if ($orders->count())
                {{ $orders->links() }}
            @endif
        </div>
    </div>
@endsection