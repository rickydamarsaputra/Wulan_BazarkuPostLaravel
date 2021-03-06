<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;
    protected $table = "pelanggan";
    protected $primaryKey = "ID_pelanggan";
    public $incrementing = true;
    public $timestamps = false;
    protected $guarded = ["ID_pelanggan"];
}
