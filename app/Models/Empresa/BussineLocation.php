<?php

namespace App\Models\Empresa;

use App\Models\Catalogos\Municipality;
use Illuminate\Database\Eloquent\Model;

class BussineLocation extends Model
{
    protected $code = 'UTF-8';
    protected $table = 'bussines_locations';
    protected $casts = [
        'created_at' => 'datetime: d/m/Y h:i:s',
        'updated_at' => 'datetime: d/m/Y h:i:s'
    ];
    protected $fillable = [
        'location', 'municipalities_id', 'bussines_id'
    ];

    public function municipality()
    {
        return $this->belongsTo(Municipality::class, 'municipalities_id', 'id');
    }
}
