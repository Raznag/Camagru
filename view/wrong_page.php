<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Oooops</title>
</head>

<body>
    <h2>Error</h2>
    <div>
        <p>La page que vous avez demandee n'est pas/plus disponible. Verifiez l'url inseree, si le probleme persiste veuillez nous contacter a l'addresse mail mefaisp@schier.com</p>
    </div>
</body>

</html>