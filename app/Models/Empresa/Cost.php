<?php

namespace App\Models\Empresa;

use App\Models\Persona\People;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Cost extends Model
{
    protected $code = 'UTF-8';
    protected $table = 'cost';
    protected $casts = [
        'created_at' => 'datetime: d/m/Y h:i:s',
        'updated_at' => 'datetime: d/m/Y h:i:s'
    ];
    protected $fillable = [
        'description', 'price', 'receptions_id', 'people_id',
        'users_id'
    ];

    public function people()
    {
        return $this->belongsTo(People::class, 'people_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
}
