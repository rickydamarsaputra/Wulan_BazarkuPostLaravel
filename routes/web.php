<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\master\PelangganController;
use App\Http\Controllers\master\BankController;
use App\Http\Controllers\master\DivisiController;
use App\Http\Controllers\master\EkspedisiController;
use App\Http\Controllers\master\PerkiraanAkuntansiController;
use App\Http\Controllers\master\SalesController;
use App\Http\Controllers\master\SupplierController;
use App\Http\Controllers\PembelianController as ControllersPembelianController;
use App\Http\Controllers\PindahDanaController;
use App\Http\Controllers\report\LabaController;
use App\Http\Controllers\report\PembelianController;
use App\Http\Controllers\report\PenjualanController as ReportPenjualanController;
use App\Http\Controllers\report\ProdukTerlarisController;
use App\Http\Controllers\report\ReturPenjualanController;
use App\Http\Controllers\report\StokProdukController;
use App\Http\Controllers\report\StokProdukLengkapController;
use App\Http\Controllers\TransaksiAkuntansiController;
use App\Models\Role;
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

Route::prefix('dashboard')->middleware('auth')->group(function () {
    // dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

    // master
    Route::prefix('master')->middleware('admin')->group(function () {
        Route::prefix('bank')->group(function () {
            Route::get('/', [BankController::class, 'index'])->name('bank.index');
            Route::get('/create', [BankController::class, 'createView'])->name('bank.create.view');
            Route::post('/create', [BankController::class, 'createProcess'])->name('bank.create.process');
            Route::get('/update/{bankId}', [BankController::class, 'updateView'])->name('bank.update.view');
            Route::put('/update/{bankId}', [BankController::class, 'updateProcess'])->name('bank.update.process');
            Route::delete('/delete/{bankId}', [BankController::class, 'delete'])->name('bank.delete');
        });

        Route::prefix('divisi')->group(function () {
            Route::get('/', [DivisiController::class, 'index'])->name('divisi.index');
            Route::get('/create', [DivisiController::class, 'createView'])->name('divisi.create.view');
            Route::post('/create', [DivisiController::class, 'createProcess'])->name('divisi.create.process');
            Route::get('/update/{divisiId}', [DivisiController::class, 'updateView'])->name('divisi.update.view');
            Route::put('/update/{divisiId}', [DivisiController::class, 'updateProcess'])->name('divisi.update.process');
            Route::delete('/delete/{divisiId}', [DivisiController::class, 'delete'])->name('divisi.delete');
        });

        Route::prefix('sales')->group(function () {
            Route::get('/', [SalesController::class, 'index'])->name('sales.index');
            Route::get('/create', [SalesController::class, 'createView'])->name('sales.create.view');
            Route::post('/create', [SalesController::class, 'createProcess'])->name('sales.create.process');
            Route::get('/update/{salesId}', [SalesController::class, 'updateView'])->name('sales.update.view');
            Route::put('/update/{salesId}', [SalesController::class, 'updateProcess'])->name('sales.update.process');
            Route::delete('/delete/{salesId}', [SalesController::class, 'delete'])->name('sales.delete');
        });

        Route::prefix('ekspedisi')->group(function () {
            Route::get('/', [EkspedisiController::class, 'index'])->name('ekspedisi.index');
            Route::get('/create', [EkspedisiController::class, 'createView'])->name('ekspedisi.create.view');
            Route::post('/create', [EkspedisiController::class, 'createProcess'])->name('ekspedisi.create.process');
            Route::get('/update/{ekspedisiId}', [EkspedisiController::class, 'updateView'])->name('ekspedisi.update.view');
            Route::put('/update/{ekspedisiId}', [EkspedisiController::class, 'updateProcess'])->name('ekspedisi.update.process');
            Route::delete('/delete/{ekspedisiId}', [EkspedisiController::class, 'delete'])->name('ekspedisi.delete');
        });

        Route::prefix('perkiraan-akuntansi')->group(function () {
            Route::get('/', [PerkiraanAkuntansiController::class, 'index'])->name('perkiraan.akuntansi.index');
            Route::get('/create', [PerkiraanAkuntansiController::class, 'createView'])->name('perkiraan.akuntansi.create.view');
            Route::post('/create', [PerkiraanAkuntansiController::class, 'createProcess'])->name('perkiraan.akuntansi.create.process');
            Route::get('/update/{perkiraanId}', [PerkiraanAkuntansiController::class, 'updateView'])->name('perkiraan.akuntansi.update.view');
            Route::put('/update/{perkiraanId}', [PerkiraanAkuntansiController::class, 'updateProcess'])->name('perkiraan.akuntansi.update.process');
            Route::delete('/delete/{perkiraanId}', [PerkiraanAkuntansiController::class, 'delete'])->name('perkiraan.akuntansi.delete');
        });

        Route::prefix('supplier')->group(function () {
            Route::get('/', [SupplierController::class, 'index'])->name('supplier.index');
            Route::get('/create', [SupplierController::class, 'createView'])->name('supplier.create.view');
            Route::post('/create', [SupplierController::class, 'createProcess'])->name('supplier.create.process');
            Route::get('/update/{supplierId}', [SupplierController::class, 'updateView'])->name('supplier.update.view');
            Route::put('/update/{supplierId}', [SupplierController::class, 'updateProcess'])->name('supplier.update.process');
            Route::delete('/delete/{supplierId}', [SupplierController::class, 'delete'])->name('supplier.delete');
        });

        Route::prefix('pelanggan')->group(function () {
            Route::get('/', [PelangganController::class, 'index'])->name('pelanggan.index');
            Route::get('/create', [PelangganController::class, 'createView'])->name('pelanggan.create.view');
            Route::post('/create', [PelangganController::class, 'createProcess'])->name('pelanggan.create.process');
            Route::delete('/delete/{pelangganId}', [PelangganController::class, 'delete'])->name('pelanggan.delete');
        });
    });

    // penjualan
    Route::prefix('penjualan')->group(function () {
        Route::middleware('admin')->group(function () {
            Route::get('/', [PenjualanController::class, 'index'])->name('penjualan.index');
            Route::get('/choose', [PenjualanController::class, 'chooseDivisi'])->name('penjualan.choose.divisi');
            Route::post('/submit', [PenjualanController::class, 'submitPenjualan'])->name('penjualan.submit');
            Route::get('/detail/{nomorPenjualan}', [PenjualanController::class, 'detailPenjualan'])->name('penjualan.detail');
        });
        Route::get('/print/{nomorPenjualan}', [PenjualanController::class, 'printInvoice'])->name('penjualan.print.invoice');
        Route::match(['get', 'post'], '/create', [PenjualanController::class, 'create'])->name('penjualan.create');
    });

    // pembelian
    Route::prefix('pembelian')->group(function () {
        Route::get('/', [ControllersPembelianController::class, 'index'])->name('pembelian.index');
        Route::get('/choose', [ControllersPembelianController::class, 'chooseDivisi'])->name('pembelian.choose.divisi');
        Route::match(['get', 'post'], '/create', [ControllersPembelianController::class, 'chooseSubmit'])->name('pembelian.choose.submit');
        Route::post('/submit', [ControllersPembelianController::class, 'pembelianSubmit'])->name('pembelian.submit');
        Route::get('/{nomorPembelian}', [ControllersPembelianController::class, 'detail'])->name('pembelian.detail');
        Route::get('/print/{nomorPembelian}', [ControllersPembelianController::class, 'print'])->name('pembelian.print.invoice');
    });

    // transaksi akuntansi
    Route::prefix('transaksi-akuntansi')->group(function () {
        Route::get('/', [TransaksiAkuntansiController::class, 'index'])->name('transaksi.akuntansi.index');
        Route::get('/create', [TransaksiAkuntansiController::class, 'createView'])->name('transaksi.akuntansi.create.view');
        Route::post('/create', [TransaksiAkuntansiController::class, 'createProcess'])->name('transaksi.akuntansi.create.process');
        Route::delete('/{idTransaksi}', [TransaksiAkuntansiController::class, 'delete'])->name('transaksi.akuntansi.delete');
    });

    // pindah dana
    Route::prefix('pindah-dana')->group(function () {
        Route::get('/create', [PindahDanaController::class, 'createView'])->name('pindah.dana.create.view');
        Route::post('/create', [PindahDanaController::class, 'createProcess'])->name('pindah.dana.create.process');
    });

    // report
    Route::prefix('report')->group(function () {
        Route::prefix('stok-produk')->group(function () {
            Route::get('/', [StokProdukController::class, 'index'])->name('report.stok-produk.index');
        });

        Route::prefix('pembelian')->group(function () {
            Route::get('/', [PembelianController::class, 'index'])->name('report.pembelian.index');
        });

        Route::prefix('penjualan')->group(function () {
            Route::get('/', [ReportPenjualanController::class, 'index'])->name('report.penjualan.index');
        });

        Route::prefix('retur-penjualan')->group(function () {
            Route::get('/', [ReturPenjualanController::class, 'index'])->name('report.retur-penjualan.index');
        });

        Route::prefix('laba')->group(function () {
            Route::get('/', [LabaController::class, 'index'])->name('report.laba.index');
        });

        Route::prefix('produk-terlaris')->group(function () {
            Route::get('/', [ProdukTerlarisController::class, 'index'])->name('report.produk.terlaris.index');
        });

        Route::prefix('stok-produk-lengkap')->group(function () {
            Route::get('/', [StokProdukLengkapController::class, 'index'])->name('report.stok-produk-lengkap.index');
        });
    });
});

