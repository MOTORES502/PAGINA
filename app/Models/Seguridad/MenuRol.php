<?php

namespace App\Models\Seguridad;

use Illuminate\Database\Eloquent\Model;

class MenuRol extends Model
{
    protected $code = 'UTF-8';
    protected $table = 'menu_rols';
    protected $casts = [
        'created_at' => 'datetime: d/m/Y h:i:s',
        'updated_at' => 'datetime: d/m/Y h:i:s'
    ];
    protected $fillable = [
        'rols_id', 'menus_id'
    ];

    public function menus()
    {
        return $this->belongsTo(Menu::class);
    }
}
