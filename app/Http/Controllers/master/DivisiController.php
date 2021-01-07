<?php

namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Divisi;
use DataTables;
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
        $date = date_format(Date::now(), 'Y-d-m');
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
