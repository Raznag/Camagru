<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once('model/model.php');

function inscrireUser()
{
    $check = checkUserData($_POST['username'], $_POST['email'], $_POST['password']);
    if ($check) {
        $email = $check['email'];
        $username = $check['username'];
        $password = $check['password'];
        header("Location: view/inscription.php?email=$email&username=$username&password=$password");
        exit(0);
    } else {
        $id_user_db = addUserData();
        sendMail($id_user_db);
        require('view/validation_account.php');
    }
}

function sendValidateMail($id_user_db)
{
    sendMail($id_user_db);
    if (file_exists("view/validation_account.php"))
    {
        require_once('view/validation_account.php');
    }
    else if (file_exists("validation_account.php"))
    {
        require_once('validation_account.php');
    }
}

function accueil()
{
    require('view/accueil.php');
}

function connexionUser()
{
    if (isset($_POST['username'], $_POST['password']) && !empty($_POST['username']) && !empty($_POST['password'])) {
        connectUser();
        header('Location: index.php');
        exit(0);
    } else {
        header('Location: view/connexion.php?error=1');
        exit(0);
    }
}

function validateUser()
{
    //faire une page compte valide ?
    if (isset($_GET['id_user']) && $_GET['id_user'] > 0 && isset($_GET['key_verif']) && !empty($_GET['key_verif']) && activateUserAccount($_GET['id_user'], $_GET['key_verif']))
        require('view/accueil.php');
    else
        require('view/wrong_page.php');
}

function resetPassword()
{
    if (isset($_GET['id_user']) && $_GET['id_user'] > 0 && isset($_GET['key_pass']) && !empty($_GET['key_pass'])) {
        if (checkTokenForgetMail()) {
            require('view/reset_password.php');
            if (isset($_POST['password']) && isset($_POST['submit'])) {
                if (!preg_match("/^(\w*(?=\w*\d)(?=\w*[a-z])(?=\w*[A-Z])\w*){6,20}$/", $_POST['password'])) {
                    echo "Mot de passe trop faible !";
                } else {
                    updatePassword($_GET['id_user'], $_GET['key_pass']);
                    echo "Le mot de passe a bel et bien été modifié !";
                }
            }
        } else
            require('view/wrong_page.php');
    } else
        require('view/wrong_page.php');
}

function changeParams()
{
    $db = dbConnect();
    if (isset($_POST['submitpseudo']) && isset($_POST['username'])) {
        $req = $db->prepare('SELECT * FROM id_user WHERE username=?');
        $req->execute(array(
            $_POST['username']
        ));
        $data = $req->fetch();
        $req->closeCursor();
        if ($data['username'] == $_POST['username']) {
            header('Location: view/change_params.php?errorpseudo=1');
            exit(0);
        } else {
            $req = $db->prepare('UPDATE id_user SET username=? WHERE id = ?');
            $req->execute(array($_POST['username'], $_SESSION['id_user']));
            $_SESSION['username'] = $_POST['username'];
            $req->closeCursor();
            header('Location: view/change_params.php?successpseudo=1');
            exit(0);
        }
    } else if (isset($_POST['submitemail']) && isset($_POST['email'])) {
        $req = $db->prepare('SELECT * FROM id_user WHERE email=?');
        $req->execute(array(
            $_POST['email']
        ));
        $data = $req->fetch();
        $req->closeCursor();
        if ($data['email'] == $_POST['email']) {
            header('Location: view/change_params.php?errormail=1');
            exit(0);
        } else {
            $req = $db->prepare('UPDATE id_user SET email=? WHERE id = ?');
            $req->execute(array($_POST['email'], $_SESSION['id_user']));
            $req->closeCursor();
            header('Location: view/change_params.php?successmail=1');
            exit(0);
        }
    } else if (isset($_POST['submitpassword']) && isset($_POST['password'])) {
        if (!preg_match("/^(\w*(?=\w*\d)(?=\w*[a-z])(?=\w*[A-Z])\w*){6,20}$/", $_POST['password'])) {
            header('Location: view/change_params.php?password=1');
            exit(0);
        } else {
            $db = dbConnect();
            $req = $db->prepare('UPDATE id_user SET password=? WHERE id=?');
            $req->execute(array(password_hash($_POST['password'], PASSWORD_DEFAULT), $_SESSION['id_user']));
            //$req->execute(array($_POST['password'], $_SESSION['id_user']));
            $req->closeCursor();
            header('Location: view/change_params.php?successpassword=1');
            exit(0);
        }
    } else if (isset($_POST['submitalert'])) {
        if (isset($_POST['alerte']) && $_POST['alerte'] == "non") {
            $db = dbConnect();
            $req = $db->prepare('UPDATE id_user SET alert= 0 WHERE id=?');
            $req->execute(array($_SESSION['id_user']));
            $req->closeCursor();
            $_SESSION['alert'] = 0;
            header('Location: view/change_params.php?commentaire=1');
            exit(0);
        } else if (isset($_POST['alerte']) && $_POST['alerte'] == "oui") {
            $db = dbConnect();
            $req = $db->prepare('UPDATE id_user SET alert= 1 WHERE id=?');
            $req->execute(array($_SESSION['id_user']));
            $req->closeCursor();
            $_SESSION['alert'] = 1;
            header('Location: view/change_params.php?commentaire=1');
            exit(0);
        }
    } else {
        header('Location: view/change_params.php?gerror=1');
        exit(0);
    }
}





/*
function printError($email, $username, $password)
{
    if (isset($password) && $password == 1)
        echo "La securite du mot de passe n'est pas suffisante.<br/>";
    if (isset($username) && $username == 1)
        echo "Le pseudonyme est deja pris veuillez en choisir un autre.<br />";
    if (isset($email) && $email == 1)
        echo "L'adresse mail est deja prise.<br/>";
}*/
