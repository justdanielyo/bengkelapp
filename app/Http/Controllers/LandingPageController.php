<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     // menampilkan banyak data atau halaman awal
    public function index()
    {
        // view() : memanggil file blade di folder resources/views
        // tanda , digunakan untuk sub folder
        // gunakan kbab case
        return view('landing-page');
    }

    // menampilkan formulir untuk membuat data
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    // menyimpan data baru ke database
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    // menampilkan hanya satu data
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    // menampilkan formulir edit
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    // mengubah data ke database
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    // menghapus data ke database
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
