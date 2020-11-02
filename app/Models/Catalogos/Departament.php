<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Model;

class Departament extends Model
{
    protected $code = 'UTF-8';
    protected $table = 'departaments';
    protected $casts = [
        'created_at' => 'datetime: d/m/Y h:i:s',
        'updated_at' => 'datetime: d/m/Y h:i:s'
    ];
    protected $fillable = [
        'name', 'countries_id'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class, 'countries_id', 'id');
    }
}
