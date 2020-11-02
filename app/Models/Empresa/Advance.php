<?php

namespace App\Models\Empresa;

use App\Models\Catalogos\Coin;
use App\Models\Catalogos\PaymentMethod;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Advance extends Model
{
    protected $code = 'UTF-8';
    protected $table = 'advances';
    protected $casts = [
        'document' => 'boolean',
        'created_at' => 'datetime: d/m/Y h:i:s',
        'updated_at' => 'datetime: d/m/Y h:i:s',
    ];
    protected $fillable = [
        'deposit', 'observation', 'document', 'exchange_rate', 'conversion', 'resta',

        'reservations_id', 'users_id', 'payment_methods_id', 'coins_id'
    ];

    protected $appends = ['precio_formato'];

    public function getPrecioFormatoAttribute()
    {
        $precio = number_format($this->deposit, 2, '.', ',');
        $moneda = Coin::find($this->coins_id);
        return "{$moneda->symbol} {$precio}";
    }

    public function documento()
    {
        return $this->belongsTo(Document::class, 'advances_id', 'id');
    }

    public function payment_methods()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_methods_id', 'id');
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'reservations_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
}
