<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mutasi extends Model
{
    use HasFactory;
    protected $table = "mutasi";
    protected $primaryKey = "ID_mutasi";
    public $incrementing = true;
    public $timestamps = false;
    protected $guarded = ["ID_mutasi"];
}
