<?php

namespace App\Models\Empresa;

use App\User;
use App\Models\Persona\People;
use Illuminate\Database\Eloquent\Model;

class Gasto extends Model
{
    protected $code = 'UTF-8';
    protected $table = 'gastos';
    protected $casts = [
        'created_at' => 'datetime: d/m/Y h:i:s',
        'updated_at' => 'datetime: d/m/Y h:i:s'
    ];
    protected $fillable = [
        'description', 'price', 'vehiculo_costo_id', 'people_id',
        'users_id'
    ];

    public function people()
    {
        return $this->belongsTo(People::class, 'people_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
}
