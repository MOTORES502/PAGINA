<?php

namespace App\Models\Sistema;

use App\Models\Catalogos\Fabrication;
use App\Models\Catalogos\Rendimiento;
use App\Models\Catalogos\Traction;
use App\Models\Catalogos\Transmision;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransportEngineer extends Model
{
    use SoftDeletes;

    protected $code = 'UTF-8';
    protected $table = 'transports_engineers';
    protected $dates = ['deleted_at'];
    protected $casts = [
        'created_at' => 'datetime: d/m/Y h:i:s',
        'updated_at' => 'datetime: d/m/Y h:i:s',
        'deleted_at' => 'datetime: d/m/Y h:i:s',
    ];
    protected $fillable = [
        'description',

        'transports_id', 'tractions_id', 'transmisions_id', 'yields_id', 'fabrications_id'
    ];

    public function traction()
    {
        return $this->belongsTo(Traction::class, 'tractions_id', 'id');
    }

    public function transmision()
    {
        return $this->belongsTo(Transmision::class, 'transmisions_id', 'id');
    }

    public function yield()
    {
        return $this->belongsTo(Rendimiento::class, 'yields_id', 'id');
    }

    public function fabrication()
    {
        return $this->belongsTo(Fabrication::class, 'fabrications_id', 'id');
    }
}
