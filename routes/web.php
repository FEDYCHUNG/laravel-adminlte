<?php

use App\Http\Controllers\MasterBarangController;
use App\Http\Controllers\PenjualanController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::middleware(['auth'])->group(function () {
    //================================== Master Barang
    Route::get('/master_barang/get_master_barang', [MasterBarangController::class, 'getMasterBarang'])->name('master_barang.get_master_barang');
    Route::resource('/master_barang', MasterBarangController::class);

    //================================== Penjualan
    Route::get('/penjualan/get_penjualan', [PenjualanController::class, 'getPenjualan'])->name('penjualan.get_penjualan');
    Route::resource('/penjualan', PenjualanController::class);
});
