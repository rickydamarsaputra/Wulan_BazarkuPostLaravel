<?php

namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PerkiraanAkuntansi;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;

class PerkiraanAkuntansiController extends Controller
{
    public function index()
    {
        return view('pages.master.perkiraan-akuntansi.index');
    }

    public function createView()
    {
        $tipeAkun = [
            [
                'status' => 1,
                'label' => 'pemasukan'
            ],
            [
                'status' => 2,
                'label' => 'pengeluaran'
            ],
        ];
        return view('pages.master.perkiraan-akuntansi.create', [
            'tipeAkun' => $tipeAkun
        ]);
    }

    public function createProcess(Request $request)
    {
        $this->validate($request, [
            'kode_akun_perkiraan' => 'required',
            'nama_akun' => 'required',
        ]);
        $date = date_format(Date::now(), 'Y-d-m');
        $user = Auth::user();
        $perkiraanAkuntansi = PerkiraanAkuntansi::create([
            'kode_perkiraan' => $request->kode_akun_perkiraan,
            'nama_akun' => $request->nama_akun,
            'tipe_akun' => $request->tipe_akun,
            'tanggal_input' => $date,
            'ID_user' => $user->ID_user,
            'status' => 1
        ]);

        return redirect()->route('perkiraan.akuntansi.index');
    }

    public function updateView($perkiraanId)
    {
        $perkiraanAkuntansi = PerkiraanAkuntansi::findOrFail($perkiraanId);
        $tipeAkun = [
            [
                'status' => 1,
                'label' => 'pemasukan'
            ],
            [
                'status' => 2,
                'label' => 'pengeluaran'
            ],
        ];

        return view('pages.master.perkiraan-akuntansi.update', [
            'perkiraanAkuntansi' => $perkiraanAkuntansi,
            'tipeAkun' => $tipeAkun
        ]);
    }

    public function updateProcess(Request $request, $perkiraanId)
    {
        $this->validate($request, [
            'kode_akun_perkiraan' => 'required',
            'nama_akun' => 'required',
        ]);
        $perkiraanAkuntansi = PerkiraanAkuntansi::findOrFail($perkiraanId);
        $perkiraanAkuntansi->update([
            'kode_perkiraan' => $request->kode_akun_perkiraan,
            'nama_akun' => $request->nama_akun,
            'tipe_akun' => $request->tipe_akun
        ]);

        return redirect()->route('perkiraan.akuntansi.index');
    }

    public function delete($perkiraanId)
    {
        $perkiraanAkuntansi = PerkiraanAkuntansi::findOrFail($perkiraanId);
        $perkiraanAkuntansi->delete();

        return redirect()->back();
    }

    public function datatables()
    {
        $perkiraanAkuntansi = PerkiraanAkuntansi::all();
        return DataTables::of($perkiraanAkuntansi)
            ->addIndexColumn()
            ->toJson();
    }
}
