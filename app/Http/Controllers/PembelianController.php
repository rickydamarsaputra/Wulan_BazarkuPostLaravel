<?php

namespace App\Http\Controllers;

use App\Http\Controllers\modul\BazarkuModulController;
use App\Models\Bank;
use App\Models\Divisi;
use App\Models\Pembelian;
use App\Models\PembelianDetail;
use App\Models\Produk;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use DataTables;
use PDF;

class PembelianController extends Controller
{
    public function index()
    {
        $supplier = Supplier::get(['ID_supplier', 'nama']);
        $divisi = Divisi::get(['ID_divisi', 'nama']);
        $bank = Bank::get(['ID_bank', 'nama_bank']);

        return view('pages.pembelian.index', [
            'supplier' => $supplier,
            'divisi' => $divisi,
            'bank' => $bank,
        ]);
    }

    public function chooseDivisi()
    {
        $divisi = Divisi::get(['ID_divisi', 'nama']);

        return view('pages.pembelian.choose', [
            'divisi' => $divisi,
        ]);
    }

    public function chooseSubmit(Request $request)
    {
        $this->validate($request, [
            'divisi' => 'required',
        ]);
        $divisi = Divisi::whereIdDivisi($request->divisi)->first(['ID_divisi', 'kode_divisi', 'nama']);
        $bank = Bank::get(['ID_bank', 'nama_bank']);
        $supplier = Supplier::get(['ID_supplier', 'nama']);
        $produk = Produk::whereIdDivisi($divisi->ID_divisi)->get(['ID_produk', 'nama_produk', 'qty_saat_ini']);
        $dateCode = date_format(Date::now(), 'ymd');
        $pembelianTerakhir = Pembelian::whereIdDivisi($divisi->ID_divisi)->get()->last();
        $pembelianCounter = empty($pembelianTerakhir) ? 0 : ($pembelianTerakhir->tanggal_input == date_format(Date::now(), "Y-m-d") ? substr($pembelianTerakhir->nomor_pembelian, 16) : 0);
        $pembelianCounter = sprintf("%04d", $pembelianCounter + 1);
        $nomorPembelian = "BZ-BL-$divisi->kode_divisi-$dateCode-$pembelianCounter";

        return view('pages.pembelian.create', [
            'divisi' => $divisi,
            'bank' => $bank,
            'nomorPembelian' => $nomorPembelian,
            'supplier' => $supplier,
            'produk' => $produk,
        ]);
    }

    public function pembelianSubmit(Request $request)
    {
        $pembelianDetail = [];
        $counter = 0;
        $user = Auth::user();
        $divisi = Divisi::whereNama($request->divisi)->first();
        $bank = Bank::whereIdBank($request->bank)->first();
        $dateCode = date_format(Date::now(), 'ymd');
        $pembelianTerakhir = Pembelian::whereIdDivisi($divisi->ID_divisi)->get()->last();
        $pembelianCounter = empty($pembelianTerakhir) ? 0 : ($pembelianTerakhir->tanggal_input == date_format(Date::now(), "Y-m-d") ? substr($pembelianTerakhir->nomor_pembelian, 16) : 0);
        $pembelianCounter = sprintf("%04d", $pembelianCounter + 1);
        $nomorPembelian = "BZ-BL-$divisi->kode_divisi-$dateCode-$pembelianCounter";

        foreach ($request->pembelian_detail_id_produk as $loopItem) {
            array_push($pembelianDetail, [
                'ID_produk' => $request->pembelian_detail_id_produk[$counter],
                'jumlah' => $request->pembelian_detail_jumlah[$counter],
                'harga_beli' => $request->pembelian_detail_harga[$counter],
                'total' => $request->pembelian_detail_total[$counter],
            ]);
            $counter++;
        }

        $pembelian = Pembelian::create([
            'nomor_pembelian' => $nomorPembelian,
            'tanggal_beli' => $request->tanggal_beli,
            'tanggal_input' => date_format(Date::now(), 'Y-m-d'),
            'jam_input' => date_format(Date::now(), 'H:i:s'),
            'ID_supplier' => $request->supplier,
            'ID_divisi' => $divisi->ID_divisi,
            'ID_bank' => $request->bank,
            'keterangan' => $request->keterangan,
            'total' => $request->total,
            'diskon' => $request->diskon,
            'pajak' => $request->pajak,
            'grand_total' => $request->grand_total,
            'sudah_bayar' => $request->dibayar,
            'status_pembayaran' => 1,
            'ID_user' => $user->ID_user,
            'status' => 1,
        ]);

        foreach ($pembelianDetail as $loopItem) {
            $pembelianDetailInsert = PembelianDetail::create([
                'ID_pembelian' => $pembelian->nomor_pembelian,
                'ID_produk' => $loopItem['ID_produk'],
                'keterangan' => '-',
                'qty' => $loopItem['jumlah'],
                'harga_beli' => $loopItem['harga_beli'],
                'total' => $loopItem['total'],
                'status' => 1,
            ]);

            $produk = Produk::find($loopItem['ID_produk']);
            $produk->update([
                'HPP' => $loopItem['harga_beli'],
            ]);
        }

        BazarkuModulController::insertMutasiAndUpdateBrangkas($divisi, $bank, '1', $nomorPembelian, '2', $pembelian->grand_total);
        return $pembelian->nomor_pembelian;
        // return [
        //     'request' => $request->except(['pembelian_detail_id_produk', 'pembelian_detail_jumlah', 'pembelian_detail_harga', 'pembelian_detail_total']),
        //     'pembelian_detail' => $pembelianDetail,
        //     'nomor_pembelian' => $nomorPembelian,
        // ];
    }

    public function detail($nomorPembelian)
    {
        $pembelian = Pembelian::whereNomorPembelian($nomorPembelian)->first();
        return view('pages.pembelian.detail', [
            'pembelian' => $pembelian,
        ]);
    }

    public function print($nomorPembelian)
    {
        $pembelian = Pembelian::whereNomorPembelian($nomorPembelian)->first();

        $pdf = PDF::loadView("pages.pembelian.invoice", [
            "pembelian" => $pembelian
        ]);
        $pdf->setPaper("a5", "potrait");
        return $pdf->stream();
    }

    public function datatables($idSupplier, $idDivisi, $idBank, $statusLunas, $dateRange)
    {
        $dateExplode = explode(' ', $dateRange);
        $dateFirst = $dateExplode[0];
        $dateLast = $dateExplode[2];
        $pembelian = Pembelian::with(['supplier', 'divisi'])->whereBetween('tanggal_input', [$dateFirst, $dateLast]);

        if ($idSupplier != 0) {
            $pembelian->whereIdSupplier($idSupplier);
        }
        if ($idDivisi != 0) {
            $pembelian->whereIdDivisi($idDivisi);
        }
        if ($idBank != 0) {
            $pembelian->whereIdBank($idBank);
        }
        if ($statusLunas != 0) {
            $pembelian->whereStatusPembayaran($statusLunas);
        }

        return DataTables::of($pembelian->get(['tanggal_beli', 'nomor_pembelian', 'ID_supplier', 'ID_divisi', 'grand_total', 'status_pembayaran']))
            ->addIndexColumn()
            ->toJson();
    }
}
