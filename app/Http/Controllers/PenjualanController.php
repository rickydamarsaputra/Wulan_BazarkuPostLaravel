<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use App\Models\Penjualan;
use App\Models\Divisi;
use App\Models\Pelanggan;
use App\Models\Sales;
use App\Models\Produk;
use App\Models\Ekspedisi;
use App\Models\Bank;
use App\Models\PenjualanDetail;
use PDF;

use DataTables;

class PenjualanController extends Controller
{
    public function index()
    {
        $penjualan = Penjualan::get(["total", "ongkir", "diskon", "pajak", "grand_total"]);
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

    public function chooseDivisi()
    {
        $divisi = Divisi::all();
        return view('pages.penjualan.choose', [
            'divisi' => $divisi,
        ]);
    }

    public function create(Request $request)
    {
        $divisiID = empty($request->divisi_id) ? auth()->user()->divisi->ID_divisi : $request->divisi_id;
        $divisi = Divisi::findOrFail($divisiID);
        $produk = Produk::whereIdDivisi($divisi->ID_divisi)->cursor()->filter(function ($pro) {
            return $pro->qty_saat_ini > 0;
        });
        $sales = Sales::all();
        $pelanggan = Pelanggan::cursor()->filter(function ($pelang) {
            return $pelang->status_mitra != 6;
        });
        $ekspedisi = Ekspedisi::all();
        $banks = Bank::select("ID_bank", "nama_bank")->get();
        $lastOrder = Penjualan::whereIdDivisi($divisi->ID_divisi)->get()->last();
        $currentCode = $lastOrder->tanggal_input == date_format(Date::now(), "Y-m-d") ? substr($lastOrder->nomor_penjualan, 16) : 0;
        $lastCode = sprintf("%04d", $currentCode + 1);
        $nomorPenjualan =  "BZ-JL-" . $divisi->kode_divisi . "-" . date_format(Date::now(), "ymd") . "-" . $lastCode;

        return view("pages.penjualan.create", [
            "divisi" => $divisi,
            "nomorPenjualan" => $nomorPenjualan,
            "sales" => $sales,
            "pelanggan" => $pelanggan,
            "produk" => $produk,
            "ekspedisi" => $ekspedisi,
            "banks" => $banks,
        ]);
    }

    public function submitPenjualan(Request $request)
    {
        $divisi = Divisi::whereNama($request->nama_divisi)->first();
        $lastOrder = Penjualan::whereIdDivisi($divisi->ID_divisi)->get()->last();
        $currentCode = $lastOrder->tanggal_input == date_format(Date::now(), "Y-m-d") ? substr($lastOrder->nomor_penjualan, 16) : 0;
        $lastCode = sprintf("%04d", $currentCode + 1);
        $nomorPenjualan =  "BZ-JL-" . $divisi->kode_divisi . "-" . date_format(Date::now(), "ymd") . "-" . $lastCode;

        $penjualanDetail = [];
        $penjualanDetailCounter = 0;
        $penjualanDetailIdProduk = $request->penjualan_detail_id_produk;
        $penjualanDetailKeterangan = $request->penjualan_detail_keterangan;
        $penjualanDetailJumlah = $request->penjualan_detail_jumlah;
        $penjualanDetailHarga = $request->penjualan_detail_harga;
        $penjualanDetailTotal = $request->penjualan_detail_total;

        foreach ($penjualanDetailKeterangan as $loop) {
            $produk = Produk::find($penjualanDetailIdProduk[$penjualanDetailCounter]);
            array_push($penjualanDetail, [
                "id_produk" => $penjualanDetailIdProduk[$penjualanDetailCounter],
                "keterangan" => $penjualanDetailKeterangan[$penjualanDetailCounter],
                "hpp" => $produk->HPP,
                "jumlah" => $penjualanDetailJumlah[$penjualanDetailCounter],
                "harga" => $penjualanDetailHarga[$penjualanDetailCounter],
                "total" => $penjualanDetailTotal[$penjualanDetailCounter],
            ]);
            $penjualanDetailCounter++;
        }

        // $penerima = Pelanggan::create([
        //     "nama_pelanggan" => $request->nama_penerima,
        //     "alamat" => $request->alamat_penerima,
        //     "email" => "-",
        //     "no_telp" => $request->notel_penerima,
        //     "ID_divisi" => $divisi->ID_divisi,
        //     "tanggal_input" => date_format(Date::now(), "Y-m-d"),
        //     "status_mitra" => 6,
        //     "status" => 1
        // ]);

        $penjualan = Penjualan::create([
            "nomor_penjualan" => $request->nomor_penjualan,
            "tanggal_jual" => $request->tanggal_jual,
            "tanggal_input" => date_format(Date::now(), "Y-m-d"),
            "jam_input" => date_format(Date::now(), "H:i:s"),
            "ID_divisi" => $divisi->ID_divisi,
            "ID_sales" => $request->id_sales,
            "ID_bank" => $request->id_bank,
            "ID_pelanggan" => $request->id_pelanggan,
            "ID_penerima" => 0,
            "ID_ekspedisi" => $request->id_ekspedisi,
            "nama_penerima" => $request->nama_penerima,
            "telp_penerima" => $request->notel_penerima,
            "alamat_penerima" => $request->alamat_penerima,
            "keterangan" => $request->keterangan,
            "berat" => $request->berat,
            "status_dropship" => $request->status_dropship != "on" ? 0 : 1,
            "nama_pengirim_dropship" => empty($request->nama_pengirim_dropship) ? "Bazarku $divisi->nama" : $request->nama_pengirim_dropship,
            "total" => $request->total,
            "diskon" => $request->diskon,
            "pajak" => $request->pajak,
            "ongkir" => $request->ongkir,
            "realisasi_ongkir" => 0,
            "grand_total" => $request->grand_total,
            "sudah_bayar" => $request->dibayar,
            "status_pembayaran" => $request->dibayar >= $request->grand_total ? 1 : 0,
            "ID_user" => auth()->user()->ID_user,
            "status" => 1,
        ]);

        foreach ($penjualanDetail as $penjualanDeta) {
            $penguranganQty = Produk::find($penjualanDeta["id_produk"]);
            $penguranganQty->update([
                "qty_saat_ini" => $penguranganQty->qty_saat_ini - $penjualanDeta["jumlah"]
            ]);
            $penjualanDetailLoop = PenjualanDetail::create([
                "ID_penjualan" => $nomorPenjualan,
                "tanggal_jual" => $request->tanggal_jual,
                "ID_produk" => $penjualanDeta["id_produk"],
                "keterangan" => empty($penjualanDeta["keterangan"]) ? "-" : $penjualanDeta["keterangan"],
                "HPP" => $penjualanDeta["hpp"],
                "qty" => $penjualanDeta["jumlah"],
                "harga_jual" => $penjualanDeta["harga"],
                "total" => $penjualanDeta["total"],
                "status" => 1
            ]);
        }

        return redirect()->route("penjualan.print.invoice", $penjualan->nomor_penjualan);
        // return [
        //     "divisi" => $divisi,
        //     "request" => $request->except(["penjualan_detail_id_produk", "penjualan_detail_keterangan", "penjualan_detail_jumlah", "penjualan_detail_harga", "penjualan_detail_total"]),
        //     "status_dropship" => $request->status_dropship != "on" ? 0 : 1,
        //     "nama_pengirim_dropship" => empty($request->nama_pengirim_dropship) ? "Bazarku $divisi->nama" : $request->nama_pengirim_dropship,
        //     "penjualan_detail" => $penjualanDetail
        // ];
    }

    public function searchProduk($idProduk, $idPelanggan)
    {
        $produk = Produk::whereIdProduk($idProduk)->first();
        $pelanggan = Pelanggan::find($idPelanggan);
        $harga = 0;
        switch ($pelanggan->status_mitra) {
            case 1: //reseller
                $harga += $produk->harga_reseller;
            case 2: //dropshipper
                $harga += $produk->harga_dropship;
            case 3: //grosir
                $harga += $produk->harga_grosir;
            case 4: //instagram
                $harga += $produk->harga_instagram;
            case 5: //ecer
                $harga += $produk->harga_normal;
                break;
        }

        return [
            'harga' => $harga,
            'qty' => $produk->qty_saat_ini
        ];
    }

    public function datatables()
    {
        $query = Penjualan::with("penerima", "divisi", "sales", "ekspedisi", "bank")->select("penjualan.*");
        return datatables()->of($query)
            ->editColumn('detail_penjualan', function ($penjual) {
                return '<a class="btn btn-primary btn-sm" href="' . route('penjualan.detail', $penjual->nomor_penjualan) . '">detail</a>';
            })
            ->rawColumns(['detail_penjualan'])
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
    }

    public function detailPenjualan($nomorPenjualan)
    {
        $penjualan = Penjualan::whereNomorPenjualan($nomorPenjualan)->with(["pelanggan", "divisi", "sales", "ekspedisi", "bank", "penjualanDetail"])->firstOrFail();
        return view("pages.penjualan.detail", [
            "penjualan" => $penjualan
        ]);
    }

    public function printInvoice($nomorPenjualan)
    {
        $penjualan = Penjualan::whereNomorPenjualan($nomorPenjualan)->with(["pelanggan", "penerima", "divisi", "sales", "ekspedisi", "bank", "penjualanDetail"])->firstOrFail();
        $pdf = PDF::loadView("pages.penjualan.invoice", [
            "penjualan" => $penjualan
        ]);
        $pdf->setPaper("a5", "potrait");
        return $pdf->stream();
    }
}
