<?php

namespace App\Http\Controllers\modul;

use App\Http\Controllers\Controller;
use App\Models\Brangkas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use App\Models\Mutasi;
use Illuminate\Support\Facades\Auth;

class BazarkuModulController extends Controller
{
    static function insertMutasiAndUpdateBrangkas($divisi, $bank, $jenisTransaksi, $idTransaksi, $jenisMutasi, $nominal)
    {
        // return [$divisi, $bank, $jenisTransaksi, $idTransaksi, $jenisMutasi, str_replace('.', '', $nominal)];
        $dateCode = date_format(Date::now(), "ymd");
        $date = date_format(Date::now(), 'Y-m-d');
        $time = date_format(Date::now(), 'H:i:s');
        $lastMutasi = Mutasi::get()->last();
        $brangkas = Brangkas::whereIdBank($bank->ID_bank)->whereIdDivisi($divisi->ID_divisi)->first();
        $user = Auth::user();
        $currentCounterNomorMutasi = $lastMutasi->tanggal_transaksi == date_format(Date::now(), "Y-m-d") ? substr($lastMutasi->nomor_mutasi, 16) : 0;
        $counterNomorMutasi = sprintf("%06d", $currentCounterNomorMutasi + 1);
        $nomorMutasi = "BZ-MT-$divisi->kode_divisi-$dateCode-$counterNomorMutasi";

        $mutasi = Mutasi::create([
            'nomor_mutasi' => $nomorMutasi,
            'tanggal_transaksi' => $date,
            'jam_transaksi' => $time,
            'ID_bank' => $bank->ID_bank,
            'ID_divisi' => $divisi->ID_divisi,
            'jenis_transaksi' => $jenisTransaksi,
            'ID_transaksi' => $idTransaksi,
            'jenis_mutasi' => $jenisMutasi,
            'nominal' => str_replace('.', '', $nominal),
            'saldo_saat_ini' => $jenisMutasi == 1 ? $brangkas->nominal + str_replace('.', '', $nominal) : $brangkas->nominal - str_replace('.', '', $nominal),
            'ID_user' => $user->ID_user,
            'status' => 1
        ]);

        $brangkas->update([
            'nomor_mutasi_terakhir' => $mutasi->nomor_mutasi,
            'nominal' => $mutasi->saldo_saat_ini,
            'tanggal_update_terakhir' => $date,
            'jam_update_terakhir' => $time,
            'ID_transaksi_terakhir' => $idTransaksi,
            'ID_user_update_terakhir' => $user->ID_user,
        ]);
        // return $nomorMutasi;

        // return [$nomorMutasi, $idTransaksi];
    }
}
