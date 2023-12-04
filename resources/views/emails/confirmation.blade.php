<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
   <table>
        <tr><td>Chère : {{$name}}</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>Veuillez cliquer sur le lien ci-dessous pour confirmer votre compte:</td></tr>
        <tr><td><a href="{{url('user/confirm/'.$code)}}">comfirmer l'email</a></td></tr>
        <tr><td>Merci cordialement</td></tr>
    </table>
</body>
</html>