<?php

namespace App\Models\Sistema;

use App\User;
use Illuminate\Database\Eloquent\Model;

class TransportUpdate extends Model
{
    protected $code = 'UTF-8';
    protected $table = 'transports_update';
    protected $casts = [
        'created_at' => 'datetime: d/m/Y h:i:s',
        'updated_at' => 'datetime: d/m/Y h:i:s'
    ];

    protected $fillable = [
        'table', 'register', 'users_id', 'transports_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
}
