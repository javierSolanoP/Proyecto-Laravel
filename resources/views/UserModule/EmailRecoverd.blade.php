<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!--Font style-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@1,300&display=swap&family=Pinyon+Script&display=swap&family=STIX+Two+Math&display=swap" rel="stylesheet">
    <!--Style-->
    <link rel="stylesheet" href="css/EmailRecoverd.css">
    <title>Document</title>
</head>
<body>
    <h1>The Dandi's Shop</h1>
    <p><strong> Usted solicitó un restablecimiento de contraseña, </strong>
     para reestablcerla dele click en el siguiente enlace: </p>
    <a href="{{ url('/users/RecoverPassword') }}">Restablecer contraseña</a>
</body>
</html>