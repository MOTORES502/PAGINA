<?php

namespace App\Models\Seguridad;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $code = 'UTF-8';
    protected $table = 'rols';
    protected $casts = [
        'created_at' => 'datetime: d/m/Y h:i:s',
        'updated_at' => 'datetime: d/m/Y h:i:s'
    ];
    protected $fillable = [
        'name'
    ];

    public function menu_rols()
    {
        return $this->hasMany(MenuRol::class, 'rols_id', 'id');
    }
}
