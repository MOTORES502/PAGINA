<?php

namespace App\Models\Sistema;

use Illuminate\Database\Eloquent\Model;

class TransportView extends Model
{
    const PAGINA_INICIO = 'PAGINA INICIO';
    const RECOMENDACION = 'RECOMENDACION';
    const BUSCADOR = 'BUSCADOR';
    const INVENTARIO = 'INVENTARIO';

    protected $code = 'UTF-8';
    protected $table = 'transports_views';
    protected $casts = [
        'created_at' => 'datetime: d/m/Y h:i:s',
        'updated_at' => 'datetime: d/m/Y h:i:s',
    ];
    protected $fillable = [
        'type_view', 'visitor', 'transports_id', 'anio'
    ];
}
