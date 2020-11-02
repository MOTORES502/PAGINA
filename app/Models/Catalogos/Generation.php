<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Generation extends Model
{
    use SoftDeletes;

    protected $code = 'UTF-8';
    protected $table = 'generations';
    protected $dates = ['deleted_at'];
    protected $casts = [
        'created_at' => 'datetime: d/m/Y h:i:s',
        'updated_at' => 'datetime: d/m/Y h:i:s',
        'deleted_at' => 'datetime: d/m/Y h:i:s',
    ];
    protected $fillable = [
        'name', 'start', 'end', 'lines_id'
    ];

    public function line()
    {
        return $this->belongsTo(Line::class, 'lines_id', 'id');
    }
}
