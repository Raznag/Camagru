<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Camagru</title>
</head>

<body>
    <h1>CAMAGRU</h1>
    <p>Bonjour <?= isset($_SESSION['username']) ? $_SESSION['username'] : NULL ?></p>
    <!-- mettre a dans des headers et en charger un different si connecte ou pas  -->
    <?php if (!isset($_SESSION['username'])) {
    ?>
        <div>
        Bienvenue sur le site CAMAGRU, vous pouvez d'ores et deja vous incrire ou meme vous connecter si votre compte est actif,
    </div>
        <p><a href="view/inscription.php">INSCRIPTION</a></p>
        <p><a href="view/connexion.php">CONNEXION</a></p>
    <?php
    }
    ?>
    <?php if (isset($_SESSION['username'])) {
    ?>
        <p><a href="view/takesnap.php">Prendre un snap</a></p>
        <p><a href="view/change_params.php">Parametres</a></p>
        <p><a href="view/deconnexion.php">DECONNEXION</a></p>
    <?php
    }
    ?>
    <?php
    if (isset($_SESSION['activated']) && $_SESSION['activated'] == 0)
    {
        echo "Pensez a aller valider votre compte sinon vous ne pourrez pas utiliser toutes les fonctionnalites du site !<br /><br />Un email a ete envoye sur votre boite, verifiez le dossier spam !";
        //mettre dans index et creer nouveau controleur
        ?>
        <a href="#">Renvoyer le mail</a>
        <?php
    }
    ?>
</body>

</html>