<?php

namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use App\Models\Ekspedisi;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Date;

class EkspedisiController extends Controller
{
    public function index()
    {
        return view('pages.master.ekspedisi.index');
    }

    public function createView()
    {
        return view('pages.master.ekspedisi.create');
    }

    public function createProcess(Request $request)
    {
        $this->validate($request, [
            'nama_ekspedisi' => 'required'
        ]);
        $date = date_format(Date::now(), 'Y-d-m');
        $ekspedisi = Ekspedisi::create([
            'nama_ekspedisi' => $request->nama_ekspedisi,
            'logo' => '-',
            'tanggal_input' => $date,
            'status' => 1
        ]);

        return redirect()->route('ekspedisi.index');
    }

    public function updateView($ekspedisiId)
    {
        $ekspedisi = Ekspedisi::findOrFail($ekspedisiId);
        return view('pages.master.ekspedisi.update', [
            'ekspedisi' => $ekspedisi
        ]);
    }

    public function updateProcess(Request $request, $ekspedisiId)
    {
        $this->validate($request, [
            'nama_ekspedisi' => 'required'
        ]);
        $ekspedisi = Ekspedisi::findOrFail($ekspedisiId);
        $ekspedisi->update([
            'nama_ekspedisi' => $request->nama_ekspedisi
        ]);

        return redirect()->route('ekspedisi.index');
    }

    public function delete($ekspedisiId)
    {
        $ekspedisi = Ekspedisi::findOrFail($ekspedisiId);
        $ekspedisi->delete();

        return redirect()->back();
    }

    public function datatables()
    {
        $ekspedisi = Ekspedisi::all();

        return DataTables::of($ekspedisi)
            ->addIndexColumn()
            ->toJson();
    }
}
