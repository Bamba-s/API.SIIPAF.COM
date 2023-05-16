<?php

namespace App\Models\ModelProperty;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Videos extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'link',
        'property_id',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
