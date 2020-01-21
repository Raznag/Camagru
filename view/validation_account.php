<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Camagru</title>
</head>

<body>
    <h2>Valider votre email</h2>
    <div>
        <p>Un email de verification de compte vous a ete envoyé. Pensez a regarder votre boite mail pour le valider afin de pouvoir vous connecter sur le site!</p>
        <p><a href="index.php">Retour accueil.</a></p>
    </div>
</body>

</html>