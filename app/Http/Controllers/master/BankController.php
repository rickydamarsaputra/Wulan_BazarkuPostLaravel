<?php

namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bank;
use App\Models\Divisi;
use App\Models\Brangkas;
use DataTables;
use Illuminate\Support\Facades\Auth;
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
        $dateExplode = explode(' ', date_format(Date::now(), 'Y-m-d H:i:s'));
        $user = Auth::user();
        $date = $dateExplode[0];
        $time = $dateExplode[1];
        $divisi = Divisi::get();

        $this->validate($request, [
            'nama_bank' => 'required',
        ]);
        $bank = Bank::create([
            'nama_bank' => $request->nama_bank,
            'kategori_bank' => $request->status_bank,
            'tanggal_input' => $date,
            'status' => 1
        ]);

        foreach ($divisi as $loopItem) {
            $brangkas = Brangkas::create([
                'nomor_mutasi_terakhir' => 0,
                'ID_bank' => $bank->ID_bank,
                'ID_divisi' => $loopItem->ID_divisi,
                'nominal' => 0,
                'tanggal_update_terakhir' => $date,
                'jam_update_terakhir' => $time,
                'ID_transaksi_terakhir' => 0,
                'ID_user_update_terakhir' => $user->ID_user,
            ]);
        }

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
        $user = Auth::user();
        $bank->update([
            'nama_bank' => $request->nama_bank,
            'kategori_bank' => $request->status_bank,
        ]);

        foreach ($bank->brangkas as $loopItem) {
            $loopItem->update([
                'ID_user_update_terakhir' => $user->ID_user
            ]);
        }

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
