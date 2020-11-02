<?php

namespace App\Models\Empresa;

use Illuminate\Database\Eloquent\Model;

class QuoteChannel extends Model
{
    protected $code = 'UTF-8';
    protected $table = 'quotes_channels';
    protected $casts = [
        'created_at' => 'datetime: d/m/Y h:i:s',
        'updated_at' => 'datetime: d/m/Y h:i:s'
    ];
    protected $fillable = [
        'channels_id', 'quotes_id'
    ];
}
