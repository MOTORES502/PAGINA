<?php

namespace App\Models\Sistema;

use App\User;
use App\Models\Sistema\Prospect;
use App\Models\Sistema\Transport;
use Illuminate\Database\Eloquent\Model;

class TestDrive extends Model
{
    protected $code = 'UTF-8';
    protected $table = 'test_drive';
    protected $casts = [
        'created_at' => 'datetime:d/m/Y h:i:s',
        'updated_at' => 'datetime:d/m/Y h:i:s',
        'date_time' => 'datetime:d/m/Y h:i:s'
    ];
    protected $fillable = [
        'email', 'name', 'number', 'date_time', 'observation', 'users_id', 'transports_id', 'prospects_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    public function transport()
    {
        return $this->belongsTo(Transport::class, 'transports_id', 'id');
    }

    public function prospect()
    {
        return $this->belongsTo(Prospect::class, 'prospects_id', 'id');
    }
}
