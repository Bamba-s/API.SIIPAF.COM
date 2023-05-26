<?php

namespace App\Models\ModelProperty;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;
    protected $fillable = ['sale', 'rent', 'property_id'];

    public function property()
    {
        return $this->belongsTo('App\Models\Property');
    }
}
