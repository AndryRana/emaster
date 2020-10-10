<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Création de votre compte</title>
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
            <td># Une dernière étape

                Nous avons juste besoin que vous confirmiez votre adresse e-mail pour prouver que vous êtes un humain. 
                Merci de cliquer sur le lien suivant:</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td><a href="{{ url('confirm/'.$code)}}">Confirmer votre compte</a></td>
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