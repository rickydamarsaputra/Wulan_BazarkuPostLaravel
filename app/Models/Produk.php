<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Divisi;

class Produk extends Model
{
    use HasFactory;
    protected $table = "produk";
    protected $primaryKey = "ID_produk";
    public $incrementing = true;
    public $timestamps = false;
    protected $guarded = [];

    public function divisi()
    {
        return $this->hasOne(Divisi::class, "ID_divisi", "ID_divisi");
    }
}
