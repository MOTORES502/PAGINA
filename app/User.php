<?php

namespace App;

use App\Models\Persona\People;
use App\Models\Seguridad\UserRol;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    const USUARIO_ADMINISTRADOR = 'ADMINISTRADOR';
    const USUARIO_REGULAR = 'REGULAR';

    protected $table = 'users';

    protected $dates = ['deleted_at'];

    protected $fillable = ['code_user', 'email', 'admin', 'people_id', 'photo', 'observation'];

    protected $casts = [
        'created_at' => 'datetime: d/m/Y h:i:s',
        'updated_at' => 'datetime: d/m/Y h:i:s',
        'deleted_at' => 'datetime: d/m/Y h:i:s',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function setPasswordAttribute($valor)
    {
        $this->attributes['password'] = bcrypt($valor);
    }

    public function esAdministrador()
    {
        return $this->verified == User::USUARIO_ADMINISTRADOR;
    }

    public function people()
    {
        return $this->belongsTo(People::class, 'people_id', 'id');
    }

    public function users_rols()
    {
        return $this->hasMany(UserRol::class, 'users_id', 'id');
    }
}
