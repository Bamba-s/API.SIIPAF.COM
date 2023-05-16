<?php

namespace App\Models\ModelProperty;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Localisation extends Model
{
    use HasFactory;

    protected $fillable = ['lat', 'lng', 'property_id'];

    public function property()
    {
        return $this->belongsTo('App\Models\Property');
    }
}

