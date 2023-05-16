<?php

namespace App\Models\ModelProperty;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = ['small', 'medium', 'big'];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
