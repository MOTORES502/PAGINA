<?php

namespace App\Models\Empresa;

use App\Models\Sistema\Prospect;
use App\Models\Sistema\Transport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $code = 'UTF-8';
    protected $table = 'quotes';
    protected $casts = [
        'sent' => 'boolean',
        'created_at' => 'datetime: d/m/Y h:i:s',
        'updated_at' => 'datetime: d/m/Y h:i:s'
    ];
    protected $fillable = [
        'email', 'sent', 'transports_id', 'prospects_id', 'body', 'note', 'price', 'moneda'
    ];
    

    public function transport()
    {
        return $this->belongsTo(Transport::class, 'transports_id', 'id');
    }

    public function prospect()
    {
        return $this->belongsTo(Prospect::class, 'prospects_id', 'id');
    }

    public function quote_sente()
    {
        return $this->hasOne(QuoteSent::class, 'quotes_id', 'id');
    }
}
