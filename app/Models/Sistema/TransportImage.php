<?php

namespace App\Models\Sistema;

use Illuminate\Database\Eloquent\Model;

class TransportImage extends Model
{
    protected $code = 'UTF-8';
    protected $table = 'transports_images';
    protected $casts = [
        'created_at' => 'datetime: d/m/Y h:i:s',
        'updated_at' => 'datetime: d/m/Y h:i:s',
    ];
    protected $fillable = [
        'image', 'order', 'concat', 'transports_id', 'viejo_id'
    ];
}
