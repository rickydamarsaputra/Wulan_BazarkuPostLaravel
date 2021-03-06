<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Produk;

class Divisi extends Model
{
    use HasFactory;
    protected $table = "divisi";
    protected $primaryKey = "ID_divisi";
    protected $guarded = ["ID_divisi"];
    public $incrementing = true;
    public $timestamps = false;

    public function produk()
    {
        return $this->hasMany(Produk::class, 'ID_divisi', 'ID_divisi');
    }
}
