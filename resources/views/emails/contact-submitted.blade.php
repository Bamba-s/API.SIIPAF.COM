<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contact form</title>
</head>
<body>
    <h1>Email Data</h1>
    <p>Nom : {{ $mailData->name }}</p>
    <p>Téléphone : {{ $mailData->telephone }}</p>
    <p>Email : {{ $mailData->email }}</p>
    <p>Service : {{ $mailData->service }}</p>
    <p>Message : {{ $mailData->message }}</p>
   
</body>
</html>
