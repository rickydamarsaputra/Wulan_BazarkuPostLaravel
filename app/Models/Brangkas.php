<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brangkas extends Model
{
    use HasFactory;
    protected $table = "brangkas";
    protected $primaryKey = "ID_brangkas";
    protected $guarded = ["ID_brangkas"];
    public $incrementing = true;
    public $timestamps = false;
}
