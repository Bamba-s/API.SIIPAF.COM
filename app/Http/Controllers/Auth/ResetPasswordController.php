<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    //
    public function reset(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'token' => 'required',
        'password' => 'required|confirmed|min:8',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 422);
    }

    $response = $this->broker()->reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $this->resetPassword($user, $password);
        }
    );

    return $response == Password::PASSWORD_RESET
                ? response()->json(['message' => 'Réinitailisation de mot de passe réussie !'], 200)
                : response()->json(['error' => 'Impossible de réinitialiser le mot de passe.'], 422);
}

}
