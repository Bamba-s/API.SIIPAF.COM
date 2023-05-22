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

        // Try to authenticate the user with the provided credentials
        if (!Auth::attempt($credentials)) {
            // If authentication fails, return an error response with an HTTP 401 status code
            return response()->json(['error' => 'Email ou mot de passe incorrect'], 401);
        }

        // Retrieve the authenticated user from the session
        $user = $request->user();

        // Create an access token for the user
        $token = $user->createToken('auth_token')->plainTextToken;

        // Successful response with the access token
        return response()->json(['access_token' => $token], 200);
    }

    // LOGOUT
    public function logout(Request $request)
    {
        //Recover authenticated user from the session
        $user = $request->user();
        // Revoke all user's access tokens
        $user->tokens()->delete();
        // Success lougout response
        return response()->json(['message' => 'Vous êtes déconnecté.'], 200);
    }
}
