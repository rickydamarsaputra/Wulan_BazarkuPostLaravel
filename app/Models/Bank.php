<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Brangkas;

class Bank extends Model
{
    use HasFactory;
    protected $table = "bank";
    protected $primaryKey = "ID_bank";
    public $incrementing = true;
    public $timestamps = false;
    protected $guarded = ["ID_bank "];

    public function brangkas()
    {
        return $this->hasMany(Brangkas::class, 'ID_bank', 'ID_bank');
    }
}
