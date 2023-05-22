<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\RequestGuard;

class LoginController extends Controller
{
    protected function guard()
    {
        return Auth::guard();
    }

    // LOGIN
    public function login(Request $request)
    {
        // Validate user data
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string'
        ]);

        /***  If user data are not valid,
         return an error response with an HTTP 422 status code ***/
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Get user credentials from the HTTP request
        $credentials = $request->only(['email', 'password']);

        // Tenter d'authentifier l'utilisateur avec les informations d'identification fournies
        if (!Auth::attempt($credentials)) {
            // Si l'authentification échoue, renvoyer une réponse d'erreur avec un code d'état HTTP 401
            return response()->json(['error' => 'Email ou mot de passe incorrect'], 401);
        }

        // Récupérer l'utilisateur authentifié à partir de la session
        $user = $request->user();

        // Créer un token d'accès pour l'utilisateur
        $token = $user->createToken('auth_token')->plainTextToken;

        // Réponse de succès avec le token d'accès 
        return response()->json(['access_token' => $token], 200);
    }

    // LOGOUT
    public function logout(Request $request)
    {
        // Récupérer l'utilisateur authentifié à partir de la session
        $user = $request->user();
        // Révoquer tous les tokens d'accès de l'utilisateur
        $user->tokens()->delete();
        // SUccess lougout response
        return response()->json(['message' => 'Vous êtes déconnecté.'], 200);
    }
}