Route::prefix('auth')->group(function () {
    Route::get('/login', [AuthController::class, 'loginView'])->name('login.view');
    Route::post('/login', [AuthController::class, 'loginProcess'])->name('login.process');
    Route::get('/profile', [AuthController::class, 'profileUser'])->name('profile.user.view');
    Route::post('/change/password', [AuthController::class, 'changeUserPassword'])->name('change.user.password');
    Route::get('/generate', [AuthController::class, 'randomPassword'])->name('generate.password');
    Route::get('/reset/password', [AuthController::class, 'resetPassword']);
    Route::get('/logout', [AuthController::class, 'logoutUser'])->name('logout.user');
});

Route::prefix('helpers')->group(function () {
    Route::get('/search/produk/{idProduk}/{idPelanggan}', [PenjualanController::class, 'searchProduk'])->name('helpers.search.produk');
    Route::get('/laba/filter/{divisiId}/{salesId}/{dateRange}', [LabaController::class, 'filter'])->name('helpers.laba.filter');
    Route::get('/pembelian/{supplierId}/{divisiId}/{bankId}/{status}/{dateRange}', [PembelianController::class, 'countPembelianInfo'])->name('helpers.pembelian.count');
    Route::get('/penjualan/{pelangganId}/{divisiId}/{salesId}/{ekspedisiId}/{bankId}/{status}/{dateRange}', [ReportPenjualanController::class, 'countPenjualanInfo'])->name('helpers.penjualan.count');

    Route::get('/perkiraan-akuntansi/filter/{tipeAkun}', [TransaksiAkuntansiController::class, 'filterPerkiraanAkuntansi'])->name('helpers.filter.perkiraan.akuntansi');
});

