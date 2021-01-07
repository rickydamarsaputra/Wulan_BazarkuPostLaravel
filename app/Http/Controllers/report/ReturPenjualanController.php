<?php

namespace App\Http\Controllers\report;

use App\Http\Controllers\Controller;
use App\Models\Divisi;
use App\Models\Retur;
use Illuminate\Http\Request;
use DataTables;

class ReturPenjualanController extends Controller
{
    public function index()
    {
        $divisi = Divisi::get(['ID_divisi', 'nama']);
        return view('pages.report.retur-penjualan.index', [
            'divisi' => $divisi
        ]);
    }

    public function datatables($dateRange, $sortBy, $sort)
    {
        $dateExplode = explode(' ', $dateRange);
        $dateStart = $dateExplode[0];
        $dateEnd = $dateExplode[2];
        $getColumn = ['nomor_retur', 'tanggal_retur', 'ID_invoice', 'jumlah_stok_retur', 'nominal_retur'];

        $retur = Retur::whereBetween('tanggal_retur', [$dateStart, $dateEnd])->get($getColumn);
        return DataTables::of($retur)
            ->addIndexColumn()
            ->toJson();
    }
}
