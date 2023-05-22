<?php

namespace App\Http\Controllers\PropertyCtrllers;

use App\Http\Controllers\Controller;
use App\Models\ModelProperty\AdditionalFeatures;
use App\Models\ModelProperty\AreaFeatures;
use App\Models\ModelProperty\AreaPlans;
use App\Models\ModelProperty\AreaProperty;
use App\Models\ModelProperty\DeliveryTime;
use App\Models\ModelProperty\Features;
use App\Models\ModelProperty\Gallery;
use App\Models\ModelProperty\Localisation;
use App\Models\ModelProperty\PaymentDeadline;
use App\Models\ModelProperty\Plans;
use App\Models\ModelProperty\Property;
use App\Models\ModelProperty\Videos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class CreateController extends Controller
{
    //
    public function create(Request $request)
    {
        DB::beginTransaction();

        try {
            // Check if property with the same target data in the database
            $property = Property::where(
                'title', $request->input('title'))
                ->where('desc', $request->input('desc'))
                ->where('formattedAddress', $request->input('formattedAddress'))
                ->where('price_sale', $request->input('price_sale'))
                ->where('price_rent', $request->input('price_rent'))
                ->first();

            if (!$property) {
                // If property doesn't exist, create a new one
                $validatedData = $request->validate([
                    'title' => 'required|string|max:255',
                    'desc' => 'required|string|max:1000',
                    'propertyType' => 'required|string|max:255',
                    'projectTitle' => 'required|string|max:255',
                    'propertyStatus' => 'required|string|max:255',
                    'formattedAddress' => 'required|string|max:255',
                    'featured' => 'required|boolean',
                    'price_sale' => 'required|numeric',
                    'price_rent' => 'required|numeric',
                    'initialContribution_percentage' => 'required|integer',
                    'monthlyPayment' => 'required|numeric',
                    'bedrooms' => 'required|integer',
                    'rooms' => 'required|integer',
                    'localisation.lat' => 'required|numeric',
                    'localisation.lng' => 'required|numeric',
                    'features' => 'array',
                    'features.*.name' => 'required|string|max:255',
                    'features.*.value' => 'required|string|max:255',
                    'features.*.unit' => 'required|string|max:255',
                    'paymentDeadline.value' => 'required|numeric',
                    'paymentDeadline.unit' => 'required|string|max:255',
                    'deliveryTime.value' => 'required|numeric',
                    'deliveryTime.unit' => 'required|string|max:255',
                    'areaProperty.ground' => 'required|numeric',
                    'areaProperty.used' => 'required|numeric',
                    'areaProperty.unit' => 'required|string|max:255',
                    'additionalFeatures' => 'array',
                    'additionalFeatures.*.name' => 'required|string|max:255',
                    'additionalFeatures.*.value' => 'required|string|max:255',
                    'gallery' => 'array',
                    'gallery.*.small' => 'required|max:2048',
                    'gallery.*.medium' => 'required|max:2048',
                    'gallery.*.big' => 'required|max:2048', 
                    'plans' => 'array',
                    'plans.*.name' => 'required|string|max:255',
                    'plans.*.desc' => 'required|string|max:1000',
                    'plans.*.image' => 'required|max:2048',
                    'plans.*.value' => 'required|numeric',
                    'plans.*.unit' => 'required|string|max:255',
                    'videos' => 'array',
                    'videos.*.name' => 'required|string|max:255',
                    'videos.*.link' => 'required|string|max:255',
                ]);

                // Create Property
                $property = Property::create($validatedData);

                //Localisation
                if ($request->has('localisation')) {
                    $localisationData = $request->input('localisation');
                    $localisation = new Localisation([
                        'lat' => $localisationData['lat'],
                        'lng' => $localisationData['lng'],
                        
                    ]);
                    $property->localisation()->save($localisation);
                }

                // Add property features
                if (isset($validatedData['features'])) {
                    foreach ($validatedData['features'] as $featureData) {
                        $feature = new Features([
                            'name' => $featureData['name'],
                        ]);
                        $property->features()->save($feature);

                        $areaFeature = new AreaFeatures([
                            'value' => $featureData['value'],
                            'unit' => $featureData['unit'],
                            'property_id' => $property->id,
                            'features_id' => $feature->id,
                        ]);
                        $feature->areaFeatures()->save($areaFeature);
                    }
                }

                // Payment Dealine
                if ($request->has('paymentDeadline')) {
                    $paymentDeadlineData = $request->input('paymentDeadline');
                    $paymentDeadline = new PaymentDeadline([
                        'value' => $paymentDeadlineData['value'],
                        'unit' => $paymentDeadlineData['unit'],
                        'property_id' => $property->id,
                    ]);
                    $property->paymentDeadline()->save($paymentDeadline);
                }

                //Delivrery Time
                $deliveryTimeData = $request->input('deliveryTime');
                $deliveryTime = new DeliveryTime([
                    'value' => $deliveryTimeData['value'],
                    'unit' => $deliveryTimeData['unit'],
                ]);
                $property->deliveryTime()->save($deliveryTime);

               // Area Property
                $areaPropertyData = $request->input('areaProperty');
                $areaProperty = new AreaProperty([
                    'ground' => $areaPropertyData['ground'],
                    'used' => $areaPropertyData['used'],
                    'unit' => $areaPropertyData['unit'],
                ]);
                $property->areaProperty()->save($areaProperty);

               // Additional Features
                if (isset($validatedData['additionalFeatures'])) {
                    foreach ($validatedData['additionalFeatures'] as $featureData) {
                        $additionalFeature = new AdditionalFeatures([
                            'name' => $featureData['name'],
                            'value' => $featureData['value'],
                        ]);
                        $property->additionalFeatures()->save($additionalFeature);
                    }
                }
              
                //Gallery
                if (isset($validatedData['gallery'])) {
                    foreach ($validatedData['gallery'] as $imageData) {
                        $smallImage = $imageData['small'];
                        $mediumImage = $imageData['medium'];
                        $bigImage = $imageData['big'];
                
                        $smallPath = Storage::disk('public')->putFile('media', $smallImage);
                        $mediumPath = Storage::disk('public')->putFile('media', $mediumImage);
                        $bigPath = Storage::disk('public')->putFile('media', $bigImage);
                
                        $gallery = new Gallery([
                            'small' => $smallPath,
                            'medium' => $mediumPath,
                            'big' => $bigPath,
                        ]);
                        $property->gallery()->save($gallery);
                    }
                }
                
                
                    // Plans
                    if (isset($validatedData['plans'])) {
                    foreach ($validatedData['plans'] as $planData) {
                        $planImage = $planData['image'];

                        // Move and store the plan image in the public/media directory
                        $planImagePath = Storage::disk('public')->putFile('media', $planImage);
                       
                        $plan = new Plans([
                            'name' => $planData['name'],
                            'desc' => $planData['desc'],
                            'image' => $planImagePath,
                        ]);
                        $property->plans()->save($plan);

                        $areaPlan = new AreaPlans([
                            'value' => $planData['value'],
                            'unit' => $planData['unit'],
                            'property_id' => $property->id,
                            'features_id' => $feature->id,
                        ]);
                        $plan->areaPlans()->save($areaPlan);
                    }
                }
                

                //Videos
               if (isset($validatedData['videos'])) {
                    foreach ($validatedData['videos'] as $videoData) {
                        $video = new Videos([
                            'name' => $videoData['name'],
                            'link' => $videoData['link'],
                        ]);
                        $property->videos()->save($video);
                    }
                }
                
              
                $message = 'Propriété ajoutée !'; // Property added message
            } else {
                $message = 'Cette propriété existe déjà.'; // Property exists message
            }

            // Commit the transaction
            DB::commit();
        } catch (\Exception $e) {
            // Rollback the transaction if an error occurs
            DB::rollback();
            throw $e;
        }

        // Return a JSON response with the message indicating whether the property was added or not
        return response()->json(['message' => $message]);
    }
}
