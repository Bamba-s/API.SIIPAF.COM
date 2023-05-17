<?php

namespace App\Http\Controllers\Forms;

use App\Http\Controllers\Controller;
use App\Mail\ContactSubmitted;
use App\Models\Forms\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactFormController extends Controller
{
    //
    public function contact(Request $request)
{
    // Form data validation
    $validator = Validator::make($request->all(), [
        'name' => 'required|string',
        'telephone' => 'required|string',
        'service' => 'required|string',
        'message' => 'string',
    ]);

    // If the validation fails, returns a response with the validation errors
    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // If the validation is successful, create a new Contact object and save it in the database
    $contact = new Contact([
        'name' => $request->name,
        'telephone' => $request->telephone,
        'service' => $request->service,
        'message' => $request->message,
    ]);
    $contact->save();

    Mail::to('bamba.inf@gmail.com')->send(new ContactSubmitted($contact));

    // Success message
    return response()->json(['message' => 'Le formulaire de contact a été envoyé avec succès.']);
}

    
}
