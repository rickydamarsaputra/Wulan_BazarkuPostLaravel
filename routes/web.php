<?php

use App\Http\Controllers\PenjualanController;
use Illuminate\Support\Facades\Route;

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

Route::get('/penjualan', [PenjualanController::class, 'index'])->name('penjualan.index');
Route::get('/data_tables_penjualan', [PenjualanController::class, 'dataTablesPenjualan'])->name('dataTables.penjualan');
