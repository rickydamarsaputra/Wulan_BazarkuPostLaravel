<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Role;
use App\Models\Divisi;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = "user";
    protected $primaryKey = "ID_user";
    public $incrementing = true;
    public $timestamps = false;
    protected $guarded = ["ID_user"];

    public function role()
    {
        return $this->hasOne(Role::class, 'ID_role', 'ID_role');
    }

    public function divisi()
    {
        return $this->hasOne(Divisi::class, 'ID_divisi', 'ID_divisi');
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    // protected $hidden = [
    //     'password',
    //     'remember_token',
    // ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];
}
