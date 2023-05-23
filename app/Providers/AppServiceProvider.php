<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
        //
        ResetPassword::toMailUsing(function (object $notifiable, string $token) {
    
            $url = url(route('password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));
        
            return (new MailMessage)
                ->subject(Lang::get('Réinitialisation de mot de passe'))
                ->line(Lang::get('Vous recevez cet e-mail car nous avons reçu une demande de réinitialisation de mot de passe pour votre compte.'))
                ->action(Lang::get('Réinitialiser le mot de passe'), $url)
                ->line(Lang::get('Cet lien sera expiré dans :count minutes.', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]))
                ->line(Lang::get('Si vous n\'avez pas demandé de réinitialisation de mot de passe, aucune autre action n\'est requise.'));
        });
    
    }
}
