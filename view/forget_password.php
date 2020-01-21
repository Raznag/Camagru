<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once('../model/model.php');
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Camagru</title>
</head>

<body>
    <h1>Mot de passe oublie !</h1>
    <?php
    if (isset($_POST['recupmail']) && !empty($_POST['recupmail']) && checkEmail($_POST['recupmail']))
    {
        echo " passp";
        sendForgetMail(getUserId($_POST['recupmail']));
        unset($_POST['recupmail']);
    }
    if (isset($_POST['mess']))
    {
        echo "Une mail a ete envoye sur l'adresse mail renseignee. Pensez a verifier votre dossier spam !";
        unset($_POST['mess']);
    }
    ?>
    <form action="" method="post">
        <p>Renseignez l'adresse que vous avez utilisée pour vous inscrire ! Faites attention a l'orthographe ...</p>
        <label for="email">Email de création de compte :</label>
        <input type="text" name="recupmail" id="email" required />
        <input type="submit" name="mess" Value="Seconde chance !" />
    </form>
</body>

</html>