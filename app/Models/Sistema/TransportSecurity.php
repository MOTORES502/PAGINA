<?php

namespace App\Models\Sistema;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransportSecurity extends Model
{
    use SoftDeletes;

    protected $code = 'UTF-8';
    protected $table = 'transports_securities';
    protected $dates = ['deleted_at'];
    protected $casts = [
        'created_at' => 'datetime: d/m/Y h:i:s',
        'updated_at' => 'datetime: d/m/Y h:i:s',
        'deleted_at' => 'datetime: d/m/Y h:i:s',
    ];
    protected $fillable = [
        'description', 'transports_id'
    ];
}
