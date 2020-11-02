<?php

namespace App\Models\Sistema;

use App\Models\Catalogos\Difference;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransportDifference extends Model
{
    use SoftDeletes;

    protected $code = 'UTF-8';
    protected $table = 'transports_differences';
    protected $dates = ['deleted_at'];
    protected $casts = [
        'created_at' => 'datetime: d/m/Y h:i:s',
        'updated_at' => 'datetime: d/m/Y h:i:s',
        'deleted_at' => 'datetime: d/m/Y h:i:s',
    ];
    protected $fillable = [
        'differences_id', 'transports_id'
    ];

    public function difference()
    {
        return $this->belongsTo(Difference::class, 'differences_id', 'id');
    }
}
