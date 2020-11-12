<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pelanggan;
use App\Models\Divisi;
use App\Models\Sales;
use App\Models\Ekspedisi;
use App\Models\Bank;

class Penjualan extends Model
{
    use HasFactory;
    protected $table = "penjualan";
    protected $primaryKey = "ID_penjualan";

    public function pelanggan()
    {
        return $this->hasOne(Pelanggan::class, 'ID_pelanggan', 'ID_pelanggan');
    }

    public function divisi()
    {
        return $this->hasOne(Divisi::class, 'ID_divisi', 'ID_divisi');
    }

    public function sales()
    {
        return $this->hasOne(Sales::class, 'ID_sales', 'ID_sales');
    }

    public function ekspedisi()
    {
        return $this->hasOne(Ekspedisi::class, 'ID_ekspedisi', 'ID_ekspedisi');
    }

    public function bank()
    {
        return $this->hasOne(Bank::class, 'ID_bank', 'ID_bank');
    }
}
