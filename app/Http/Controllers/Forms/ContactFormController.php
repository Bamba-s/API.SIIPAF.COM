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
            'email' => 'required|string',
            'service' => 'required|string',
            'message' => 'string',
        ]);

        // If the validation fails, returns a response with the validation errors
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // If the validation is successful, create a new Contact object and save it in the database
        $mailData = new Contact([
            'name' => $request->name,
            'telephone' => $request->telephone,
            'email' => $request->email,
            'service' => $request->service,
            'message' => $request->message,
        ]);

        $mailData->save();

        Mail::to('bamba.inf@gmail.com')->send(new ContactSubmitted($mailData));

        // Success message
        return response()->json(['message' => 'Le formulaire de contact a été soumis avec succès.']);
    }

    public function listSubmissions(Request $request)
    {
        $perPage = $request->query('per_page', 20); // Number of items per page, default is 10
        $submissions = Contact::paginate($perPage);

        return response()->json($submissions);
    }


}