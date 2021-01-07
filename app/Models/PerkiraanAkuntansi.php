<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerkiraanAkuntansi extends Model
{
    use HasFactory;
    protected $table = "perkiraan_akuntansi";
    protected $primaryKey = "ID_perkiraan";
    public $incrementing = true;
    public $timestamps = false;
    protected $guarded = ["ID_perkiraan"];
}
