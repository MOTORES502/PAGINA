<?php

namespace App\Models\Sistema;

use Illuminate\Database\Eloquent\Model;

class TransportYoutube extends Model
{
    protected $code = 'UTF-8';
    protected $table = 'transports_youtube';
    protected $casts = [
        'created_at' => 'datetime: d/m/Y h:i:s',
        'updated_at' => 'datetime: d/m/Y h:i:s',
    ];
    protected $fillable = [
        'link', 'transports_id'
    ];
}
