<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Demande client</title>
</head>

<body>
    <table>
        <tr>
            <td>Admin,</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>Détails de la demande</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>Nom: {{ $name }}</td>
        </tr>
        <tr>
            <td>Email: {{ $email }}</td>
        </tr>
        <tr>
            <td>Sujet: {{ $subject }}</td>
        </tr>
        <tr>
            <td>Message: {{ $comment }}</td>
        </tr>
        
        <tr>
            <td>&nbsp;</td>
        </tr>
       
        <tr>
            <td>{{ $name }}</td>
        </tr>
    </table>
</body>

</html>