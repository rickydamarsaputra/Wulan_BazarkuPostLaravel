<?php

namespace App\Http\Controllers\report;

use App\Http\Controllers\Controller;
use App\Models\Divisi;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Retur;
use App\Models\Sales;
use App\Models\TransaksiAkuntansi;
use Illuminate\Http\Request;

class LabaController extends Controller
{
    public function index()
    {
        $divisi = Divisi::get();
        $sales = Sales::get();
        return view('pages.report.laba.index', [
            'divisi' => $divisi,
            'sales' => $sales
        ]);
    }

    public function filter($divisiId, $salesId, $dateRange)
    {
        $dateRangeExplode = explode(" ", $dateRange);
        $dateFirst = $dateRangeExplode[0];
        $dateLast = $dateRangeExplode[2];
        $penjualan = Penjualan::whereIdDivisi($divisiId)->whereIdSales($salesId)->whereBetween("tanggal_input", [$dateFirst, $dateLast])->get(["pajak", "ongkir", "total", "diskon"]);
        $transaksiAkuntansi = TransaksiAkuntansi::whereIdDivisi($divisiId)->whereBetween("tanggal_transaksi", [$dateFirst, $dateLast])->get(["ID_perkiraan", "nominal"]);
        $divisi = Divisi::findOrFail($divisiId);
        $pajak = 0;
        $ongkir = 0;
        $totalPenjualan = 0;
        $retur = Retur::whereBetween("tanggal_input", [$dateFirst, $dateLast])->whereJenisRetur(2)->get(["nominal_retur", "HPP"]);
        $nominalRetur = 0;
        $pindahDanaKeluar = 0;
        $diskon = 0;
        $pengeluaranDLL = 0;
        $hppRetur = 0;
        $hppPenjualan = 0;
        $totalBeban = 0;
        $labaUsaha = 0;

        foreach ($penjualan as $loopItem) {
            $pajak += $loopItem->pajak;
            $ongkir += $loopItem->ongkir;
            $totalPenjualan += $loopItem->total;
            $diskon += $loopItem->diskon;

            foreach ($loopItem->penjualanDetail as $loopItemDetail) {
                $hppPenjualan += $loopItemDetail->HPP;
            }
        }

        foreach ($retur as $loopItem) {
            $nominalRetur += $loopItem->nominal_retur;
            $hppRetur += $loopItem->HPP;
        }

        foreach ($transaksiAkuntansi as $loopItem) {
            if ($loopItem->ID_perkiraan == 12) {
                $pindahDanaKeluar += $loopItem->nominal;
            } else if ($loopItem->ID_perkiraan == 19) {
                $pengeluaranDLL += $loopItem->nominal;
            }
        }

        $hppPenjualan = $hppPenjualan - $hppRetur;
        $totalPendapatan = $pajak + $ongkir + $totalPenjualan + $nominalRetur;
        $totalBeban = $pindahDanaKeluar + $diskon + $pengeluaranDLL + $hppPenjualan;
        $labaUsaha = $totalPendapatan - $totalBeban;

        return response()->json([
            'divisi' => $divisi->nama,
            'pajak' => number_format($pajak),
            'ongkir' => number_format($ongkir),
            'total_penjualan' => number_format($totalPenjualan),
            'nominal_retur' => number_format($nominalRetur),
            'total_pendapatan' => number_format($totalPendapatan),
            'pindah_dana_keluar' => number_format($pindahDanaKeluar),
            'diskon' => number_format($diskon),
            'pengeluaran_dll' => number_format($pengeluaranDLL),
            'hpp_penjualan' => number_format($hppPenjualan),
            'total_beban' => number_format($totalBeban),
            'laba_usaha' => number_format($labaUsaha),
            'date_range' => $dateRange,
        ]);
    }
}
