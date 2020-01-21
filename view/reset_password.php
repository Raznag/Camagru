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
    <h1>Réinitialiser votre mot de passe !</h1>


    <form action="" method="post">

        <label for="password">Nouveau Mot de passe : </label>
        <input type="text" name="password" id="password"  />
        <input type="submit" name="submit" value="Ok" />
    </form>

</body>

</html>