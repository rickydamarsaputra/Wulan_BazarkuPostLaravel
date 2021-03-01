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
use App\Models\PerkiraanAkuntansi;

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
        // $dateRangeExplode = explode(" ", $dateRange);
        // $dateFirst = $dateRangeExplode[0];
        // $dateLast = $dateRangeExplode[2];

        // if ($divisiId > 0 && $salesId > 0) {
        //     $penjualan = Penjualan::with(["penjualanDetail"])->whereIdDivisi($divisiId)->whereIdSales($salesId)->whereBetween("tanggal_input", [$dateFirst, $dateLast])->get(["nomor_penjualan", "pajak", "ongkir", "total", "diskon"]);
        //     $transaksiAkuntansi = TransaksiAkuntansi::whereIdDivisi($divisiId)->whereBetween("tanggal_transaksi", [$dateFirst, $dateLast])->get(["ID_perkiraan", "tipe_akun", "nominal", "ID_divisi"]);
        // } elseif ($divisiId > 0) {
        //     $penjualan = Penjualan::with(["penjualanDetail"])->whereIdDivisi($divisiId)->whereBetween("tanggal_input", [$dateFirst, $dateLast])->get(["nomor_penjualan", "pajak", "ongkir", "total", "diskon"]);
        //     $transaksiAkuntansi = TransaksiAkuntansi::whereIdDivisi($divisiId)->whereBetween("tanggal_transaksi", [$dateFirst, $dateLast])->get(["ID_perkiraan", "tipe_akun", "nominal", "ID_divisi"]);
        // } elseif ($salesId > 0) {
        //     $penjualan = Penjualan::with(["penjualanDetail"])->whereIdSales($salesId)->whereBetween("tanggal_input", [$dateFirst, $dateLast])->get(["nomor_penjualan", "pajak", "ongkir", "total", "diskon"]);
        //     $transaksiAkuntansi = TransaksiAkuntansi::whereBetween("tanggal_transaksi", [$dateFirst, $dateLast])->get(["ID_perkiraan", "tipe_akun", "nominal", "ID_divisi"]);
        // } else {
        //     $penjualan = Penjualan::with(["penjualanDetail"])->whereBetween("tanggal_input", [$dateFirst, $dateLast])->get(["nomor_penjualan", "pajak", "ongkir", "total", "diskon"]);
        //     $transaksiAkuntansi = TransaksiAkuntansi::whereBetween("tanggal_transaksi", [$dateFirst, $dateLast])->get(["ID_perkiraan", "tipe_akun", "nominal", "ID_divisi"]);
        // }

        // $divisi = Divisi::whereIdDivisi($divisiId)->first(["nama"]);
        // $pajak = 0;
        // $ongkirMasuk = 0;
        // $ongkir = 0;
        // $totalPenjualan = 0;
        // $retur = Retur::whereBetween("tanggal_input", [$dateFirst, $dateLast])->get(["nominal_retur", "HPP", "jenis_retur"]);
        // $returPenjualan = 0;
        // $returPembelian = 0;
        // $pindahDanaKeluar = 0;
        // $pindahDanaMasuk = 0;
        // $diskon = 0;
        // $pengeluaranDLL = 0;
        // $hppRetur = 0;
        // $hppPenjualan = 0;
        // $totalBeban = 0;
        // $labaUsaha = 0;
        // $semuaNominalTransaksiAkuntansi = 0;
        // $transaksiAkuntansiMasuk = 0;
        // $transaksiAkuntansiKeluar = 0;
        // $promosiIg = 0;
        // $promosiToped = 0;
        // $promosiShopee = 0;
        // $operasional = 0;
        // $gaji = 0;

        // foreach ($penjualan as $loopItem) {
        //     $pajak += $loopItem->pajak;
        //     // $ongkir += $loopItem->ongkir;
        //     $totalPenjualan += $loopItem->total;
        //     // $diskon += $loopItem->diskon;

        //     foreach ($loopItem["penjualanDetail"] as $loopItemDetail) {
        //         $hppPenjualan += $loopItemDetail->HPP;
        //     }
        // }

        // foreach ($retur as $loopItem) {
        //     if ($loopItem->jenis_retur == 1) {
        //         $returPembelian += $loopItem->nominal_retur;
        //     } else {
        //         $returPenjualan += $loopItem->nominal_retur;
        //     }
        //     $hppRetur += $loopItem->HPP;
        // }

        // foreach ($transaksiAkuntansi as $loopItem) {
        //     if ($loopItem->ID_perkiraan == 12) {
        //         $pindahDanaKeluar += $loopItem->nominal;
        //     } else if ($loopItem->ID_perkiraan == 17) {
        //         $ongkirMasuk += $loopItem->nominal;
        //     } else if ($loopItem->ID_perkiraan == 11) {
        //         $pindahDanaMasuk += $loopItem->nominal;
        //     } else if ($loopItem->ID_perkiraan == 2) {
        //         $ongkir += $loopItem->nominal;
        //     } else if ($loopItem->ID_perkiraan == 3) {
        //         $promosiIg += $loopItem->nominal;
        //     } else if ($loopItem->ID_perkiraan == 4) {
        //         $promosiToped += $loopItem->nominal;
        //     } else if ($loopItem->ID_perkiraan == 5) {
        //         $promosiShopee += $loopItem->nominal;
        //     } else if ($loopItem->ID_perkiraan == 7) {
        //         $operasional += $loopItem->nominal;
        //     } else if ($loopItem->ID_perkiraan == 8) {
        //         $gaji += $loopItem->nominal;
        //     } else if ($loopItem->ID_perkiraan == 14) {
        //         $diskon += $loopItem->nominal;
        //     }

        //     if ($loopItem->tipe_akun == 1) {
        //         $transaksiAkuntansiMasuk += $loopItem->nominal;
        //     } else {
        //         $transaksiAkuntansiKeluar += $loopItem->nominal;
        //     }

        //     $semuaNominalTransaksiAkuntansi += $loopItem->nominal;
        // }

        // $hppPenjualan = $hppPenjualan - $hppRetur;
        // $totalPendapatan = $pajak + $ongkirMasuk + $transaksiAkuntansiMasuk + $totalPenjualan + $returPenjualan;
        // $totalBeban = $diskon + $hppPenjualan + $transaksiAkuntansiKeluar + $returPembelian;
        // $labaUsaha = $totalPendapatan - $totalBeban;

        // return response()->json([
        //     'divisi' => empty($divisi->nama) ? "Semua Divisi" : $divisi->nama,
        //     'pajak' => number_format($pajak),
        //     'ongkir_masuk' => number_format($ongkirMasuk),
        //     'ongkir' => number_format($ongkir),
        //     'total_penjualan' => number_format($totalPenjualan),
        //     'retur_penjualan' => number_format($returPenjualan),
        //     'retur_pembelian' => number_format($returPembelian),
        //     'transaksi_akuntansi_masuk' => number_format($transaksiAkuntansiMasuk),
        //     'transaksi_akuntansi_keluar' => number_format($transaksiAkuntansiKeluar),
        //     'total_pendapatan' => number_format($totalPendapatan),
        //     'pindah_dana_keluar' => number_format($pindahDanaKeluar),
        //     'pindah_dana_masuk' => number_format($pindahDanaMasuk),
        //     'diskon' => number_format($diskon),
        //     'promosi_ig' => number_format($promosiIg),
        //     'promosi_toped' => number_format($promosiToped),
        //     'promosi_shopee' => number_format($promosiShopee),
        //     'operasional' => number_format($operasional),
        //     'gaji' => number_format($gaji),
        //     'pengeluaran_dll' => number_format($pengeluaranDLL),
        //     'semua_nominal_transaksi_akuntansi' => number_format($semuaNominalTransaksiAkuntansi),
        //     'hpp_penjualan' => number_format($hppPenjualan),
        //     'total_beban' => number_format($totalBeban),
        //     'laba_usaha' => number_format($labaUsaha),
        //     'date_range' => $dateRange,
        // ]);

        // return [$divisiId, $salesId, $dateRange];
        $dateRangeExplode = explode(' ', $dateRange);
        $dateFirst = $dateRangeExplode[0];
        $dateLast = $dateRangeExplode[2];

        $divisi = Divisi::whereIdDivisi($divisiId)->first();
        $perkiraanAkuntansi = PerkiraanAkuntansi::get(['ID_perkiraan', 'kode_perkiraan', 'nama_akun', 'tipe_akun']);
        // if ($divisiId > 0 && $salesId > 0) {
        //     $penjualan =  Penjualan::with(['penjualanDetail'])->whereIdDivisi($divisiId)->whereIdSales($salesId)->whereBetween('tanggal_input', [$dateFirst, $dateLast])->get(['nomor_penjualan', 'total']);
        // } else if ($divisiId > 0 && $salesId == 0) {
        //     $penjualan =  Penjualan::with(['penjualanDetail'])->whereIdDivisi($divisiId)->whereBetween('tanggal_input', [$dateFirst, $dateLast])->get(['nomor_penjualan', 'total']);
        // } else if ($divisiId == 0 && $salesId > 0) {
        //     $penjualan =  Penjualan::with(['penjualanDetail'])->whereIdSales($salesId)->whereBetween('tanggal_input', [$dateFirst, $dateLast])->get(['nomor_penjualan', 'total']);
        // } else if ($divisiId == 0 && $salesId == 0) {
        //     $penjualan =  Penjualan::with(['penjualanDetail'])->whereBetween('tanggal_input', [$dateFirst, $dateLast])->get(['nomor_penjualan', 'total']);
        // }
        $penjualan =  Penjualan::with(['penjualanDetail'])->whereBetween('tanggal_input', [$dateFirst, $dateLast]);

        if ($divisiId != 0) {
            $penjualan->whereIdDivisi($divisiId);
        }
        if ($salesId != 0) {
            $penjualan->whereIdSales($salesId);
        }

        $retur = Retur::whereBetween('tanggal_input', [$dateFirst, $dateLast]);
        $labaRugiTransaksiAkuntansi = [];
        $totalPenjualan = 0;
        $returPenjualan = 0;
        $returPembelian = 0;
        $pemasukan = [];
        $pengeluaran = [];
        $totalPemasukan = 0;
        $totalPengeluaran = 0;
        $hppPenjualanDetail = 0;
        $hppRetur = 0;

        foreach ($penjualan->get(['nomor_penjualan', 'total']) as $loopItem) {
            $totalPenjualan += $loopItem->total;

            foreach ($loopItem['penjualanDetail'] as $loopItem) {
                $hppPenjualanDetail += $loopItem->HPP;
            }
        }

        if ($divisiId != 0) {
            $retur->whereIdDivisi($divisiId);
        }
        foreach ($retur->get(['jenis_retur', 'nominal_retur', 'HPP']) as $loopItem) {
            if ($loopItem->jenis_retur == 1) {
                $returPembelian += $loopItem->nominal_retur;
            } else {
                $returPenjualan += $loopItem->nominal_retur;
            }

            $hppRetur += $loopItem->HPP;
        }

        $counter = 0;
        foreach ($perkiraanAkuntansi as $loopItem) {
            array_push($labaRugiTransaksiAkuntansi, [
                'nama_transaksi' => $loopItem->nama_akun,
                'kode' => $loopItem->kode_perkiraan,
                'tipe_akun' => $loopItem->tipe_akun,
            ]);

            $nominalTransaksiAkuntansi = 0;
            $transaksiAkuntansi = TransaksiAkuntansi::whereBetween('tanggal_transaksi', [$dateFirst, $dateLast])->whereIdPerkiraan($loopItem->ID_perkiraan);
            if ($divisiId != 0) {
                $transaksiAkuntansi->whereIdDivisi($divisiId);
            }
            foreach ($transaksiAkuntansi->get(['nominal']) as $loopItem) {
                $nominalTransaksiAkuntansi += $loopItem->nominal;
            }

            $labaRugiTransaksiAkuntansi[$counter]['nominal'] = $nominalTransaksiAkuntansi;

            $counter++;
        }

        foreach ($labaRugiTransaksiAkuntansi as $loopItem) {
            if ($loopItem['tipe_akun'] == 1) {
                array_push($pemasukan, $loopItem);
                $totalPemasukan += $loopItem['nominal'];
            } else {
                array_push($pengeluaran, $loopItem);
                $totalPengeluaran += $loopItem['nominal'];
            }
        }
        $hpp = $hppPenjualanDetail - $hppRetur;
        $labaUsaha = ($totalPemasukan + $totalPenjualan + $returPembelian) - ($totalPengeluaran + $returPenjualan + $hpp);

        return view('pages.report.laba.template', [
            'divisi' => $divisi,
            'pemasukan' => $pemasukan,
            'pengeluaran' => $pengeluaran,
            'totalPemasukan' => $totalPemasukan + $totalPenjualan + $returPembelian,
            'totalPengeluaran' => $totalPengeluaran + $returPenjualan + $hpp,
            'totalPenjualan' => $totalPenjualan,
            'returPenjualan' => $returPenjualan,
            'returPembelian' => $returPembelian,
            'hpp' => $hpp,
            'labaUsaha' => $labaUsaha,
            'dateFirst' => $dateFirst,
            'dateLast' => $dateLast,
        ]);
    }
}
