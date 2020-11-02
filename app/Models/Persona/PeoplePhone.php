<?php

namespace App\Models\Persona;

use Illuminate\Database\Eloquent\Model;

class PeoplePhone extends Model
{
    protected $code = 'UTF-8';
    protected $table = 'people_phones';
    protected $casts = [
        'created_at' => 'datetime: d/m/Y h:i:s',
        'updated_at' => 'datetime: d/m/Y h:i:s'
    ];
    protected $fillable = [
        'people_id', 'type_phone_id', 'number'
    ];
    protected $appends = ['type'];

    public function getTypeAttribute()
    {
        return TypePhone::find($this->type_phone_id)->name;
    }

    public function type_phone()
    {
        return $this->belongsTo(TypePhone::class, 'type_phone_id', 'id');
    }
}
