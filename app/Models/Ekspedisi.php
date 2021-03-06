<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ekspedisi extends Model
{
    use HasFactory;
    protected $table = "ekspedisi";
    protected $primaryKey = "ID_ekspedisi";
    protected $guarded = ["ID_ekspedisi"];
    public $incrementing = true;
    public $timestamps = false;
}
