<?php

namespace App\Models\Persona;

use App\Models\Sistema\Prospect;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    const MASCULINO = 'MASCULINO';
    const FEMENINO = 'FEMENINO';
    const SOLTERO = 'SOLTERO';
    const CASADO = 'CASADO';

    protected $code = 'UTF-8';
    protected $table = 'people';
    protected $casts = [
        'created_at' => 'datetime: d/m/Y h:i:s',
        'updated_at' => 'datetime: d/m/Y h:i:s'
    ];
    protected $fillable = [
        'names', 'surnames', 'email', 'date_birth', 'gender', 
        'civil_status', 'business', 'provider', 'notify',
        'dpi', 'nit', 'direccion'
    ];
    protected $appends = ['concat_name','age'];

    public function getConcatNameAttribute()
    {
        return "{$this->names} {$this->surnames}";
    }

    public function getAgeAttribute()
    {
        return Carbon::parse($this->date_birth)->age;
    }

    public function people_phones()
    {
        return $this->hasMany(PeoplePhone::class, 'people_id', 'id');
    }

    public function client()
    {
        return $this->hasOne(Prospect::class, 'people_id', 'id');
    }
}
