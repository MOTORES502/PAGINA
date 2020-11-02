<?php

namespace App\Models\Sistema;

use App\Models\Catalogos\Coin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransportOffer extends Model
{
    use SoftDeletes;

    protected $code = 'UTF-8';
    protected $table = 'transports_offers';
    protected $dates = ['deleted_at'];
    protected $casts = [
        'active' => 'boolean',
        'created_at' => 'datetime: d/m/Y h:i:s',
        'updated_at' => 'datetime: d/m/Y h:i:s',
        'deleted_at' => 'datetime: d/m/Y h:i:s',
    ];
    protected $fillable = [
        'active', 'price_offer', 'transports_id', 'coins_id', 'people_id'
    ];

    public function coin()
    {
        return $this->belongsTo(Coin::class, 'coins_id', 'id');
    }
}
