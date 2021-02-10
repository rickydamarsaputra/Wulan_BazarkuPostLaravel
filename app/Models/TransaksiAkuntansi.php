<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PerkiraanAkuntansi;
use App\Models\Divisi;
use App\Models\Bank;

class TransaksiAkuntansi extends Model
{
    use HasFactory;
    protected $table = "transaksi_akuntansi";
    protected $primaryKey = "ID_transaksi";
    public $incrementing = true;
    public $timestamps = false;
    protected $guarded = ["ID_transaksi"];

    public function perkiraanAkuntansi()
    {
        return $this->hasOne(PerkiraanAkuntansi::class, 'ID_perkiraan', 'ID_perkiraan');
    }

    public function divisi()
    {
        return $this->hasOne(Divisi::class, 'ID_divisi', 'ID_divisi');
    }

    public function bank()
    {
        return $this->hasOne(Bank::class, 'ID_bank', 'ID_bank');
    }
}
