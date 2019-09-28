<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        "is_coocked",
        "avatar",
        'password',
    ];

    public function findForPassport($phone){
        return $this->where('name', $phone)->first();
    }

    public function address(){
        return $this->hasOne("App\Address");
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    public function menu(){
        return $this->hasMany("App\Menu");
    }

    protected $hidden = [
        'password',"remember_token",
    ];

    
}
