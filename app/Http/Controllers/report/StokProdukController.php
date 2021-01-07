<?php

namespace App\Http\Controllers\report;

use App\Http\Controllers\Controller;
use App\Models\Divisi;
use App\Models\Produk;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Str;

class StokProdukController extends Controller
{
    public function index()
    {
        $divisi = Divisi::get(['ID_divisi', 'nama']);
        return view('pages.report.stok-produk.index', [
            'divisi' => $divisi,
        ]);
    }

    public function datatables($divisiId, $sortBy, $sort)
    {
        $sort = $sort == "Ascending" || $sort == "ASC Or DESC" ? "ASC" : "DESC";
        $sortBy = Str::slug($sortBy, "_");

        if ($divisiId == "Semua Divisi") {
            $produk = Produk::with(["divisi"])->orderBy("ID_produk", $sort)->get(["ID_produk", "ID_divisi", "kode_produk", "nama_produk", "qty_min", "qty_saat_ini"]);
        } else {
            $produk = Produk::with(["divisi"])->orderBy("ID_produk", $sort)->whereIdDivisi($divisiId)->get(["ID_produk", "ID_divisi", "kode_produk", "nama_produk", "qty_min", "qty_saat_ini"]);
        }

        return DataTables::of($produk)
            ->addIndexColumn()
            ->toJson();
    }
}
