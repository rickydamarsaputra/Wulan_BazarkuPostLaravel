<?php

namespace App\Http\Controllers\report;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\Divisi;
use App\Models\Ekspedisi;
use App\Models\Pelanggan;
use App\Models\Penjualan;
use App\Models\Sales;
use Illuminate\Http\Request;
use DataTables;

class PenjualanController extends Controller
{
    public function index()
    {
        $pelanggan = Pelanggan::cursor()->filter(function ($pelang) {
            return $pelang->status_mitra != 6;
        });
        $sales = Sales::all();
        $ekspedisi = Ekspedisi::all();
        $divisi = Divisi::all();
        $bank = Bank::all();

        return view('pages.report.penjualan.index', [
            'pelanggan' => $pelanggan,
            'sales' => $sales,
            'ekspedisi' => $ekspedisi,
            'divisi' => $divisi,
            'bank' => $bank
        ]);
    }

    public function countPenjualanInfo($pelangganId, $divisiId, $salesId, $ekspedisiId, $bankId, $status, $dateRange)
    {
        $dateExplode = explode(' ', $dateRange);
        $dateFirst = $dateExplode[0];
        $dateEnd = $dateExplode[2];
        $getColumn = ['total', 'diskon', 'ongkir', 'pajak', 'grand_total'];
        $penjualan = Penjualan::whereIdDivisi($divisiId)->whereIdSales($salesId)->whereStatusPembayaran($status)->whereBetween('tanggal_jual', [$dateFirst, $dateEnd])->get($getColumn);
        $totalNilai = 0;
        $totalOngkosKirim = 0;
        $totalDiskon = 0;
        $totalPajak = 0;
        $totalGrandTotal = 0;

        foreach ($penjualan as $loopItem) {
            $totalNilai += $loopItem->total;
            $totalOngkosKirim += $loopItem->ongkir;
            $totalDiskon += $loopItem->diskon;
            $totalPajak += $loopItem->pajak;
            $totalGrandTotal = $loopItem->grand_total;
        }

        return response()->json([
            'total_nilai' => $totalNilai,
            'total_ongkos_kirim' => $totalOngkosKirim,
            'total_diskon' => $totalDiskon,
            'total_pajak' => $totalPajak,
            'total_grand_total' => $totalGrandTotal
        ]);
    }

    public function datatables($pelangganId, $divisiId, $salesId, $ekspedisiId, $bankId, $status, $dateRange)
    {
        $dateExplode = explode(' ', $dateRange);
        $dateFirst = $dateExplode[0];
        $dateEnd = $dateExplode[2];
        $getColumn = ['tanggal_jual', 'nomor_penjualan', 'ID_divisi', 'ID_sales', 'ID_ekspedisi', 'ID_bank', 'total', 'diskon', 'ongkir', 'pajak', 'grand_total', 'sudah_bayar', 'status_pembayaran'];
        $penjualan = Penjualan::with(['divisi', 'sales', 'ekspedisi', 'bank'])->whereIdDivisi($divisiId)->whereIdSales($salesId)->whereStatusPembayaran($status)->whereBetween('tanggal_jual', [$dateFirst, $dateEnd])->get($getColumn);

        return DataTables::of($penjualan)
            ->addIndexColumn()
            ->toJson();
    }
}
