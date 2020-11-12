<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\master\PelangganController;
use App\Http\Controllers\master\BankController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('/master')->group(function () {
    Route::prefix('/pelanggan')->group(function () {
        Route::get('/', [PelangganController::class, 'index'])->name('pelanggan.index');
    });
    Route::prefix('/bank')->group(function () {
        Route::get('/', [BankController::class, 'index'])->name('bank.index');
    });
});
Route::get('/penjualan', [PenjualanController::class, 'index'])->name('penjualan.index');
Route::get('/data_tables_penjualan', [PenjualanController::class, 'dataTablesPenjualan'])->name('dataTables.penjualan');
