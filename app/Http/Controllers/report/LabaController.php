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

        // $penjualan = Penjualan::with(["penjualanDetail"])->whereIdDivisi($divisiId)->whereIdSales($salesId)->whereBetween("tanggal_input", [$dateFirst, $dateLast])->get(["nomor_penjualan", "pajak", "ongkir", "total", "diskon"]);
        // $transaksiAkuntansi = TransaksiAkuntansi::with(["perkiraanAkuntansi", "divisi"])->whereIdDivisi($divisiId)->whereBetween("tanggal_transaksi", [$dateFirst, $dateLast])->get(["ID_perkiraan", "tipe_akun", "nominal", "ID_divisi"]);
        if ($divisiId > 0 && $salesId > 0) {
            $penjualan = Penjualan::with(["penjualanDetail"])->whereIdDivisi($divisiId)->whereIdSales($salesId)->whereBetween("tanggal_input", [$dateFirst, $dateLast])->get(["nomor_penjualan", "pajak", "ongkir", "total", "diskon"]);
            $transaksiAkuntansi = TransaksiAkuntansi::whereIdDivisi($divisiId)->whereBetween("tanggal_transaksi", [$dateFirst, $dateLast])->get(["ID_perkiraan", "tipe_akun", "nominal", "ID_divisi"]);
        } elseif ($divisiId > 0) {
            $penjualan = Penjualan::with(["penjualanDetail"])->whereIdDivisi($divisiId)->whereBetween("tanggal_input", [$dateFirst, $dateLast])->get(["nomor_penjualan", "pajak", "ongkir", "total", "diskon"]);
            $transaksiAkuntansi = TransaksiAkuntansi::whereIdDivisi($divisiId)->whereBetween("tanggal_transaksi", [$dateFirst, $dateLast])->get(["ID_perkiraan", "tipe_akun", "nominal", "ID_divisi"]);
        } elseif ($salesId > 0) {
            $penjualan = Penjualan::with(["penjualanDetail"])->whereIdSales($salesId)->whereBetween("tanggal_input", [$dateFirst, $dateLast])->get(["nomor_penjualan", "pajak", "ongkir", "total", "diskon"]);
            $transaksiAkuntansi = TransaksiAkuntansi::whereBetween("tanggal_transaksi", [$dateFirst, $dateLast])->get(["ID_perkiraan", "tipe_akun", "nominal", "ID_divisi"]);
        } else {
            $penjualan = Penjualan::with(["penjualanDetail"])->whereBetween("tanggal_input", [$dateFirst, $dateLast])->get(["nomor_penjualan", "pajak", "ongkir", "total", "diskon"]);
            $transaksiAkuntansi = TransaksiAkuntansi::whereBetween("tanggal_transaksi", [$dateFirst, $dateLast])->get(["ID_perkiraan", "tipe_akun", "nominal", "ID_divisi"]);
        }

        $divisi = Divisi::whereIdDivisi($divisiId)->first(["nama"]);
        $pajak = 0;
        $ongkir = 0;
        $totalPenjualan = 0;
        $retur = Retur::whereBetween("tanggal_input", [$dateFirst, $dateLast])->get(["nominal_retur", "HPP", "jenis_retur"]);
        $returPenjualan = 0;
        $returPembelian = 0;
        $pindahDanaKeluar = 0;
        $diskon = 0;
        $pengeluaranDLL = 0;
        $hppRetur = 0;
        $hppPenjualan = 0;
        $totalBeban = 0;
        $labaUsaha = 0;
        $semuaNominalTransaksiAkuntansi = 0;
        $transaksiAkuntansiMasuk = 0;
        $transaksiAkuntansiKeluar = 0;

        foreach ($penjualan as $loopItem) {
            $pajak += $loopItem->pajak;
            $ongkir += $loopItem->ongkir;
            $totalPenjualan += $loopItem->total;
            $diskon += $loopItem->diskon;

            foreach ($loopItem["penjualanDetail"] as $loopItemDetail) {
                $hppPenjualan += $loopItemDetail->HPP;
            }
        }

        foreach ($retur as $loopItem) {
            if ($loopItem->jenis_retur == 1) {
                $returPembelian += $loopItem->nominal_retur;
            } else {
                $returPenjualan += $loopItem->nominal_retur;
            }
            $hppRetur += $loopItem->HPP;
        }

        foreach ($transaksiAkuntansi as $loopItem) {
            if ($loopItem->ID_perkiraan == 12) {
                $pindahDanaKeluar += $loopItem->nominal;
            } else if ($loopItem->ID_perkiraan == 19) {
                $pengeluaranDLL += $loopItem->nominal;
            }

            if ($loopItem->tipe_akun == 1) {
                $transaksiAkuntansiMasuk += $loopItem->nominal;
            } else {
                $transaksiAkuntansiKeluar += $loopItem->nominal;
            }

            $semuaNominalTransaksiAkuntansi += $loopItem->nominal;
        }

        $hppPenjualan = $hppPenjualan - $hppRetur;
        $totalPendapatan = $pajak + $ongkir + $transaksiAkuntansiMasuk + $totalPenjualan + $returPenjualan;
        $totalBeban = $diskon + $hppPenjualan + $transaksiAkuntansiKeluar + $returPembelian;
        $labaUsaha = $totalPendapatan - $totalBeban;

        return response()->json([
            'divisi' => empty($divisi->nama) ? "Semua Divisi" : $divisi->nama,
            'pajak' => number_format($pajak),
            'ongkir' => number_format($ongkir),
            'total_penjualan' => number_format($totalPenjualan),
            'retur_penjualan' => number_format($returPenjualan),
            'retur_pembelian' => number_format($returPembelian),
            'transaksi_akuntansi_masuk' => number_format($transaksiAkuntansiMasuk),
            'transaksi_akuntansi_keluar' => number_format($transaksiAkuntansiKeluar),
            'total_pendapatan' => number_format($totalPendapatan),
            'pindah_dana_keluar' => number_format($pindahDanaKeluar),
            'diskon' => number_format($diskon),
            'pengeluaran_dll' => number_format($pengeluaranDLL),
            'semua_nominal_transaksi_akuntansi' => number_format($semuaNominalTransaksiAkuntansi),
            'hpp_penjualan' => number_format($hppPenjualan),
            'total_beban' => number_format($totalBeban),
            'laba_usaha' => number_format($labaUsaha),
            'date_range' => $dateRange,
        ]);
    }
}
