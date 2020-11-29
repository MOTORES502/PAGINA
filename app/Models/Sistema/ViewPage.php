<?php

namespace App\Models\Sistema;

use Illuminate\Database\Eloquent\Model;

class ViewPage extends Model
{
    protected $code = 'UTF-8';
    protected $table = 'views';
    protected $casts = [
        'created_at' => 'datetime: d/m/Y h:i:s',
        'updated_at' => 'datetime: d/m/Y h:i:s'
    ];
    protected $fillable = [
        'anio', 'visitor'
    ];
}
