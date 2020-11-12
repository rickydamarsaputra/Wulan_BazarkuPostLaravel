<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;

class PenjualanController extends Controller
{
    public function index()
    {
        $penjualan = Penjualan::select("total", "ongkir", "diskon", "pajak", "grand_total")->get();
        $totalNilai = 0;
        $totalOngkir = 0;
        $totalDiskon = 0;
        $totalPajak = 0;
        $totalGrandTotal = 0;
        foreach ($penjualan as $penjual) {
            $totalNilai += $penjual->total;
            $totalOngkir += $penjual->ongkir;
            $totalDiskon += $penjual->diskon;
            $totalPajak += $penjual->pajak;
            $totalGrandTotal += $penjual->grand_total;
        }
        return view('pages.penjualan.index', [
            'totalNilai' => $totalNilai,
            'totalOngkir' => $totalOngkir,
            'totalDiskon' => $totalDiskon,
            'totalPajak' => $totalPajak,
            'totalGrandTotal' => $totalGrandTotal,
        ]);
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
