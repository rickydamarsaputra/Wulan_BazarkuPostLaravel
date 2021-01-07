<?php

namespace App\Http\Controllers\report;

use App\Http\Controllers\Controller;
use App\Models\Divisi;
use Illuminate\Http\Request;
use App\Models\Produk;
use DataTables;

class ProdukTerlarisController extends Controller
{
    public function index()
    {
        $divisi = Divisi::all();

        return view('pages.report.produk-terlaris.index', [
            'divisi' => $divisi
        ]);
    }

    public function datatables($divisiId, $dateRange)
    {
        $dateExplode = explode(' ', $dateRange);
        $dateStart = $dateExplode[0];
        $dateEnd = $dateExplode[2];
        $getColumn = ['ID_produk', 'kode_produk', 'nama_produk', 'ID_divisi', 'tanggal_input', 'qty_saat_ini', 'tgl_beli_terakhir'];

        if ($divisiId == 'Semua Divisi') {
            $produk = Produk::with(['divisi'])->whereBetween('tanggal_input', [$dateStart, $dateEnd])->get($getColumn);
        } else {
            $produk = Produk::with(['divisi'])->whereIdDivisi($divisiId)->whereBetween('tanggal_input', [$dateStart, $dateEnd])->get($getColumn);
        }

        return DataTables::of($produk)
            ->addIndexColumn()
            ->toJson();
    }
}
