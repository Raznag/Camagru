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
    <?php
    if (!isset($_SESSION['id_user'])) {
        header('Location: /Tempest/index.php');
        exit(0);
    }
    if (file_exists("../index.php"))
    {
        $path = "../index.php?action=change";
    }
    else if (file_exists("index.php"))
    {
        $path = "index.php?action=change";
    }
    
    echo "<h1>Parametres</h1><br/>";

    if (isset($_GET['errorpseudo']) && $_GET['errorpseudo'] == 1)
    {
        echo "Le pseudo est deja utilise, veuillez en choisir un autre !";
    }
    else if (isset($_GET['successpseudo']) && $_GET['successpseudo'] == 1)
    {
        echo "Félicitations, votre pseudo a bien été changé !";
    }
    if (isset($_GET['errormail']) && $_GET['errormail'] == 1)
    {
        echo "Cette adresse mail est deja utilisée, veuillez en choisir une autre !";
    }
    else if (isset($_GET['successmail']) && $_GET['successmail'] == 1)
    {
        echo "Félicitations, votre adresse mail a bien été changée !";
    }
    if (isset($_GET['password']) && $_GET['password'] == 1)
    {
        echo "Mot de passe trop faible !";
    }
    else if (isset($_GET['successpassword']) && $_GET['successpassword'] == 1)
    {
        echo "Le mot de passe a bien été modifié !";
    }
    if (isset($_GET['gerror']) && $_GET['gerror'] == 1)
    {
        echo "Une erreur s'est produite, veuillez reessayer !";
    }
    if (isset($_GET['commentaire']) && $_GET['commentaire'] == 1)
    {
        echo "Les changements ont bien été pris en compte !";
    }
?>
    <form action="<?= $path ?>" method="post">
        <label for="pseudo">Nouveau pseudo : </label>
        <input type="text" name="username" id="pseudo" />
        <input type="submit" name="submitpseudo" value="Ok" />
        <br />
    </form>
    <form action="<?= $path ?>" method="post">
        <label for="email">Nouvelle adresse mail : </label>
        <input type="text" name="email" id="email" />
        <input type="submit" name="submitemail" value="Ok" />
    </form>
    <form action="<?= $path ?>" method="post">
        <label for="password">Nouveau Mot de passe : </label>
        <input type="text" name="password" id="password" />
        <input type="submit" name="submitpassword" value="Ok" />
    </form>
    <form action="<?= $path ?>" method="post">
        <p>Souhaitez-vous etre alerté par email lorsque l'une de vos photos est commentée ou likée?</p>
        <input type="radio" name="alerte" id="alerte" value="oui" <?=  $_SESSION['alert'] == 1 ? "checked" : NULL ?>/>
        <label for="alerte">Oui</label>
        <input type="radio" name="alerte" id="alerte" value="non" <?=  $_SESSION['alert'] == 0 ?  "checked" : NULL ?>/>
        <label for="alerte">Non</label>
        <input type="submit" name="submitalert" value="Mettre à jour !" />
    </form>

</body>

</html>