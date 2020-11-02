<?php

namespace App\Models\Seguridad;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $code = 'UTF-8';
    protected $table = 'menus';
    protected $casts = [
        'hide' => 'boolean',
        'created_at' => 'datetime: d/m/Y h:i:s',
        'updated_at' => 'datetime: d/m/Y h:i:s'
    ];
    protected $fillable = [
        'name', 'route_name', 'father', 'hide', 'icon'
    ];
}
