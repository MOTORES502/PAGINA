<?php

namespace App\Models\Sistema;

use Illuminate\Database\Eloquent\Model;

class FAQS extends Model
{
    protected $code = 'UTF-8';
    protected $table = 'faqs';
    protected $casts = [
        'created_at' => 'datetime: d/m/Y h:i:s',
        'updated_at' => 'datetime: d/m/Y h:i:s'
    ];
    protected $fillable = [
        'question', 'reply', 'categoria_faqs_id', 'users_id'
    ];
}
