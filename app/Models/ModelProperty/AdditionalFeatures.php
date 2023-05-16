<?php

namespace App\Models\ModelProperty;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalFeatures extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'value', 'property_id'];

    public function property()
    {
        return $this->belongsTo('App\Models\Property');
    }

}
