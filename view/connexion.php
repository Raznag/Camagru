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
    <h1>Connexion</h1>
    <?php if (isset($_GET['error']) && $_GET['error'] == 1)
        echo "Mauvais identifiants !";
        ?>

    <form action="../index.php?action=connexion" method="post">
        <label for="pseudo">Pseudo : </label>
        <input type="text" name="username" id="pseudo" required />
        <br />
        <label for="password">Mot de passe : </label>
        <input type="text" name="password" id="password" required />
        <input type="submit" name="submit" value="Ok" />
    </form>
    <p><a href="forget_password.php">Mot de passe oublié ?</a></p>

</body>

</html>