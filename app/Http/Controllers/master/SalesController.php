<?php

namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sales;
use DataTables;
use Illuminate\Support\Facades\Date;

class SalesController extends Controller
{
    public function index()
    {
        return view('pages.master.sales.index');
    }

    public function createView()
    {
        return view('pages.master.sales.create');
    }

    public function createProcess(Request $request)
    {
        $this->validate($request, [
            'nama_sales' => 'required'
        ]);

        $date = date_format(Date::now(), 'Y-d-m');
        $sales = Sales::create([
            'nama_sales' => $request->nama_sales,
            'tanggal_input' => $date,
            'status' => 1
        ]);

        return redirect()->route('sales.index');
    }

    public function updateView($salesId)
    {
        $sales = Sales::findOrFail($salesId);
        return view('pages.master.sales.update', [
            'sales' => $sales,
        ]);
    }

    public function updateProcess(Request $request, $salesId)
    {
        $this->validate($request, [
            'nama_sales' => 'required'
        ]);

        $sales = Sales::findOrFail($salesId);
        $sales->update([
            'nama_sales' => $request->nama_sales,
        ]);

        return redirect()->route('sales.index');
    }

    public function delete($salesId)
    {
        $sales = Sales::findOrFail($salesId);
        $sales->delete();
        return redirect()->back();
    }

    public function datatables()
    {
        $sales = Sales::all();

        return DataTables::of($sales)
            ->addIndexColumn()
            ->toJson();
    }
}
