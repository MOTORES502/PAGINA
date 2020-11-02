<?php

namespace App\Models\Empresa;

use App\Models\Catalogos\Bank;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $code = 'UTF-8';
    protected $table = 'document';
    protected $casts = [
        'fecha' => 'date: d/m/Y',
        'created_at' => 'datetime: d/m/Y h:i:s',
        'updated_at' => 'datetime: d/m/Y h:i:s',
    ];
    protected $fillable = [
        'numero',
        'fecha',

        'advances_id', 'bank_id'
    ];

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id', 'id');
    }
}
