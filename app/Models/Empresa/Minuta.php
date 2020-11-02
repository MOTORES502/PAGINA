<?php

namespace App\Models\Empresa;

use App\Models\Catalogos\Bank;
use App\Models\Catalogos\Coin;
use App\Models\Persona\People;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Minuta extends Model
{
    protected $code = 'UTF-8';
    protected $table = 'minuta';
    protected $casts = [
        'fecha' => 'date: d/m/Y',
        'created_at' => 'datetime: d/m/Y h:i:s',
        'updated_at' => 'datetime: d/m/Y h:i:s',
    ];
    protected $fillable = [
        'code', 'fecha', 'cambio', 'precio', 'total', 'observacion',
        'placa', 'marca', 'modelo', 'linea', 'predio', 'gerente', 'cliente_firma',
        'anticipo', 'financiamiento', 'avaluo', 'recibido', 'saldo', 'code_auto',

        'coins_id', 'bank_id', 'vehiculo_costo_id', 'reservations_id', 'proveedor_id',
        'cliente_id', 'users_id'
    ];

    protected $appends = ['fecha_minuta'];

    public function getFechaMinutaAttribute()
    {
        return date('Y-m-d', strtotime($this->fecha));
    }

    public function coin()
    {
        return $this->belongsTo(Coin::class, 'coins_id', 'id');
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id', 'id');
    }

    public function vehiculo()
    {
        return $this->belongsTo(VehiculoCosto::class, 'vehiculo_costo_id', 'id');
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'reservations_id', 'id');
    }

    public function proveedor()
    {
        return $this->belongsTo(People::class, 'proveedor_id', 'id');
    }

    public function cliente()
    {
        return $this->belongsTo(People::class, 'cliente_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    public function accesorios()
    {
        return $this->hasMany(MinutaAccesorio::class, 'minuta_id', 'id');
    }
}
