<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Produk;

class PembelianDetail extends Model
{
    use HasFactory;
    protected $table = "pembelian_detail";
    protected $primaryKey = "ID_pembelian_detail";
    public $incrementing = true;
    public $timestamps = false;
    protected $guarded = ["ID_pembelian_detail"];

    public function produk()
    {
        return $this->hasOne(Produk::class, 'ID_Produk', 'ID_produk');
    }
}
