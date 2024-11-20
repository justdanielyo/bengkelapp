<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon;

class OrdersExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Order::with('user')->get();
    }

    public function headings(): array {
        return [
            "#",
            "Nama Kasir",
            "Daftar Obat",
            "Nama Pembeli",
            "Total Harga",
            "Tanggal Pembelian"
        ];
    }

    public function map($order): array {
        $daftarObat = "";
        foreach ($order->bengkels as $key => $value) {
            $format = $key+1 . ". " . $value['name_bengkel'] . " : " . $value['qty'] . " (pcs) Rp. " . number_format($value['subprice'], 0, ',', '.');
            $daftarObat .= $format; 
        }
        $ppn = !empty($order->total_price) ? $order->total_price * 0.1 : 0;
        $total_with_ppn = $order->total_price + $ppn;
        return [
            $order->id,
            $order->user->name,
            $daftarObat,
            $order->name_customer,
            "Rp. " . number_format($total_with_ppn, 0, ',', '.'),
            // $order->created_at
            \Carbon\Carbon::parse($order->created_at)->format('d F Y') 
        ];
    }
}