<?php

namespace App\Models\Sistema;

use App\Models\Catalogos\Municipality;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $code = 'UTF-8';
    protected $table = 'customers';
    protected $casts = [
        'created_at' => 'datetime: d/m/Y h:i:s',
        'updated_at' => 'datetime: d/m/Y h:i:s'
    ];
    protected $fillable = [
        'business_name', 'nit', 'location', 'observation', 'municipalities_id', 
        'business_client_id', 'type_client_id', 'prospects_id'
    ];
    protected $appends = ['business', 'client'];

    public function getBusinessAttribute()
    {
        return BusinessClient::find($this->business_client_id)->name;
    }

    public function getClientAttribute()
    {
        return TypeClient::find($this->type_client_id)->name;
    }

    public function prospects()
    {
        return $this->belongsTo(Prospect::class);
    }

    public function municipalities()
    {
        return $this->belongsTo(Municipality::class);
    }
}
