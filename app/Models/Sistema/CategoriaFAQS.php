<?php

namespace App\Models\Sistema;

use Illuminate\Database\Eloquent\Model;

class CategoriaFAQS extends Model
{
    protected $code = 'UTF-8';
    protected $table = 'categoria_faqs';
    protected $casts = [
        'created_at' => 'datetime: d/m/Y h:i:s',
        'updated_at' => 'datetime: d/m/Y h:i:s'
    ];
    protected $fillable = [
        'name'
    ];
}
