<?php

namespace App\Models\Persona;

use Illuminate\Database\Eloquent\Model;

class TypePhone extends Model
{
    protected $code = 'UTF-8';
    protected $table = 'type_phone';
    protected $casts = [
        'created_at' => 'datetime: d/m/Y h:i:s',
        'updated_at' => 'datetime: d/m/Y h:i:s'
    ];
    protected $fillable = [
        'name'
    ];
}
