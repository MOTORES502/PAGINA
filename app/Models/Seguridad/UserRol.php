<?php

namespace App\Models\Seguridad;

use Illuminate\Database\Eloquent\Model;

class UserRol extends Model
{
    protected $code = 'UTF-8';
    protected $table = 'users_rols';
    protected $casts = [
        'created_at' => 'datetime: d/m/Y h:i:s',
        'updated_at' => 'datetime: d/m/Y h:i:s'
    ];
    protected $fillable = [
        'users_id', 'rols_id'
    ];
    protected $appends = ['name'];

    public function getNameAttribute()
    {
        return Rol::find($this->rols_id)->name;
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'rols_id', 'id');
    }
}
