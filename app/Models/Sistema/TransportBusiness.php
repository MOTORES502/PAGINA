<?php

namespace App\Models\Sistema;

use App\Models\Empresa\Bussine;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransportBusiness extends Model
{
    use SoftDeletes;

    protected $code = 'UTF-8';
    protected $table = 'transports_business';
    protected $dates = ['deleted_at'];
    protected $casts = [
        'created_at' => 'datetime: d/m/Y h:i:s',
        'updated_at' => 'datetime: d/m/Y h:i:s',
        'deleted_at' => 'datetime: d/m/Y h:i:s',
    ];
    protected $fillable = [
        'bussines_id', 'transports_id'
    ];

    public function busine()
    {
        return $this->belongsTo(Bussine::class, 'bussines_id', 'id');
    }
}
