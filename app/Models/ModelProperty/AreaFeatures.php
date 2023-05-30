<?php

namespace App\Models\ModelProperty;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ModelProperty\Features;

class AreaFeatures extends Model
{
    use HasFactory;
    public $table = 'areaFeatures';
    
    protected $fillable = ['value', 'unit', 'features_id', 'property_id'];

    public function features()
    {
         return $this->belongsTo(Features::class);
       // return $this->belongsTo('App\Models\ModelProperty\Features');
    }
}
