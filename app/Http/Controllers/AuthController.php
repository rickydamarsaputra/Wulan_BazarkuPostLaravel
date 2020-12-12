<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\PenjualanController;
use App\Models\PenjualanDetail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    public function loginView()
    {
        return view('pages.auth.login');
    }

    public function loginProcess(Request $request)
    {
        $user = User::whereUsername($request->username)->first();
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);
        if (auth()->attempt($request->only(['username', 'password']))) {
            if ($user->role->nama_role != "Kasir") {
                return redirect()->route('dashboard.index');
            } else {
                // return redirect()->route('penjualan.choose.divisi');
                return redirect()->action([PenjualanController::class, 'create']);
            }
        } else {
            return "Gagal";
        }
    }

    public function profileUser()
    {
        return view('pages.auth.profile');
    }

    public function changeUserPassword(Request $request)
    {
        $currentUser = auth()->user();
        $this->validate($request, [
            "old_password" => "required",
            "new_password" => "required",
        ]);
        if (Hash::check($request->old_password, $currentUser->password)) {
            $currentUser->update([
                "password" => bcrypt($request->new_password)
            ]);
            Alert::success('Berhasil!', 'Password berhasil diubah.');
            return redirect()->route('penjualan.index');
        } else {
            Alert::error('Belum berhasil!', 'Pastikan kolom password lama dan password baru telah terisi.');
            return redirect()->back();
        }
    }

    public function randomPassword()
    {
        $passwordRandom = Str::random(20);
        return response()->json([
            "password" => $passwordRandom
        ]);
    }
}
