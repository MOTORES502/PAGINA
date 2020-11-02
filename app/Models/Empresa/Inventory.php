<?php

namespace App\Models\Empresa;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    const PAGINA = 'PAGINA';
    const RECEPCION = 'RECEPCION';
    const VEHICULO_COSTO = 'VEHICULO COSTO';

    protected $code = 'UTF-8';
    protected $table = 'inventories';
    protected $dates = ['deleted_at'];
    protected $casts = [
        'created_at' => 'datetime: d/m/Y h:i:s',
        'updated_at' => 'datetime: d/m/Y h:i:s'
    ];
    protected $fillable = [
        'stock', 'versions_id', 'inventory'
    ];
}
