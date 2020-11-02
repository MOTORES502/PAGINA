<?php

namespace App\Models\Empresa;

use App\Models\Catalogos\BasicTool;
use Illuminate\Database\Eloquent\Model;

class ReceptionBasicTool extends Model
{
    protected $code = 'UTF-8';
    protected $table = 'receptions_basic_tools';
    protected $casts = [
        'created_at' => 'datetime: d/m/Y h:i:s',
        'updated_at' => 'datetime: d/m/Y h:i:s'
    ];
    protected $fillable = [
        'receptions_id', 'basic_tools_id'
    ];

    public function basic_tool()
    {
        return $this->belongsTo(BasicTool::class, 'basic_tools_id', 'id');
    }
}
