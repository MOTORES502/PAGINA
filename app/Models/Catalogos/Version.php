<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Version extends Model
{
    use SoftDeletes;

    protected $code = 'UTF-8';
    protected $table = 'versions';
    protected $dates = ['deleted_at'];
    protected $casts = [
        'created_at' => 'datetime: d/m/Y h:i:s',
        'updated_at' => 'datetime: d/m/Y h:i:s',
        'deleted_at' => 'datetime: d/m/Y h:i:s',
    ];
    protected $fillable = [
        'name', 'models_id'
    ];

    public function model()
    {
        return $this->belongsTo(Modelo::class, 'models_id', 'id');
    }
}
