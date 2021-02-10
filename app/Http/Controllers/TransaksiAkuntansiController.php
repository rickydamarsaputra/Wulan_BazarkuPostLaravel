<?php

namespace App\Http\Controllers;

use App\Http\Controllers\modul\BazarkuModulController;
use App\Models\Bank;
use App\Models\Divisi;
use App\Models\PerkiraanAkuntansi;
use App\Models\TransaksiAkuntansi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use DataTables;

class TransaksiAkuntansiController extends Controller
{
    public function index()
    {
        $divisi = Divisi::get(['ID_divisi', 'nama']);
        $bank = Bank::get(['ID_bank', 'nama_bank']);

        return view('pages.transaksi-akuntansi.index', [
            'divisi' => $divisi,
            'bank' => $bank
        ]);
    }

    public function createView()
    {
        $divisi = Divisi::get(['ID_divisi', 'nama']);
        $bank = Bank::get(['ID_bank', 'nama_bank']);

        return view('pages.transaksi-akuntansi.create', [
            'divisi' => $divisi,
            'bank' => $bank,
        ]);
    }

    public function createProcess(Request $request)
    {
        $this->validate($request, [
            'divisi' => 'required',
            'perkiraan' => 'required',
            'bank' => 'required',
            'nominal' => 'required',
            'keterangan' => 'required'
        ]);

        $transaksiAkuntansiTerakhir = TransaksiAkuntansi::whereTanggalTransaksi($request->tanggal_transaksi)->whereIdPerkiraan($request->perkiraan)->whereTipeAkun($request->tipe_akun)->get()->last();
        $perkiraanAkuntansi = PerkiraanAkuntansi::find($request->perkiraan);
        $user = Auth::user();
        $divisi = Divisi::find($request->divisi);
        $bank = Bank::find($request->bank);
        $date = date_format(Date::now(), 'Y-m-d');
        $time = date_format(Date::now(), 'H:i:s');
        $dateCode = date_format(Date::now(), 'ymd');
        $counterNomorTransaksi = empty($transaksiAkuntansiTerakhir) ? 0 : ($transaksiAkuntansiTerakhir->tanggal_input == date_format(Date::now(), "Y-m-d") ? substr($transaksiAkuntansiTerakhir->nomor_transaksi, 18) : 0);
        $lastCode = sprintf("%06d", $counterNomorTransaksi + 1);
        $nomorTransaksi = "BZ-TA-$perkiraanAkuntansi->kode_perkiraan-$dateCode-$lastCode";

        $transaksiAkuntansi = TransaksiAkuntansi::create([
            'nomor_transaksi' => $nomorTransaksi,
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'tanggal_input' => $date,
            'jam_input' => $time,
            'ID_perkiraan' => $request->perkiraan,
            'nama_akun' => $perkiraanAkuntansi->nama_akun,
            'tipe_akun' => $request->tipe_akun,
            'ID_divisi' => $request->divisi,
            'nominal' => $request->nominal,
            'ID_bank' => $request->bank,
            'keterangan' => $request->keterangan,
            'ID_user' => $user->ID_user,
            'status' => 1,
        ]);

        BazarkuModulController::insertMutasiAndUpdateBrangkas($divisi, $bank, '3', $transaksiAkuntansi->nomor_transaksi, $transaksiAkuntansi->tipe_akun, $transaksiAkuntansi->nominal);
        return $transaksiAkuntansi->nomor_transaksi;
        // return $request->all();
    }

    public function delete($idTransaksi)
    {
        $transaksi = TransaksiAkuntansi::find($idTransaksi);
        $transaksi->delete();

        return redirect()->back();
    }

    public function filterPerkiraanAkuntansi($tipeAkun)
    {
        $perkiraanAkuntansi = PerkiraanAkuntansi::whereTipeAkun($tipeAkun)->get(['ID_perkiraan', 'nama_akun', 'tipe_akun']);

        return response()->json($perkiraanAkuntansi);
    }

    public function datatables($tipeAkun, $idPerkiraan, $idDivisi, $idBank, $dateRange)
    {
        $dateExplode = explode(' ', $dateRange);
        $dateFirst = $dateExplode[0];
        $dateLast = $dateExplode[2];
        $transaksi = TransaksiAkuntansi::with(['bank', 'divisi'])->whereBetween('tanggal_input', [$dateFirst, $dateLast]);

        if ($tipeAkun != 0) {
            $transaksi->whereTipeAkun($tipeAkun);
        }
        if ($idPerkiraan != 0) {
            $transaksi->whereIdPerkiraan($idPerkiraan);
        }
        if ($idPerkiraan != 0) {
            $transaksi->whereIdPerkiraan($idPerkiraan);
        }
        if ($idDivisi != 0) {
            $transaksi->whereIdDivisi($idDivisi);
        }
        if ($idBank != 0) {
            $transaksi->whereIdBank($idBank);
        }

        return DataTables::of($transaksi->get(['ID_transaksi', 'tanggal_transaksi', 'tipe_akun', 'nama_akun', 'ID_bank', 'ID_divisi', 'nominal', 'keterangan']))
            ->addIndexColumn()
            ->toJson();
    }
}
