<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Supplier;
use App\Models\Divisi;
use App\Models\Bank;

class Pembelian extends Model
{
    use HasFactory;
    protected $table = "pembelian";
    protected $primaryKey = "ID_pembelian";

    public function supplier()
    {
        return $this->hasOne(Supplier::class, "ID_supplier", "ID_supplier");
    }

    public function divisi()
    {
        return $this->hasOne(Divisi::class, "ID_divisi", "ID_divisi");
    }

    public function bank()
    {
        return $this->hasOne(Bank::class, "ID_bank", "ID_bank");
    }
}
