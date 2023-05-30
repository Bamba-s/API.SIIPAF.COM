<?php

namespace App\Models\ModelProperty;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ModelProperty\Plans;

class AreaPlans extends Model
{
    use HasFactory;
    public $table = 'areaPlans';
    
    protected $fillable = ['value', 'unit','plans_id', 'property_id'];

    public function plan()
    {
        return $this->belongsTo(Plans::class);
    }
}
