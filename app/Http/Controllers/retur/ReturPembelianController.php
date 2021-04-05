<?php

namespace App\Http\Controllers\retur;

use App\Http\Controllers\Controller;
use App\Models\Divisi;
use App\Models\Retur;
use Illuminate\Http\Request;
use DataTables;

class ReturPembelianController extends Controller
{
    public function index()
    {
        $divisi = Divisi::get(['ID_divisi', 'nama']);

        return view('pages.retur.pembelian.index', [
            'divisi' => $divisi,
        ]);
    }

    public function datatables($divisi, $dateRange)
    {
        $dateExplode = explode(' ', $dateRange);
        $dateStart = $dateExplode[0];
        $dateEnd = $dateExplode[2];
        $getColumn = ['ID_divisi', 'nomor_retur', 'tanggal_retur', 'ID_invoice', 'jumlah_stok_retur', 'nominal_retur'];

        $retur = Retur::with(['divisi'])->whereJenisRetur(1)->whereBetween('tanggal_retur', [$dateStart, $dateEnd]);

        if ($divisi != 0) {
            $retur->whereIdDivisi($divisi);
        }

        return DataTables::of($retur->get())
            ->addIndexColumn()
            ->toJson();
    }
}
