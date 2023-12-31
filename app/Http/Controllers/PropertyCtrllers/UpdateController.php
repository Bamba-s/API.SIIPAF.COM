<?php

namespace App\Http\Controllers\PropertyCtrllers;

use App\Http\Controllers\Controller;
use App\Models\ModelProperty\AdditionalFeatures;
use App\Models\ModelProperty\AreaFeatures;
use App\Models\ModelProperty\AreaPlans;
use App\Models\ModelProperty\Features;
use App\Models\ModelProperty\Gallery;
use App\Models\ModelProperty\Plans;
use App\Models\ModelProperty\Price;
use App\Models\ModelProperty\Property;
use App\Models\ModelProperty\Videos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UpdateController extends Controller
{
    //
    public function update(Request $request, $id)
{
    DB::beginTransaction();

    try {
        // Find the property by ID
        $property=Property::find($id);
        if (!$property) {
            return response(['message' => "Aucune propriété trouvée  avec id:$id !"], 404);
        }

        // Update the property data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'desc' => 'required|string|max:1000',
            'propertyType' => 'required|string|max:255',
            'projectTitle' => 'required|string|max:255',
            'propertyStatus' => 'required|string|max:255',
            'formattedAddress' => 'required|string|max:255',
            'featured' => 'required|boolean',
            'initialContributionPercentage' => 'required|integer',
            'monthlyPayment' => 'required|numeric',
            'bedrooms' => 'required|integer',
            'rooms' => 'required|integer',
            'price.sale' => 'required|numeric',
            'price.rent' => 'required|numeric',
            'localisation.lat' => 'required|numeric',
            'localisation.lng' => 'required|numeric',
            'features' => 'required|array|min:1',
            'features.*.name' => 'required|string|max:255',
            'features.*.areaFeatures' => 'required|array',
            'features.*.areaFeatures.value' => 'required|string|max:255',
            'features.*.areaFeatures.unit' => 'required|string|max:255',
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
            'plans' => 'required|array|min:1',
            'plans.*.name' => 'required|string|max:255',
            'plans.*.desc' => 'required|string',
            'plans.*.image' => 'required|max:2048',
            'plans.*.areaPlans.value' => 'required|numeric',
            'plans.*.areaPlans.unit' => 'required|string|max:255',
            'videos' => 'array',
            'videos.*.name' => 'required|string|max:255',
            'videos.*.link' => 'required|string|max:255',
        ]);

        $property->update($validatedData);

        //Price
        if ($request->has('price')) {
            $priceData = $request->input('price');
            $property->price()->update([
                'sale' => $priceData['sale'],
                'rent' => $priceData['rent'],
                
            ]);
        }

        // Update Localisation
        if ($request->has('localisation')) {
            $localisationData = $request->input('localisation');
            $property->localisation()->update([
                'lat' => $localisationData['lat'],
                'lng' => $localisationData['lng'],
            ]);
        }

                // Update property features
                if (isset($validatedData['features'])) {
                    $property->features()->delete(); 
        
                    foreach ($validatedData['features'] as $featureData) {
                        // Create Feature
                        $feature = new Features([
                            'name' => $featureData['name'],
                        ]);
                        $property->features()->save($feature);
        
                        if (isset($featureData['areaFeatures'])) {
                            // Create AreaFeatures
                            $areaFeatureData = $featureData['areaFeatures'];
                            $areaFeature = new AreaFeatures([
                                'value' => $areaFeatureData['value'],
                                'unit' => $areaFeatureData['unit'],
                                'property_id' => $property->id,
                                'features_id' => $feature->id,
                            ]);
                            $feature->areaFeatures()->save($areaFeature);
                        }
                    }
                }

        // Update Payment Deadline
        if ($request->has('paymentDeadline')) {
            $paymentDeadlineData = $request->input('paymentDeadline');
            $property->paymentDeadline()->update([
                'value' => $paymentDeadlineData['value'],
                'unit' => $paymentDeadlineData['unit'],
            ]);
        }

        // Update Delivery Time
        $deliveryTimeData = $request->input('deliveryTime');
        $property->deliveryTime()->update([
            'value' => $deliveryTimeData['value'],
            'unit' => $deliveryTimeData['unit'],
        ]);

        // Update Area Property
        $areaPropertyData = $request->input('areaProperty');
        $property->areaProperty()->update([
            'ground' => $areaPropertyData['ground'],
            'used' => $areaPropertyData['used'],
            'unit' => $areaPropertyData['unit'],
        ]);

        // Update Additional Features
        if (isset($validatedData['additionalFeatures'])) {
            $property->additionalFeatures()->delete(); 

            foreach ($validatedData['additionalFeatures'] as $featureData) {
                $additionalFeature = new AdditionalFeatures([
                    'name' => $featureData['name'],
                    'value' => $featureData['value'],
                ]);
                $property->additionalFeatures()->save($additionalFeature);
            }
        }

        // Update Gallery
        if (isset($validatedData['gallery'])) {
            $property->gallery()->delete(); 

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

        // Update Plans
        if (isset($validatedData['plans'])) {
            $property->plans()->delete(); 

            foreach ($validatedData['plans'] as $planData) {
                $planImage = $planData['image'];

                $planImagePath = Storage::disk('public')->putFile('media', $planImage);

                $plan = new Plans([
                    'name' => $planData['name'],
                    'desc' => $planData['desc'],
                    'image' => $planImagePath,
                ]);
                $property->plans()->save($plan);

                $areaPlan = new AreaPlans([
                    'value' => $planData['areaPlans']['value'],
                    'unit' => $planData['areaPlans']['unit'],
                    'property_id' => $property->id,
                    'plan_id' => $plan->id,
                ]);
                $plan->areaPlans()->save($areaPlan);
                
                }
            }
    
            // Update Videos
            if (isset($validatedData['videos'])) {
                $property->videos()->delete(); 
    
                foreach ($validatedData['videos'] as $videoData) {
                    $video = new Videos([
                        'name' => $videoData['name'],
                        'link' => $videoData['link'],
                    ]);
                    $property->videos()->save($video);
                }
            }
    
            $message = 'Propriété mise à jour !'; 
    
            // Commit the transaction
            DB::commit();
        } catch (\Exception $e) {
            // Rollback the transaction if an error occurs
            DB::rollback();
            throw $e;
        }
    
        // Return a JSON response with the message indicating whether the property was updated or not
        return response()->json(['message' => $message]);
    }

}
