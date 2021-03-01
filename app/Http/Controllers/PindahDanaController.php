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
use RealRashid\SweetAlert\Facades\Alert;

class PindahDanaController extends Controller
{
    public function createView()
    {
        $bank = Bank::get(['ID_bank', 'nama_bank']);
        $divisi = Divisi::get(['ID_divisi', 'nama']);

        return view('pages.pindah-dana.create', [
            'bank' => $bank,
            'divisi' => $divisi,
        ]);
    }

    public function createProcess(Request $request)
    {
        $this->validate($request, [
            'bank_asal' => 'required',
            'divisi_asal' => 'required',
            'nominal' => 'required',
            'bank_tujuan' => 'required',
            'divisi_tujuan' => 'required',
            'keterangan' => 'required',
        ]);

        $user = Auth::user();
        $date = date_format(Date::now(), 'Y-m-d');
        $time = date_format(Date::now(), 'H:i:s');
        $dateCode = date_format(Date::now(), 'ymd');

        $bankAsal = Bank::find($request->bank_asal);
        $divisiAsal = Divisi::find($request->divisi_asal);
        $bankTujuan = Bank::find($request->bank_tujuan);
        $divisiTujuan = Divisi::find($request->divisi_tujuan);

        // pindah dana masuk
        $perkiraanAkuntansiPindahDanaMasuk = PerkiraanAkuntansi::whereNamaAkun('Pindah Dana (Masuk)')->first();
        $transaksiAkuntansiTerakhirPindahDanaMasuk = TransaksiAkuntansi::whereTanggalTransaksi($request->tanggal_transaksi)->get()->last();
        $counterNomorTransaksiPindahDanaMasuk = empty($transaksiAkuntansiTerakhirPindahDanaMasuk) ? 0 : ($transaksiAkuntansiTerakhirPindahDanaMasuk->tanggal_input == date_format(Date::now(), "Y-m-d") ? substr($transaksiAkuntansiTerakhirPindahDanaMasuk->nomor_transaksi, 18) : 0);
        $lastCodePindahDanaMasuk = sprintf("%06d", $counterNomorTransaksiPindahDanaMasuk + 1);
        $nomorTransaksiPindahDanaMasuk = "BZ-TA-$perkiraanAkuntansiPindahDanaMasuk->kode_perkiraan-$dateCode-$lastCodePindahDanaMasuk";

        $transaksiAkuntansiPindahDanaMasuk = TransaksiAkuntansi::create([
            'nomor_transaksi' => $nomorTransaksiPindahDanaMasuk,
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'tanggal_input' => $date,
            'jam_input' => $time,
            'ID_perkiraan' => $perkiraanAkuntansiPindahDanaMasuk->ID_perkiraan,
            'nama_akun' => $perkiraanAkuntansiPindahDanaMasuk->nama_akun,
            'tipe_akun' => $perkiraanAkuntansiPindahDanaMasuk->tipe_akun,
            'ID_divisi' => $divisiTujuan->ID_divisi,
            'nominal' => $request->nominal,
            'ID_bank' => $bankTujuan->ID_bank,
            'keterangan' => $request->keterangan,
            'ID_user' => $user->ID_user,
            'status' => 1,
        ]);
        BazarkuModulController::insertMutasiAndUpdateBrangkas($divisiTujuan, $bankTujuan, '3', $transaksiAkuntansiPindahDanaMasuk->nomor_transaksi, $transaksiAkuntansiPindahDanaMasuk->tipe_akun, $request->nominal);

        // pindah dana keluar
        $perkiraanAkuntansiPindahDanaKeluar = PerkiraanAkuntansi::whereNamaAkun('Pindah Dana (Keluar)')->first();
        $transaksiAkuntansiTerakhirPindahDanaKeluar = TransaksiAkuntansi::whereTanggalTransaksi($request->tanggal_transaksi)->get()->last();
        $counterNomorTransaksiPindahDanaKeluar = empty($transaksiAkuntansiTerakhirPindahDanaKeluar) ? 0 : ($transaksiAkuntansiTerakhirPindahDanaKeluar->tanggal_input == date_format(Date::now(), "Y-m-d") ? substr($transaksiAkuntansiTerakhirPindahDanaKeluar->nomor_transaksi, 18) : 0);
        $lastCodePindahDanaKeluar = sprintf("%06d", $counterNomorTransaksiPindahDanaKeluar + 1);
        $nomorTransaksiPindahDanaKeluar = "BZ-TA-$perkiraanAkuntansiPindahDanaKeluar->kode_perkiraan-$dateCode-$lastCodePindahDanaKeluar";

        $transaksiAkuntansiPindahDanaKeluar = TransaksiAkuntansi::create([
            'nomor_transaksi' => $nomorTransaksiPindahDanaKeluar,
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'tanggal_input' => $date,
            'jam_input' => $time,
            'ID_perkiraan' => $perkiraanAkuntansiPindahDanaKeluar->ID_perkiraan,
            'nama_akun' => $perkiraanAkuntansiPindahDanaKeluar->nama_akun,
            'tipe_akun' => $perkiraanAkuntansiPindahDanaKeluar->tipe_akun,
            'ID_divisi' => $divisiAsal->ID_divisi,
            'nominal' => $request->nominal,
            'ID_bank' => $bankAsal->ID_bank,
            'keterangan' => $request->keterangan,
            'ID_user' => $user->ID_user,
            'status' => 1,
        ]);
        BazarkuModulController::insertMutasiAndUpdateBrangkas($divisiAsal, $bankAsal, '3', $transaksiAkuntansiPindahDanaKeluar->nomor_transaksi, $transaksiAkuntansiPindahDanaKeluar->tipe_akun, $request->nominal);

        Alert::success('Pindah Dana', 'Pindah Dana Berhasil!');
        return redirect()->back();
        // return [
        //     'pindah_dana_masuk' => $nomorTransaksiPindahDanaMasuk,
        //     'pindah_dana_keluar' => $nomorTransaksiPindahDanaKeluar
        // ];
    }
}
