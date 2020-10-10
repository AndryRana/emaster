<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bienvenue</title>
</head>
<body>
    <table>
        <tr><td>{{ $name }}!</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>Votre compte a été activé avec succès.</td></tr>
        <tr><td>&nbsp;</td></tr>	
        <tr><td>Les informations de votre compte sont les suivantes:</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>Email: {{ $email }}</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>Mot de passe: ***** (as chosen by you)</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>Merci et à bientôt</td></tr>
        <tr><td>Equipe Emaster</td></tr>
</body>
</html>