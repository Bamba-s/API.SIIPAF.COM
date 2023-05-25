<?php

namespace App\Http\Controllers;

use App\Models\ModelProperty\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PropertyController extends Controller
{

    public function index() 
{
    $perPage = 20; // Items per page

    $properties = Property::with('localisation', 'features.areaFeatures', 'paymentDeadline',
        'deliveryTime', 'areaProperty', 'additionalFeatures',
        'gallery', 'plans.areaPlans', 'videos')->paginate($perPage);

    $totalItems = $properties->total(); //  total items
    $itemsPerPage = $properties->perPage(); // Items per page
    $totalPages = $properties->lastPage(); //  total number per page
    $currentPage = $properties->currentPage(); // Current page

    return response()->json([
        'current_page' => $currentPage,
        'data' => $properties->items(),
        'totalItems' => $totalItems,
        'itemsPerPage' => $itemsPerPage,
        'totalPages' => $totalPages,
        
    ]);
}

    //
        public function show($id)
    {
    
        $property = Property::with('localisation', 'features.areaFeatures', 'paymentDeadline',
        'deliveryTime', 'areaProperty', 'additionalFeatures',
        'gallery', 'plans.areaPlans', 'videos')->find($id);

        if (!$property) {
            return response()->json(['message' => "Aucune propriété avec l'ID : $id !"], 404);
        }

        return response()->json(['Propriété' => $property]);
        
       
    }
     
    // Search properties
    public function search(Request $request)
    {
        $query = $request->input('query');

        $properties = Property::where('title', 'like', "%$query%")
                           ->orWhere('desc', 'like', "%$query%")
                           ->paginate(10);
                           //->get();

        return response()->json($properties);
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            // Retrieve the property by ID
            $property=Property::find($id);
            if (!$property) {
                return response(['message' => "Aucune propriété avec id:$id !"], 404);
            }
    
            // Delete the property and its related models
            $property->delete();
    
            // Commit the transaction
            DB::commit();
    
            $message = 'Propriété supprimée !'; // Property deleted message
        } catch (\Exception $e) {
            // Rollback the transaction if an error occurs
            DB::rollback();
            throw $e;
        }
    
        // Return a JSON response with the message indicating whether the property was deleted or not
        return response()->json(['message' => $message]);
    }

}