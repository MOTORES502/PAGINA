<?php

namespace App\Models\Empresa;

use App\Models\Persona\TypePhone;
use Illuminate\Database\Eloquent\Model;

class BussinePhone extends Model
{
    protected $code = 'UTF-8';
    protected $table = 'bussines_phones';
    protected $casts = [
        'created_at' => 'datetime: d/m/Y h:i:s',
        'updated_at' => 'datetime: d/m/Y h:i:s'
    ];
    protected $fillable = [
        'number', 'type_phone_id', 'bussines_id', 'contact'
    ];
    protected $appends = ['type'];

    public function getTypeAttribute()
    {
        return TypePhone::find($this->type_phone_id)->name;
    }

    public function typephone()
    {
        return $this->belongsTo(TypePhone::class, 'type_phone_id', 'id');
    }
}
