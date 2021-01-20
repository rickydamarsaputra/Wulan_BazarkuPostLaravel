<?php

namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use DataTables;
use Illuminate\Support\Facades\Date;

class SupplierController extends Controller
{
    public function index()
    {
        return view('pages.master.supplier.index');
    }

    public function createView()
    {
        return view('pages.master.supplier.create');
    }

    public function createProcess(Request $request)
    {
        $this->validate($request, [
            'nama_supplier' => 'required',
            'alamat_supplier' => 'required',
            'email_supplier' => 'required',
            'notelp_supplier' => 'required',
        ]);
        $date = date_format(Date::now(), 'Y-m-d');
        $supplier = Supplier::create([
            'nama' => $request->nama_supplier,
            'alamat' => $request->alamat_supplier,
            'email' => $request->email_supplier,
            'no_telp' => $request->notelp_supplier,
            'tanggal_input' => $date,
            'status' => 1
        ]);

        return redirect()->route('supplier.index');
    }

    public function updateView($supplierId)
    {
        $supplier = Supplier::findOrFail($supplierId);

        return view('pages.master.supplier.update', [
            'supplier' => $supplier
        ]);
    }

    public function updateProcess(Request $request, $supplierId)
    {
        $this->validate($request, [
            'nama_supplier' => 'required',
            'alamat_supplier' => 'required',
            'email_supplier' => 'required',
            'notelp_supplier' => 'required',
        ]);
        $supplier = Supplier::findOrFail($supplierId);
        $supplier->update([
            'nama' => $request->nama_supplier,
            'alamat' => $request->alamat_supplier,
            'email' => $request->email_supplier,
            'no_telp' => $request->notelp_supplier,
        ]);

        return redirect()->route('supplier.index');
    }

    public function delete($supplierId)
    {
        $supplier = Supplier::findOrFail($supplierId);
        $supplier->delete();
        return redirect()->back();
    }

    public function datatables()
    {
        $supplier = Supplier::all();

        return DataTables::of($supplier)
            ->addIndexColumn()
            ->toJson();
    }
}