Route::prefix('datatables')->group(function () {
    Route::get('/penjualan', [PenjualanController::class, 'datatables'])->name('datatables.penjualan');
    Route::get('/transaksi-akuntansi/{tipeAkun}/{idPerkiraan}/{idDivisi}/{idBank}/{dateRange}', [TransaksiAkuntansiController::class, 'datatables'])->name('datatables.transaksi.akuntansi');
    Route::get('/pembelian/{idSupplier}/{idDivisi}/{idBank}/{statusLunas}/{dateRange}', [ControllersPembelianController::class, 'datatables'])->name('datatables.filter.pembelian');

    Route::prefix('report')->group(function () {
        Route::get('/pembelian/{supplierId}/{divisiId}/{bankId}/{status}/{dateRange}/{sortBy}/{sort}', [PembelianController::class, 'datatables'])->name('datatables.pembelian');
        Route::get('/stok-produk/{divisiId}/{sortBy}/{sort}', [StokProdukController::class, 'datatables'])->name('datatables.stok-produk');
        Route::get('/produk-terlaris/{divisiId}/{dateRange}', [ProdukTerlarisController::class, 'datatables'])->name('datatables.produk.terlaris');
        Route::get('/retur-penjualan/{dateRange}/{sortBy}/{sort}', [ReturPenjualanController::class, 'datatables'])->name('datatables.retur-penjualan');
        Route::get('/stok-produk-lengkap/{divisiId}/{sortBy}/{sort}', [StokProdukLengkapController::class, 'datatables'])->name('datatables.stok-produk-lengkap');
        Route::get('/penjualan/{pelangganId}/{divisiId}/{salesId}/{ekspedisiId}/{bankId}/{status}/{dateRange}', [ReportPenjualanController::class, 'datatables'])->name('datatables.report.penjualan');
    });

    Route::prefix('master')->group(function () {
        Route::get('/bank', [BankController::class, 'datatables'])->name('datatables.bank');
        Route::get('/divisi', [DivisiController::class, 'datatables'])->name('datatables.divisi');
        Route::get('/sales', [SalesController::class, 'datatables'])->name('datatables.sales');
        Route::get('/ekspedisi', [EkspedisiController::class, 'datatables'])->name('datatables.ekspedisi');
        Route::get('/perkiraan-akuntansi', [PerkiraanAkuntansiController::class, 'datatables'])->name('datatables.perkiraan.akuntansi');
        Route::get('/supplier', [SupplierController::class, 'datatables'])->name('datatables.supplier');
        Route::get('/pelanggan', [PelangganController::class, 'datatables'])->name('datatables.pelanggan');
    });
});
