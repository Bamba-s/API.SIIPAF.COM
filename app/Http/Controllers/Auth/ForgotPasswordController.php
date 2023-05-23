<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;


class ForgotPasswordController extends Controller
{
    //
    protected function broker()
    {
        return Password::broker();
    }

    // Send reset link email
    public function sendResetLinkEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['error' => 'Aucun utilisateur inscrit avec cet email.'], 422);
        }

        $response = null;

        if ($user) {
            $response = $this->broker()->sendResetLink(
                $request->only('email'),
            );
        }

        return $response == Password::RESET_LINK_SENT
            ? response()->json(['message' => 'Un email de réinitialisation de mot de passe a été envoyé !'], 200)
            : response()->json(['error' => 'Impossible d\'envoyer l\'email de réinitialisation  '], 422);
    }

   // Reset password form
    public function showResetForm(Request $request, $token)
    {
        return view('resetPassword.reset-password-form', ['token' => $token, 'email' => $request->email]);
    }

}