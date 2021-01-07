<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $table = "supplier";
    protected $primaryKey = "ID_supplier";
    public $incrementing = true;
    public $timestamps = false;
    protected $guarded = ["ID_supplier"];
}
