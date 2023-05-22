<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\User;


class RegisterController extends Controller
{
    //

    public function register(Request $request)
    {
        //User data validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'password_confirmed' => 'required|string|min:8'
        ], [
                'email.unique' => 'Un utilisateur existe déjà avec cet email'
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }
            // Check if password and confirmation match
            if ($request->password !== $request->password_confirmed) {
                return response()->json(['error' => 'Le mot de passe et la confirmation ne correspondent pas.'], 422);
            }

            // create a new user with validated data
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'password_confirmed' => bcrypt($request->password_confirmed),
            ]);

            // Success message
            return response()->json(['message' => 'Inscription réussie !'], 201);
    }


}