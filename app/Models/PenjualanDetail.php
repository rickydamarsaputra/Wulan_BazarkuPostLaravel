<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Produk;

class PenjualanDetail extends Model
{
    use HasFactory;
    protected $table = "penjualan_detail";
    protected $primaryKey = "ID_penjualan_detail";
    public $incrementing = true;
    public $timestamps = false;
    protected $guarded = ["ID_penjualan_detail"];

    public function produk()
    {
        return $this->hasOne(Produk::class, 'ID_produk', 'ID_produk');
    }
}
