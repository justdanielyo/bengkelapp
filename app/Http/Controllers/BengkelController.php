<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// import model
use App\Models\bengkel;

class BengkelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // Request $request : mengambil data dari form yang dikirim ke action terhubung dengan func ini
    public function index(Request $request)
    {
        // mengambil data bengkels
        // mengambil semua data : NamaModel::all()
        // NamaModel sesuaikan dengan data apa yang mau dimunculin
        // simplepaginate() : membuat pagination dengan jumlah data 5 per halaman
        // where('nama_field_migration', 'operator', 'value') : mencari
        // operator -> =, <, >, <=, >=, !=, like
        // % depan : belakang
        // % belakang : depan
        // % belakang & atas ; depan/bwlakang/tenagh
        // OrderBy : mengurutkan berdasarkan field/ column migration tertentu
        // ASC : ascending (kecil ke besar)
        // DESC : descending (besar ke kecil)
        $bengkels = bengkel::where('name', 'like', '%'.$request->search.'%')->orderBy('name', 'asc')->simplePaginate(5);
        // compact : mengirimkan data ke blade compact('namavariable')
        return view('bengkel.index', compact('bengkels'));
        // dd($bengkels);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('bengkel.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validasi data agar pengguna mengisi input form ga asal asalan
        // required : wajib diisi input yang namenya itu
        $request->validate([
            'type'=>'required',
            'name'=>'required',
            'price'=>'required | numeric',
            'stock'=>'required | numeric',
        ], [
                'type.required'=>'Jenis Obat harus diisi!',
                'name.required'=>'Nama Item harus diisi!',
                'price.required'=>'Harga Item harus diisi!',
                'stock.required'=>'Stock Item harus diisi!',
        ]);
            // menambahkan data ke database
            // name_field_migration => $request->name_input_form
            $proses = bengkel::create([
                'type' => $request->type,
                'name' => $request->name,
                'price' => $request->price,
                'stock' => $request->stock
            ]);
            // jika bengkel::create berhasil (if), jika gagal (else)
            if ($proses) {
                return redirect()->route('bengkels')->with('success', 'Data Obat berhasil ditambahkan');
            } else {
                return redirect()->route('bengkels.add')->with('failed', 'Data Obat gagal ditambahkan');
            }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Ambil data obat yang mau di edit sesuai dengan id {id}
        // Gunakan metode where() untuk mencari data berdasarkan id
        // Metode first() digunakan untuk mengambil data pertama (satu data yang diambil)
        $bengkels = bengkel::where('id', $id)->first();
    
        // Kembalikan view edit bengkel dengan data obat yang sudah diambil
        // Gunakan metode compact() untuk mengirimkan data ke view
        // 'bengkels' adalah nama variabel yang akan digunakan di view
        return view('bengkel.edit', compact('bengkels'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi data agar pengguna mengisi input form dengan benar
        // Required: wajib diisi input yang namenya itu
        $request->validate([
            'type' => 'required', // Jenis obat harus diisi
            'name' => 'required', // Nama obat harus diisi
            'price' => 'required', // Harga obat harus diisi
            'stock' => 'required', // Stock obat harus diisi
        ], [
            'type.required' => 'Jenis Item harus diisi!',
            'name.required' => 'Nama Item harus diisi!',
            'price.required' => 'Harga Item harus diisi!',
            'stock.required' => 'Stock Item harus diisi!',
        ]);
    
        // Cari data obat sebelumnya berdasarkan ID
        $bengkelBefore = bengkel::where('id', $id)->first();
    
        // Cek apakah stock baru kurang dari stock sebelumnya
        if ((int)$request->stock < (int)$bengkelBefore->stock) {
            // Jika kurang, redirect ke halaman sebelumnya dengan pesan gagal
            return redirect()->back()->with('failed', 'Stock Baru Tidak Boleh Kurang Dari Stok Sebelumnya!');
        }
    
        // Proses update data obat
        $proses = $bengkelBefore->update([
            'type' => $request->type, // Update jenis obat
            'name' => $request->name, // Update nama obat
            'price' => $request->price, // Update harga obat
            'stock' => $request->stock // Update stock obat
        ]);
    
        // Cek apakah proses update berhasil
        if ($proses) {
            // Jika berhasil, redirect ke halaman bengkels dengan pesan sukses
            return redirect()->route('bengkels')->with('success', 'Data Obat berhasil ditambahkan');
        } else {
            // Jika gagal, redirect ke halaman bengkels.add dengan pesan gagal
            return redirect()->route('bengkels.add')->with('failed', 'Data Obat gagal ditambahkan');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // mencari data yang akan di hapus dengan where, lalu hapus dengan delete()
        $proses = bengkel::where('id', $id)->delete();
        if ($proses) {
            // redirect() : kembali ke halaman sebelum destory dijalanin (halaman button delete berada)
            return redirect()->back()->with('success', 'Data Obat berhasil dihapus');
        } else {
            return redirect()->back()->with('failed', 'Data Obat gagal dihapus');
        }
    }
}
