<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Controllers\PenjualanController;
use RealRashid\SweetAlert\Facades\Alert;

class WhenUserIsNotAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->role->nama_role == "Kasir") {
            // Alert::warning('Warning Title', 'Warning Message');
            return redirect()->action([PenjualanController::class, 'create']);
        }
        return $next($request);
    }
}
