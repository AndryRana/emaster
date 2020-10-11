<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mot de passe oublié</title>
</head>

<body>
    <table>
        <tr>
            <td>{{ $name }},</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>Votre mot de passe a été mise à jour. <br>
                Les informations de votre compte sont ci-dessous avec un nouveau mot de passe:</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>Email: {{ $email }}</td>
        </tr>
        <tr>
            <td>Nouveau mot de passe: {{ $password }}</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>Cordialement</td>
        </tr>
        <tr>
            <td>Equipe Emaster</td>
        </tr>
    </table>
</body>

</html>