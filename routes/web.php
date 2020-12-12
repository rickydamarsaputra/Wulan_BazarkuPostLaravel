<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\master\PelangganController;
use App\Http\Controllers\master\BankController;

use App\Models\User;

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
    return redirect()->route('login.view');
});

Route::prefix('/dashboard')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::prefix('/master')->group(function () {
        Route::prefix('/pelanggan')->group(function () {
            Route::get('/', [PelangganController::class, 'index'])->name('pelanggan.index');
        });
        Route::prefix('/bank')->group(function () {
            Route::get('/', [BankController::class, 'index'])->name('bank.index');
        });
    });
    Route::prefix('/penjualan')->group(function () {
        Route::get('/', [PenjualanController::class, 'index'])->name('penjualan.index');
        Route::get('/search/{idProduk}/{idPelanggan}', [PenjualanController::class, 'searchProduk'])->name('penjualan.produk.search');
        Route::get('/choose', [PenjualanController::class, 'chooseDivisi'])->name('penjualan.choose.divisi');
        Route::match(['get', 'post'], '/create', [PenjualanController::class, 'create'])->name('penjualan.create');
        Route::post('/submit', [PenjualanController::class, 'submitPenjualan'])->name('penjualan.submit');
        Route::get('/detail/{nomorPenjualan}', [PenjualanController::class, 'detailPenjualan'])->name('penjualan.detail');
        Route::get('/print/{nomorPenjualan}', [PenjualanController::class, 'printInvoice'])->name('penjualan.print.invoice');
        // Route::post('/create', [PenjualanController::class, 'create'])->name('penjualan.create');
    });
});

Route::prefix('/auth')->group(function () {
    Route::get('/login', [AuthController::class, 'loginView'])->name('login.view');
    Route::post('/login', [AuthController::class, 'loginProcess'])->name('login.process');
    Route::get('/reset/password', function () {
        $users = User::all();
        foreach ($users as $user) {
            $user->update([
                "password" => bcrypt("bazarku")
            ]);
        }
        return redirect('/');
    });
    Route::get('/profile', [AuthController::class, 'profileUser'])->name('profile.user.view');
    Route::post('/change/password', [AuthController::class, 'changeUserPassword'])->name('change.user.password');
    Route::get('/generate', [AuthController::class, 'randomPassword'])->name('generate.password');
});

Route::get('/data_tables_penjualan', [PenjualanController::class, 'dataTablesPenjualan'])->name('dataTables.penjualan');
