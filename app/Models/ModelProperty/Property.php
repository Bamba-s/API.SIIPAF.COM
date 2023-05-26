<?php

namespace App\Models\ModelProperty;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/*use App\Models\ModelProperty\Features;
use App\Models\ModelProperty\AreaFeatures;
use App\Models\ModelProperty\PaymentDeadline;
use App\Models\ModelProperty\DeliveryTime;
use App\Models\ModelProperty\AreaProperty;*/

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'desc', 'propertyType', 'projectTitle', 'propertyStatus', 'formattedAddress', 
        'featured', 'initialContributionPercentage', 'monthlyPayment', 
        'bedrooms', 'rooms',
    ];


    public function price()
    {
        return $this->hasMany(Price::class);
    }
    public function localisation()
    {
        return $this->hasMany(Localisation::class);
    }

    public function features()
    {
        return $this->hasMany(Features::class);
    }
    
    public function areaFeatures()
    {
        return $this->hasMany(AreaFeatures::class);
    }

    public function paymentDeadline()
    {
        return $this->hasMany(PaymentDeadline::class);
    }

    public function deliveryTime()
    {
        return $this->hasMany(DeliveryTime::class);
    }

    public function areaProperty()
    {
        return $this->hasOne(AreaProperty::class);
    }

    public function additionalFeatures()
    {
        return $this->hasMany(AdditionalFeatures::class);
    }

    public function gallery()
    {
        return $this->hasMany(Gallery::class);
    }

    public function plans()
    {
        return $this->hasMany(Plans::class);
    }

    public function videos()
    {
        return $this->hasMany(Videos::class);
    }
}
