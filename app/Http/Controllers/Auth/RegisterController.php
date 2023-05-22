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
        // Validation des données utilisateur
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,NULL,id',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'email.unique' => 'Un utilisateur existe déjà avec cet email.',
            'password.confirmed' => 'Le mot de passe et la confirmation ne correspondent pas.',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        try {
        
            // Create new user with validated data
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            // Success message
            return response()->json(['message' => 'Inscription réussie !'], 201);
        } catch (\Exception $e) {
            // Gestion des erreurs de la base de données
            return response()->json(['error' => 'Une erreur est survenue lors de l\'inscription.'], 500);
        }
    }


}