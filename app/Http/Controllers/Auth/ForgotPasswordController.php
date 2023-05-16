<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;


class ForgotPasswordController extends Controller
{
    //
    public function sendResetLinkEmail(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|email'
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 422);
    }

    $response = $this->broker()->sendResetLink(
        $request->only('email')
    );

    return $response == Password::RESET_LINK_SENT
                ? response()->json(['message' => 'Lien de réinitialisation envoyé !'], 200)
                : response()->json(['error' => 'Impossible d\'envoyer l\'email de réinitialisation  '], 422);
}

}
