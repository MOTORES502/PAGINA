<?php

namespace App\Models\Sistema;

use Illuminate\Database\Eloquent\Model;

class CodeAuto extends Model
{
    const PAGINA = 'PAGINA';
    const RECEPCION = 'RECEPCION';
    const VEHICULO_COSTO = 'VEHICULO/COSTO';

    protected $code = 'UTF-8';
    protected $table = 'code_auto';
    protected $casts = [
        'created_at' => 'datetime: d/m/Y h:i:s',
        'updated_at' => 'datetime: d/m/Y h:i:s'
    ];
    protected $fillable = [
        'correlative', 'nomenclatura', 'code', 'generado'
    ];
}
