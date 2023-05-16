<?php

namespace App\Models\ModelProperty;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryTime extends Model
{
    use HasFactory;

    protected $fillable = ['value', 'unit', 'property_id'];

    public function property()
    {
        return $this->belongsTo('App\Models\Property');
    }
}
