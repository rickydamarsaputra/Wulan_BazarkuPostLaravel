<?php

namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bank;
use DataTables;
use Illuminate\Support\Facades\Date;

class BankController extends Controller
{
    public function index()
    {
        return view('pages.master.bank.index');
    }

    public function createView()
    {
        $statusBank = [
            [
                'status' => 1,
                'label' => 'cash',
                'name' => 'cash',
            ],
            [
                'status' => 2,
                'label' => 'pending_in',
                'name' => 'pending in',
            ],
            [
                'status' => 3,
                'label' => 'pending_out',
                'name' => 'pending out',
            ],
        ];

        return view('pages.master.bank.create', [
            'statusBank' => $statusBank,
        ]);
    }

    public function createProcess(Request $request)
    {
        $date = date_format(Date::now(), 'Y-d-m');
        $this->validate($request, [
            'nama_bank' => 'required',
        ]);
        $bank = Bank::create([
            'nama_bank' => $request->nama_bank,
            'kategori_bank' => $request->status_bank,
            'tanggal_input' => $date,
            'status' => 1
        ]);

        return redirect()->route('bank.index');
    }

    public function updateView($bankId)
    {
        $bank = Bank::findOrFail($bankId);
        $statusBank = [
            [
                'status' => 1,
                'label' => 'cash',
                'name' => 'cash',
            ],
            [
                'status' => 2,
                'label' => 'pending_in',
                'name' => 'pending in',
            ],
            [
                'status' => 3,
                'label' => 'pending_out',
                'name' => 'pending out',
            ],
        ];

        return view('pages.master.bank.update', [
            'bank' => $bank,
            'statusBank' => $statusBank
        ]);
    }

    public function updateProcess(Request $request, $bankId)
    {
        $this->validate($request, [
            'nama_bank' => 'required',
        ]);

        $bank = Bank::findOrFail($bankId);
        $bank->update([
            'nama_bank' => $request->nama_bank,
            'kategori_bank' => $request->status_bank,
        ]);

        return redirect()->route('bank.index');
    }

    public function delete($bankId)
    {
        $bank = Bank::findOrFail($bankId);
        $bank->delete();
        return redirect()->back();
    }

    public function datatables()
    {
        $bank = Bank::all();

        return DataTables::of($bank)
            ->addIndexColumn()
            ->toJson();
    }
}
