<?php

namespace App\Models\Empresa;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Bussine extends Model
{
    protected $code = 'UTF-8';
    protected $table = 'bussines';
    protected $casts = [
        'created_at' => 'datetime: d/m/Y h:i:s',
        'updated_at' => 'datetime: d/m/Y h:i:s'
    ];
    protected $fillable = [
        'nit', 'logo', 'name', 'longitud',
        'latitud', 'vission', 'mission', 'users_id', 'email'
    ];
    protected $appends = ['user'];

    public function getUserAttribute()
    {
        return User::find($this->users_id)->code_user;
    }

    public function location()
    {
        return $this->hasMany(BussineLocation::class, 'bussines_id', 'id');
    }

    public function phone()
    {
        return $this->hasMany(BussinePhone::class, 'bussines_id', 'id');
    }
}
