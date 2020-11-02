<?php

namespace App\Models\Empresa;

use App\User;
use Illuminate\Database\Eloquent\Model;

class QuoteSent extends Model
{
    protected $code = 'UTF-8';
    protected $table = 'quotes_sent';
    protected $casts = [
        'created_at' => 'datetime: d/m/Y h:i:s',
        'updated_at' => 'datetime: d/m/Y h:i:s'
    ];
    protected $fillable = [
        'quotes_id', 'users_id', 'correlative', 'code'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
}
