<?php

namespace App\Models\Empresa;

use App\Models\Catalogos\Accessorie;
use Illuminate\Database\Eloquent\Model;

class ReceptionAccesorie extends Model
{
    protected $code = 'UTF-8';
    protected $table = 'receptions_accessories';
    protected $casts = [
        'created_at' => 'datetime: d/m/Y h:i:s',
        'updated_at' => 'datetime: d/m/Y h:i:s'
    ];
    protected $fillable = [
        'receptions_id', 'accessories_id'
    ];

    public function accessorie()
    {
        return $this->belongsTo(Accessorie::class, 'accessories_id', 'id');
    }
}
