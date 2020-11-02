<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Model;

class Municipality extends Model
{
    protected $code = 'UTF-8';
    protected $table = 'municipalities';
    protected $dates = ['deleted_at'];
    protected $casts = [
        'created_at' => 'datetime: d/m/Y h:i:s',
        'updated_at' => 'datetime: d/m/Y h:i:s',
        'deleted_at' => 'datetime: d/m/Y h:i:s',
    ];
    protected $fillable = [
        'name', 'departaments_id'
    ];
    protected $appends = ['country'];

    public function getCountryAttribute()
    {
        return Country::find(Departament::find($this->departaments_id)->countries_id)->name;
    }

    public function departament()
    {
        return $this->belongsTo(Departament::class, 'departaments_id', 'id');
    }
}
