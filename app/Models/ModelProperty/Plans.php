<?php

namespace App\Models\ModelProperty;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ModelProperty\AreaPlans;

class Plans extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'desc', 'image'];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function areaPlans()
    {
        return $this->hasMany(AreaPlans::class);
    }
}
