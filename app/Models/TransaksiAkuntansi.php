<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiAkuntansi extends Model
{
    use HasFactory;
    protected $table = "transaksi_akuntansi";
    protected $primaryKey = "ID_transaksi";
}
