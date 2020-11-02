<?php

namespace App\Models\Sistema;

use App\Models\Persona\People;
use Illuminate\Database\Eloquent\Model;

class Prospect extends Model
{
    protected $code = 'UTF-8';
    protected $table = 'prospects';
    protected $casts = [
        'created_at' => 'datetime: d/m/Y h:i:s',
        'updated_at' => 'datetime: d/m/Y h:i:s'
    ];
    protected $fillable = [
        'code_prospect', 'code_client', 'people_id'
    ];

    public function people()
    {
        return $this->belongsTo(People::class, 'people_id', 'id');
    }
}
