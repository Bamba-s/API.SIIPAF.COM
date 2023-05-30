<?php

namespace App\Models\ModelProperty;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ModelProperty\Property;
use App\Models\ModelProperty\AreaFeatures;

class Features extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        // 'value',
        // 'unit',
        'property_id',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
    public function areaFeatures()
    {
        return $this->hasMany(AreaFeatures::class);
    }
}
