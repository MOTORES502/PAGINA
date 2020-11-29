<?php

namespace App\Models\Sistema;

use Illuminate\Database\Eloquent\Model;

class Comparation extends Model
{
    protected $code = 'UTF-8';
    protected $table = 'comparations';
    protected $casts = [
        'created_at' => 'datetime: d/m/Y h:i:s',
        'updated_at' => 'datetime: d/m/Y h:i:s'
    ];
    protected $fillable = [
        'one_id', 'two_id', 'visitor'
    ];
}
