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
    <h1>CAMAGRU</h1>
    <?php
    if (isset($_GET['username']) && isset($_GET['password']) && isset($_GET['email'])) {
        if (isset($_GET['password']) && $_GET['password'] == 1)
            echo "La securite du mot de passe n'est pas suffisante.<br/>";
        if (isset($_GET['username']) && $_GET['username'] == 1)
            echo "Le pseudonyme est deja pris veuillez en choisir un autre.<br />";
        if (isset($_GET['email']) && $_GET['email'] == 1)
            echo "L'adresse mail est deja prise.<br/>";
    }

    ?>
    <form action="../index.php?action=subscription" method="post">
        <label for="pseudo">Pseudo : </label>
        <input type="text" name="username" id="pseudo" required />
        <br />
        <label for="email">Email : </label>
        <input type="text" name="email" id="email" required />
        <br />
        <label for="password">Mot de passe : </label>
        <input type="text" name="password" id="password" required />
        <input type="submit" name="submit" value="Ok" />
    </form>

</body>

</html>