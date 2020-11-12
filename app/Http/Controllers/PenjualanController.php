<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;

class PenjualanController extends Controller
{
    public function index()
    {
        $penjualan = Penjualan::limit(100)->get();
        return view('pages.penjualan.index', ['penjualan' => $penjualan]);
    }

    public function dataTablesPenjualan()
    {
        return datatables()->of(Penjualan::with("pelanggan", "divisi", "sales", "ekspedisi", "bank")->select("penjualan.*"))
            ->addColumn('nama_pelanggan', function ($penjual) {
                return $penjual->pelanggan ? $penjual->pelanggan->nama_pelanggan : "Anonymous";
            })
            ->addColumn('nama_divisi', function ($penjual) {
                return $penjual->divisi->nama;
            })
            ->addColumn('nama_sales', function ($penjual) {
                return $penjual->sales ? $penjual->sales->nama_sales : "Anonymous";
            })
            ->addColumn('nama_ekspedisi', function ($penjual) {
                return $penjual->ekspedisi ? $penjual->ekspedisi->nama_ekspedisi : "Anonymous";
            })
            ->addColumn('nama_bank', function ($penjual) {
                return $penjual->bank ? $penjual->bank->nama_bank : "Anonymous";
            })
            ->addColumn('grand_total_with_format', function ($penjual) {
                return "Rp. " . number_format($penjual->grand_total);
            })
            ->addColumn('status_lunas', function ($penjual) {
                return $penjual->status != 0 ? "Lunas" : "Belum Lunas";
            })
            ->toJson();
        // return datatables(Penjualan::select(["ID_penjualan", "nomor_penjualan"])->limit(10000)->get())->toJson();
    }
}
