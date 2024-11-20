<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\bengkel;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrdersExport;
use PDF;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->date && $request->search) {
            $orders = Order::where('name_customer', 'like', '%'.$request->search.'%')
                           ->whereDate('created_at', $request->date)
                           ->orderBy('name_customer', 'asc')
                           ->simplePaginate(10);
        } elseif ($request->search) {
            $orders = Order::where('name_customer', 'like', '%'.$request->search.'%')
                           ->orderBy('name_customer', 'asc')
                           ->simplePaginate(10);
        } elseif ($request->date) {
            $orders = Order::whereDate('created_at', $request->date)
                           ->simplePaginate(10);
        } else {
            $orders = Order::orderBy('name_customer', 'asc')->simplePaginate(10);
        }
        
        return view('order.index', compact('orders'));
    }

    public function exportExcel() 
    {
        return Excel::download(new OrdersExport, 'rekap-pembelian.xlsx');
    }

    public function indexAdmin() {
        $orders = Order::with('user')->simplePaginate(10);
        return view('order.rekap-data', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // memerlukan data list obat untuk di pembelian input
        $bengkel = bengkel::all();
        $bengkels = bengkel::where('stock', '>', 0)->get();
        return view('order.create', compact('bengkels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_customer'=> 'required',
            'bengkels'=> 'required',
        ]);
        $hitungJumlahDuplikat = array_count_values($request->bengkels);
        $arrayformat = [];
        foreach ($hitungJumlahDuplikat as $key => $value) {
            $detailObat = bengkel::find($key);
            if ($detailObat["stock"] < $value) {
                $msg = 'Tidak dapat membeli obat ' . $detailObat["name"] . ' sisa stock ' . $detailObat["stock"];
                return redirect()->back()->withInput()->with('failed', $msg);
            }
            $formatObat = [
                "id" => $key,
                "name_bengkel" => $detailObat["name"],
                "price" => $detailObat["price"],
                "qty" => $value,
                "subprice" => $detailObat["price"] * $value,
            ];
            array_push($arrayformat, $formatObat);
    }
    $totalHarga = 0;
    foreach ($arrayformat as $key => $value) {
        $totalHarga += $value["subprice"];
    }
    $tambahOrder = Order::create([
        'user_id'=> Auth::user()->id,
        'bengkels'=> $arrayformat,
        'name_customer' => $request->name_customer,
        'total_price' => $totalHarga
    ]);
    if ($tambahOrder) {
        foreach ($arrayformat as $key => $value) {
           $obatSebelumnya = bengkel::find($value["id"]);
           bengkel::where("id", $value["id"])->update([
               "stock"=> ($obatSebelumnya["stock"] - $value["qty"]),
           ]);
        }
        return redirect()->route('orders.show', $tambahOrder->id)->with('success', 'Pembelian Berhasil!');
    }
}

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $order = Order::find($id);
        return view('order.print', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }

    public function downloadPDF($id) {
        // kita bakal mengambil data order yang nanti diubah menjadi array
        $order = Order::find($id)->toArray();
        // agar data order bisa kita kasih kita menggunakan share
        view()->share('order', $order);
        // ambil halaman tujuan kita
        $pdf = PDF::loadView('order.download-pdf', $order);
        // tinggal buat agar di download
        return $pdf->download('invoice.pdf');
    }
}
