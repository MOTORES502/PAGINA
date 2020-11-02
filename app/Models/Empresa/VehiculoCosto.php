<?php

namespace App\Models\Empresa;

use App\User;
use App\Models\Catalogos\Coin;
use App\Models\Catalogos\Line;
use App\Models\Persona\People;
use App\Models\Catalogos\Brand;
use App\Models\Catalogos\Color;
use App\Models\Catalogos\Modelo;
use App\Models\Catalogos\Version;
use App\Models\Catalogos\TypePlate;
use App\Models\Catalogos\Generation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehiculoCosto extends Model
{

    use SoftDeletes;

    protected $code = 'UTF-8';
    protected $table = 'vehiculo_costo';
    protected $dates = ['deleted_at'];
    protected $casts = [
        'reservation' => 'boolean',
        'shipping' => 'boolean',
        'admission_date' => 'date: d/m/Y',
        'created_at' => 'datetime: d/m/Y h:i:s',
        'updated_at' => 'datetime: d/m/Y h:i:s',
    ];
    protected $fillable = [
        'code', 'plate_number', 'chasis', 'number_motor', 'keys', 'cilindro',
        'price_negotiate', 'observation', 'price_cost',
        'mileage', 'admission_date', 'code_auto', 'reservation', 'shipping',

        'coins_id',
        'brands_id', 'lines_id', 'generations_id', 'models_id', 'versions_id', 'colors_id', 'type_plates_id',
        'people_id', 'users_id'
    ];

    public function coin()
    {
        return $this->belongsTo(Coin::class, 'coins_id', 'id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brands_id', 'id');
    }

    public function line()
    {
        return $this->belongsTo(Line::class, 'lines_id', 'id');
    }

    public function generation()
    {
        return $this->belongsTo(Generation::class, 'generations_id', 'id');
    }

    public function model()
    {
        return $this->belongsTo(Modelo::class, 'models_id', 'id');
    }

    public function version()
    {
        return $this->belongsTo(Version::class, 'versions_id', 'id');
    }

    public function color()
    {
        return $this->belongsTo(Color::class, 'colors_id', 'id');
    }

    public function type_plate()
    {
        return $this->belongsTo(TypePlate::class, 'type_plates_id', 'id');
    }

    public function people()
    {
        return $this->belongsTo(People::class, 'people_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
}
