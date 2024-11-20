<?php

use Illuminate\Support\Facades\Route;
// pemanggilan file controller
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\bengkelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::httpmethod('/url', [namaController::class, namaFunction])->name('nama_route);
// httpmethod :
// get -> mengambil data
// post -> menambah data
// parch/put -> mengubah data
// delete -> menghapus data
// /url dan name() harus beda/unique
//form
Route::middleware(['isGuest'])->group(function () {
    Route::get('/', [UserController::class, 'login'])->name('login');
    Route::post('/login/auth', [UserController::class, 'loginAuth'])->name('login.auth');
});
//Logout
Route::middleware(['isLogin'])->group(function () {
    //Logout
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');

    Route::middleware(['isAdmin'])->group(function () {
        // url : kebab case, name : snack case, controller&function : camel case
        Route::get('/landing-page', [LandingPageController::class, 'index'])->name('landing-page');
        // mengelola data bengkels
        Route::get('/bengkels', [bengkelController::class, 'index'])->name('bengkels');
        Route::get('/bengkels/add', [bengkelController::class, 'create'])->name('bengkels.add');
        Route::post('/bengkels/add', [bengkelController::class, 'store'])->name('bengkels.add.store');
        // {namaPathDinamis} : path dinamis, yang nilainya akan berubah-ubah (harus diisi ketika mengakses route) -> ketika akses di bladnya menjadi href="{{ route('nama_route', $isiPathDinamis) }}" atau action="{{route('nama_route', $isiPathDinamis)}}"
        //fungsi path dinamis : spesifikasi data yang akan diproses
        Route::delete('/bengkels/{id}', [bengkelController::class, 'destroy'])->name('bengkels.delete');
        // edit pake {id} karna perlu spesifikasi data mana mana yang mau diedit
        Route::get('/bengkels/edit/{id}', [bengkelController::class, 'edit'])->name('bengkels.edit');
        Route::patch('/bengkels/edit/{id}', [bengkelController::class, 'update'])->name('bengkels.edit.update');
        Route::put('/bengkels/update-stock/{id}', [bengkelController::class, 'stockEdit'])->name('bengkels.stock.update');
        //Login
        Route::get('/user', [UserController::class, 'index'])->name('user');
        Route::get('/user/create', [UserController::class, 'create'])->name('user.add');
        Route::post('/user/create', [UserController::class, 'store'])->name('user.add.store');
        Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.delete');
        Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
        Route::patch('user/edit/{id}', [UserController::class, 'update'])->name('user.edit.update');
        Route::get('/order/admin', [OrderController::class, 'indexAdmin'])->name('orders.admin');
        Route::get('/order/export/excel', [OrderController::class, 'exportExcel'])->name('orders.export-excel');
    });
    // url : kebab case, name : snack case, controller&function : camel case
    Route::get('/landing-page', [LandingPageController::class, 'index'])->name('landing-page');

    // mengelola data bengkels
    // Route::get('/bengkels', [bengkelController::class, 'index'])->name('bengkels');
    // Route::get('/bengkels/add', [bengkelController::class, 'create'])->name('bengkels.add');
    // Route::post('/bengkels/add', [bengkelController::class, 'store'])->name('bengkels.add.store');
    // // {namaPathDinamis} : path dinamis, yang nilainya akan berubah-ubah (harus diisi ketika mengakses route) -> ketika akses di bladnya menjadi href="{{ route('nama_route', $isiPathDinamis) }}" atau action="{{route('nama_route', $isiPathDinamis)}}"
    // //fungsi path dinamis : spesifikasi data yang akan diproses
    // Route::delete('/bengkels/{id}', [bengkelController::class, 'destroy'])->name('bengkels.delete');
    // // edit pake {id} karna perlu spesifikasi data mana mana yang mau diedit
    // Route::get('/bengkels/edit/{id}', [bengkelController::class, 'edit'])->name('bengkels.edit');
    // Route::patch('/bengkels/edit/{id}', [bengkelController::class, 'update'])->name('bengkels.edit.update');
    // Route::put('/bengkels/update-stock/{id}', [bengkelController::class, 'stockEdit'])->name('bengkels.stock.update');
    //Login
    // Route::get('/user', [UserController::class, 'index'])->name('user');
    // Route::get('/user/create', [UserController::class, 'create'])->name('user.add');
    // Route::post('/user/create', [UserController::class, 'store'])->name('user.add.store');
    // Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.delete');
    // Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    // Route::patch('user/edit/{id}', [UserController::class, 'update'])->name('user.edit.update');
    // Route::get('/order/create', [OrderController::class, 'create'])->name('order.create');
    Route::post('/order/store', [OrderController::class, 'store'])->name('orders.store');
    // struk pakai path dinamis {id} karna akan menampilkan 1 data spesifik pembelian. pake resources show karena sesuai dengan fungsinya, menampilkan 1 data spesifik
    Route::get('/order/struk/{id}', [OrderController::class, 'show'])->name('orders.show');
});
Route::middleware(['auth', 'isKasir'])->group(function () {
    Route::get('/order', [OrderController::class, 'index'])->name('orders');
    Route::get('/order/create', [OrderController::class, 'create'])->name('orders.create');
    // Route::post('/order/create', [OrderController::class, 'store'])->name('order.create.store');
    Route::get('/order/print/{id}', [OrderController::class, 'show'])->name('print');
    Route::get('/download/{id}', [OrderController::class, 'DownloadPDF'])->name('orders.download');
});
// Route::get('/order/create', [OrderController::class, 'create'])->name('order.create');
// Route::get('/order/struk/{id}', [OrderController::class, 'show'])->name('order.show');