<?php

namespace App\Models\Sistema;

use App\Models\Catalogos\SubCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransportSubCategory extends Model
{
    use SoftDeletes;

    protected $code = 'UTF-8';
    protected $table = 'sub_categories_transports';
    protected $dates = ['deleted_at'];
    protected $casts = [
        'created_at' => 'datetime: d/m/Y h:i:s',
        'updated_at' => 'datetime: d/m/Y h:i:s',
        'deleted_at' => 'datetime: d/m/Y h:i:s',
    ];
    protected $fillable = [
        'sub_categories_id', 'transports_id', 'option'
    ];

    public function sub()
    {
        return $this->belongsTo(SubCategory::class, 'sub_categories_id', 'id');
    }
}
