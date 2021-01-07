<?php

namespace App\Http\Controllers\report;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\Divisi;
use App\Models\Pembelian;
use App\Models\Supplier;
use Illuminate\Http\Request;
use DataTables;

class PembelianController extends Controller
{
    public function index()
    {
        $supplier = Supplier::get(['ID_supplier', 'nama']);
        $divisi = Divisi::get(['ID_divisi', 'nama']);
        $bank = Bank::get(['ID_bank', 'nama_bank']);

        return view('pages.report.pembelian.index', [
            'supplier' => $supplier,
            'divisi' => $divisi,
            'bank' => $bank
        ]);
    }

    public function countPembelianInfo($supplierId, $divisiId, $bankId, $status, $dateRange)
    {
        $dateExplode = explode(' ', $dateRange);
        $dateStart = $dateExplode[0];
        $dateEnd = $dateExplode[2];
        $getColumn = ['ID_bank', 'total', 'diskon', 'pajak', 'grand_total'];
        $totalNilai = 0;
        $totalDiskon = 0;
        $totalPajak = 0;
        $totalGrandTotal = 0;

        $pembelian = Pembelian::whereIdSupplier($supplierId)->whereIdDivisi($divisiId)->whereStatusPembayaran($status)->whereBetween('tanggal_beli', [$dateStart, $dateEnd])->get($getColumn);
        // $pembelian = Pembelian::whereIdSupplier($supplierId)->whereIdDivisi($divisiId)->whereIdBank($bankId)->whereStatusPembayaran($status)->whereBetween('tanggal_beli', [$dateStart, $dateEnd])->get($getColumn);

        foreach ($pembelian as $loopItem) {
            $totalNilai += $loopItem->total;
            $totalDiskon += $loopItem->diskon;
            $totalPajak += $loopItem->pajak;
            $totalGrandTotal += $loopItem->grand_total;
        }

        return response()->json([
            'total_nilai' => number_format($totalNilai),
            'total_diskon' => number_format($totalDiskon),
            'total_pajak' => number_format($totalPajak),
            'total_grand_total' => number_format($totalGrandTotal),
        ]);
    }

    public function datatables($supplierId, $divisiId, $bankId, $status, $dateRange, $sortBy, $sort)
    {
        $dateExplode = explode(' ', $dateRange);
        $dateStart = $dateExplode[0];
        $dateEnd = $dateExplode[2];
        $getColumn = ['ID_supplier', 'ID_divisi', 'ID_bank', 'ID_pembelian', 'tanggal_beli', 'nomor_pembelian', 'total', 'diskon', 'pajak', 'grand_total', 'sudah_bayar', 'status_pembayaran'];

        $pembelian = Pembelian::whereIdSupplier($supplierId)->whereIdDivisi($divisiId)->whereStatusPembayaran($status)->whereBetween('tanggal_beli', [$dateStart, $dateEnd])->get($getColumn);
        // $pembelian = Pembelian::whereIdSupplier($supplierId)->whereIdDivisi($divisiId)->whereIdBank($bankId)->whereStatusPembayaran($status)->whereBetween('tanggal_beli', [$dateStart, $dateEnd])->get($getColumn);
        // if (!$supplierId != 'Semua Supplier') {
        //     $pembelian = Pembelian::with(['supplier', 'divisi', 'bank'])->whereIdSupplier($supplierId)->whereBetween('tanggal_beli', [$dateStart, $dateEnd])->get($getColumn);
        // } else {
        //     $pembelian = Pembelian::with(['supplier', 'divisi', 'bank'])->whereBetween('tanggal_beli', [$dateStart, $dateEnd])->get($getColumn);
        // }

        // $pembelian = Pembelian::with(['supplier', 'divisi', 'bank'])->whereIdSupplier($supplierId)->whereIdDivisi($divisiId)->whereIdBank($bankId)->get($getColumn);
        // if ($supplierId != 'Semua Supplier' && $divisiId != 'Semua Divisi' && $bankId != 'Semua Bank') {
        //     $pembelian = Pembelian::with(['supplier', 'divisi', 'bank'])->whereIdSupplier($supplierId)->whereIdDivisi($divisiId)->whereIdBank($bankId)->get($getColumn);
        // } elseif ($supplierId != 'Semua Supplier' && $divisiId != 'Semua Divisi') {
        //     $pembelian = Pembelian::with(['supplier', 'divisi', 'bank'])->whereIdSupplier($supplierId)->whereIdDivisi($divisiId)->get($getColumn);
        // }
        return DataTables::of($pembelian)
            ->addIndexColumn()
            ->toJson();
    }
}
