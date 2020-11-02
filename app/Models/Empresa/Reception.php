<?php

namespace App\Models\Empresa;

use App\Models\Catalogos\Batterie;
use App\Models\Catalogos\Brand;
use App\Models\Catalogos\Card;
use App\Models\Catalogos\Coin;
use App\Models\Catalogos\Color;
use App\Models\Catalogos\FuelMeasure;
use App\Models\Catalogos\Generation;
use App\Models\Catalogos\Insured;
use App\Models\Catalogos\Line;
use App\Models\Catalogos\Modelo;
use App\Models\Catalogos\TypePlate;
use App\Models\Catalogos\Version;
use App\Models\Catalogos\WorkShop;
use App\Models\Persona\People;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reception extends Model
{
    use SoftDeletes;

    protected $code = 'UTF-8';
    protected $table = 'receptions';
    protected $dates = ['deleted_at'];
    protected $casts = [
        'debt' => 'boolean',
        'hits' => 'boolean',
        'commission' => 'boolean',
        'agency_service' => 'boolean',
        'agree' => 'boolean',
        'admission_date' => 'date: d/m/Y',
        'created_at' => 'datetime: d/m/Y h:i:s',
        'updated_at' => 'datetime: d/m/Y h:i:s',
    ];
    protected $fillable = [
        'code', 'plate_number', 'debt', 'hits', 'keys', 'commission',
        'price_negotiate', 'observation', 'condition', 'evidence', 'agency_service',
        'mileage', 'admission_date', 'agree', 'email_enviado', 'base', 'code_auto',

        'fuels_measures_id', 'cards_id', 'coins_id', 'batteries_id', 'insured_id', 'workshops_id',
        'brands_id', 'lines_id', 'generations_id', 'models_id', 'versions_id', 'colors_id', 'type_plates_id',
        'people_id', 'users_id'
    ];

    protected $appends = ['fecha_envia', 'hora_envia'];

    public function getFechaEnviaAttribute()
    {
        $d = is_null($this->email_enviado) ? 'N/A' : date('d/m/Y', strtotime($this->email_enviado));
        return $d;
    }

    public function getHoraEnviaAttribute()
    {
        $d = is_null($this->email_enviado) ? 'N/A' : date('h:i:s', strtotime($this->email_enviado));
        return $d;
    }

    public function fuels_measure()
    {
        return $this->belongsTo(FuelMeasure::class, 'fuels_measures_id', 'id');
    }

    public function card()
    {
        return $this->belongsTo(Card::class, 'cards_id', 'id');
    }

    public function coin()
    {
        return $this->belongsTo(Coin::class, 'coins_id', 'id');
    }

    public function batterie()
    {
        return $this->belongsTo(Batterie::class, 'batteries_id', 'id');
    }

    public function insured()
    {
        return $this->belongsTo(Insured::class, 'insured_id', 'id');
    }

    public function workshop()
    {
        return $this->belongsTo(WorkShop::class, 'workshops_id', 'id');
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

    public function accessories()
    {
        return $this->hasMany(ReceptionAccesorie::class, 'receptions_id', 'id');
    }

    public function basic_tools()
    {
        return $this->hasMany(ReceptionBasicTool::class, 'receptions_id', 'id');
    }
}
