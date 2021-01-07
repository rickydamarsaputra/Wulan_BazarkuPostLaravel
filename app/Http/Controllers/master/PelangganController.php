<?php

namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use App\Models\Divisi;
use Illuminate\Http\Request;
use App\Models\Pelanggan;
use DataTables;
use Illuminate\Support\Facades\Date;

class PelangganController extends Controller
{
    public function index()
    {
        return view('pages.master.pelanggan.index');
    }

    public function createView()
    {
        $divisi = Divisi::all(['ID_divisi', 'nama']);
        $statusMitra = [
            [
                'status' => 1,
                'label' => 'Reseller',
            ],
            [
                'status' => 2,
                'label' => 'Dropshipper',
            ],
            [
                'status' => 3,
                'label' => 'Grosir',
            ],
            [
                'status' => 4,
                'label' => 'Pembeli Instagram',
            ],
            [
                'status' => 5,
                'label' => 'Pembeli Ecer',
            ],
        ];
        return view('pages.master.pelanggan.create', [
            'divisi' => $divisi,
            'statusMitra' => $statusMitra,
        ]);
    }

    public function createProcess(Request $request)
    {
        $date = date_format(Date::now(), 'Y-d-m');
        $this->validate($request, [
            'nama_pelanggan' => 'required',
            'alamat_pelanggan' => 'required',
            'email_pelanggan' => 'required',
            'notelp_pelanggan' => 'required',
        ]);

        $pelanggan = Pelanggan::create([
            'nama_pelanggan' => $request->nama_pelanggan,
            'alamat' => $request->alamat_pelanggan,
            'email' => $request->email_pelanggan,
            'no_telp' => $request->notelp_pelanggan,
            'ID_divisi' => $request->divisi_id,
            'status_mitra' => $request->status_mitra,
            'tanggal_input' => $date,
            'status' => 1
        ]);
        return redirect()->route('pelanggan.index');
    }

    public function delete($pelangganId)
    {
        $pelanggan = Pelanggan::findOrFail($pelangganId);
        $pelanggan->delete();

        return redirect()->back();
    }

    public function datatables()
    {
        $pelanggan = Pelanggan::select('pelanggan.*');

        return DataTables::of($pelanggan)
            ->addIndexColumn()
            ->toJson();
    }
}
