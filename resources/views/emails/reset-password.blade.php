<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Réinitialisation de mot de passe</title>
</head>
<body>
    <h1>Réinitialisation de mot de passe</h1>
    <p>Vous recevez cet e-mail car nous avons reçu une demande de réinitialisation de mot de passe pour votre compte.</p>
    <p>Veuillez cliquer sur le lien ci-dessous pour réinitialiser votre mot de passe :</p>
    <a href="{{ $url }}">Réinitialiser le mot de passe</a>
    <p>Si vous n'avez pas demandé de réinitialisation de mot de passe, aucune autre action n'est requise.</p>
    <img src="{{ $message->embed(public_path('images/logo.png')) }}" alt="Logo">
</body>
</html>