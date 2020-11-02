<?php

namespace App\Models\Empresa;

use Illuminate\Database\Eloquent\Model;

class MinutaAccesorio extends Model
{
    protected $code = 'UTF-8';
    protected $table = 'minuta_accesorio';
    protected $casts = [
        'created_at' => 'datetime: d/m/Y h:i:s',
        'updated_at' => 'datetime: d/m/Y h:i:s',
    ];
    protected $fillable = [
        'nombre', 'monto',

        'minuta_id'
    ];
}
