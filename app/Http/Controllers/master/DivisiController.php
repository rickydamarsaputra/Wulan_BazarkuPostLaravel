<?php

namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\Brangkas;
use Illuminate\Http\Request;
use App\Models\Divisi;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;

class DivisiController extends Controller
{
    public function index()
    {
        return view('pages.master.divisi.index');
    }

    public function createView()
    {
        return view('pages.master.divisi.create');
    }

    public function createProcess(Request $request)
    {
        $dateExplode = explode(' ', date_format(Date::now(), 'Y-m-d H:i:s'));
        $banks = Bank::get();
        $user = Auth::user();
        $date = $dateExplode[0];
        $time = $dateExplode[1];

        $this->validate($request, [
            'kode_divisi' => 'required',
            'nama_divisi' => 'required',
            'notel_divisi' => 'required',
        ]);
        $divisi = Divisi::create([
            'kode_divisi' => $request->kode_divisi,
            'nama' => $request->nama_divisi,
            'no_telp' => $request->notel_divisi,
            'tanggal_input' => $date,
            'status' => 1,
        ]);

        foreach ($banks as $loopItem) {
            $brangkas = Brangkas::create([
                'nomor_mutasi_terakhir' => 0,
                'ID_bank' => $loopItem->ID_bank,
                'ID_divisi' => $divisi->ID_divisi,
                'nominal' => 0,
                'tanggal_update_terakhir' => $date,
                'jam_update_terakhir' => $time,
                'ID_transaksi_terakhir' => 0,
                'ID_user_update_terakhir' => $user->ID_user,
            ]);
        }

        return redirect()->route('divisi.index');
    }

    public function updateView($divisiId)
    {
        $divisi = Divisi::findOrFail($divisiId);

        return view('pages.master.divisi.update', [
            'divisi' => $divisi
        ]);
    }

    public function updateProcess(Request $request, $divisiId)
    {
        $this->validate($request, [
            'kode_divisi' => 'required',
            'nama_divisi' => 'required',
            'notel_divisi' => 'required',
        ]);

        $date = date_format(Date::now(), 'Y-d-m');
        $divisi = Divisi::findOrFail($divisiId);
        $divisi->update([
            'kode_divisi' => $request->kode_divisi,
            'nama' => $request->nama_divisi,
            'no_telp' => $request->notel_divisi,
            'tanggal_input' => $date,
            'status' => 1
        ]);

        return redirect()->route('divisi.index');
    }

    public function delete($divisiId)
    {
        $divisi = Divisi::findOrFail($divisiId);
        $divisi->delete();
        return redirect()->back();
    }

    public function datatables()
    {
        $divisi = Divisi::all();

        return DataTables::of($divisi)
            ->addIndexColumn()
            ->toJson();
    }
}
