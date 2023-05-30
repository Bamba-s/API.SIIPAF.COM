<?php

namespace App\Models\ModelProperty;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaProperty extends Model
{
    use HasFactory;
    public $table = 'areaProperties';
    protected $fillable = ['ground', 'used', 'unit', 'property_id'];

    public function property()
    {
        return $this->belongsTo('App\Models\Property');
    }
}
