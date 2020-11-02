<?php

namespace App\Models\Sistema;

use App\Models\Catalogos\Brand;
use App\Models\Catalogos\Category;
use App\Models\Catalogos\Coin;
use App\Models\Catalogos\Color;
use App\Models\Catalogos\Fuel;
use App\Models\Catalogos\Generation;
use App\Models\Catalogos\Line;
use App\Models\Catalogos\Modelo;
use App\Models\Catalogos\Origin;
use App\Models\Catalogos\TypePlate;
use App\Models\Catalogos\Version;
use App\Models\Persona\People;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transport extends Model
{
    use SoftDeletes;

    const DISPONIBLE = 'DISPONIBLE';
    const RESERVADO = 'RESERVADO';
    const VENDIDO = 'VENDIDO';

    protected $code = 'UTF-8';
    protected $table = 'transports';
    protected $dates = ['deleted_at'];
    protected $casts = [
        'created_at' => 'datetime: d/m/Y h:i:s',
        'updated_at' => 'datetime: d/m/Y h:i:s',
        'deleted_at' => 'datetime: d/m/Y h:i:s',
    ];
    protected $fillable = [
        'correlative', 'code', 'price_publisher', 'price_base',
        'keys', 'agency_service', 'mileage', 'prox_mileage', 'plate_number', 
        'status', 'pair', 'viejo_id', 'admission_date', 'nomenclatura', 'name_complete',

        'brands_id', 'lines_id', 'generations_id', 'models_id', 'versions_id',
        'fuels_id', 'coins_id', 'colors_id', 'type_plates_id',
        'people_id', 'origins_id', 'users_id', 'categories_id'
    ];

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

    public function fuel()
    {
        return $this->belongsTo(Fuel::class, 'fuels_id', 'id');
    }

    public function coin()
    {
        return $this->belongsTo(Coin::class, 'coins_id', 'id');
    }

    public function color()
    {
        return $this->belongsTo(Color::class, 'colors_id', 'id');
    }

    public function type_plate()
    {
        return $this->belongsTo(TypePlate::class, 'type_plates_id', 'id');
    }

    public function provider()
    {
        return $this->belongsTo(People::class, 'people_id', 'id');
    }

    public function origin()
    {
        return $this->belongsTo(Origin::class, 'origins_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'categories_id', 'id');
    }

    public function images()
    {
        return $this->hasMany(TransportImage::class, 'transports_id', 'id');
    }

    public function engineer()
    {
        return $this->hasMany(TransportEngineer::class, 'transports_id', 'id');
    }

    public function security()
    {
        return $this->hasMany(TransportSecurity::class, 'transports_id', 'id');
    }

    public function mod_con()
    {
        return $this->hasMany(TransportModCon::class, 'transports_id', 'id');
    }

    public function additional()
    {
        return $this->hasMany(TransportAdditional::class, 'transports_id', 'id');
    }

    public function offers()
    {
        return $this->hasMany(TransportOffer::class, 'transports_id', 'id');
    }

    public function videos()
    {
        return $this->hasMany(TransportYoutube::class, 'transports_id', 'id');
    }

    public function subs()
    {
        return $this->hasMany(TransportSubCategory::class, 'transports_id', 'id');
    }

    public function views()
    {
        return $this->hasMany(TransportView::class, 'transports_id', 'id');
    }

    public function updates()
    {
        return $this->hasMany(TransportUpdate::class, 'transports_id', 'id');
    }

    public function differences()
    {
        return $this->hasMany(TransportDifference::class, 'transports_id', 'id');
    }

    public function business()
    {
        return $this->hasMany(TransportBusiness::class,'transports_id', 'id');
    }
}
