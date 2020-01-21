<?php

function dbConnect()
{
    try {
        $db = new PDO('mysql:host=localhost;dbname=camagru;charset=utf8', 'root', 'ROOTROOT', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    } catch (Exception $e) {
        die('Error  :' . $e->getMessage());
    }
    return $db;
}

function addUserData()
{
    $db = dbConnect();
    $key_verif = md5(rand(0, 1000));
    $req = $db->prepare('INSERT INTO id_user(username, email, `password`, key_verif, register_date) VALUES(?, ?, ?, ?, NOW())');
    $req->execute(array(
        $_POST['username'],
        $_POST['email'],
        password_hash($_POST['password'], PASSWORD_DEFAULT),
        $key_verif
    ));
    $id_user_db = $db->lastInsertId();
    $req->closeCursor();
    return $id_user_db;
}

function checkUserData($username, $email, $password)
{
    $db = dbConnect();
    $req = $db->prepare('SELECT * FROM id_user WHERE username=? OR email=?');
    $req->execute(array(
        $username,
        $email
    ));
    $check = array();
    while ($data = $req->fetch()) {
        if ($data['username'] == $username)
            $check['username'] = 1;
        if ($data['email'] == $email)
            $check['email'] = 1;
    }
    $req->closeCursor();
    if (!preg_match("/^(\w*(?=\w*\d)(?=\w*[a-z])(?=\w*[A-Z])\w*){6,20}$/", $password))
        $check['password'] = 1;
    return ($check);
}

function connectUser()
{
    $db = dbConnect();
    $req = $db->prepare('SELECT * FROM id_user WHERE username = ?');
    $req->execute(array($_POST['username']));
    if ($req->rowCount()) {
        $data = $req->fetch();
        $req->closeCursor();
        if (password_verify($_POST['password'], $data['password'])) {
            $_SESSION['co']= "1";
            $_SESSION['username'] = $data['username'];
            $_SESSION['id_user'] = $data['id'];
            $_SESSION['alert'] = $data['alert'];
            $_SESSION['activated']= $data['activated'];
            $req = $db->prepare('UPDATE id_user SET forget_password=? WHERE username = ?');
            $req->execute(array(NULL, $_POST['username']));
        } else {
            header('Location: view/connexion.php?error=1');
            exit(0);
        }
    } else {
        header('Location: view/connexion.php?error=1');
        exit(0);
    }
}

function sendMail($id_user_db)
{
    $db = dbConnect();
    $req = $db->prepare('SELECT * FROM id_user WHERE id=?');
    $req->execute(array($id_user_db));
    $data = $req->fetch();
    $sujet = "Bienvenue sur Camagru, activez votre compte !\n";
    $url = "http://localhost:8080/Or/index.php?action=validate&id_user=" . $id_user_db . "&key_verif=" . $data['key_verif'];
    $message = "Cliquez sur le lien suivant $url";
    //$data['username'] mettre le vrai destinataire
    $destinataires = "zanoujiamine@gmail.com";
    $var = mail($destinataires, $sujet, $message);
}

function activateUserAccount($id_user_db, $key_verif)
{
    $db = dbConnect();
    $req = $db->prepare('SELECT * FROM id_user WHERE id=?');
    $req->execute(array($id_user_db));
    $data = $req->fetch();
    $req->closeCursor();
    if ($data['key_verif'] == $key_verif) {
        $req = $db->prepare('UPDATE id_user SET activated = 1 WHERE id=?');
        $req->execute(array($id_user_db));
        $req->closeCursor();
        $_SESSION['activated'] = 1;
        return (1);
    } else
        return (0);
}

function checkEmail($email)
{
    $db = dbConnect();
    $req = $db->prepare('SELECT * FROM id_user WHERE email=?');
    $req->execute(array($email));
    if ($req->rowCount()) {
        $data = $req->fetch();
        $req->closeCursor();
        return (true);
    } else {
        return (false);
    }
}

function getUserId($email)
{
    $db = dbConnect();
    $req = $db->prepare('SELECT * FROM id_user WHERE email=?');
    $req->execute(array($email));
    if ($req->rowCount()) {
        $data = $req->fetch();
        $req->closeCursor();
        return ($data['id']);
    } else
        return (false);
}

function sendForgetMail($id_user_db)
{
    $db = dbConnect();
    $forget_password = md5(rand(0, 1000));
    $req = $db->prepare('UPDATE id_user SET forget_password=? WHERE id=?');
    $req->execute(array($forget_password, $id_user_db));
    $sujet = "Bienvenue sur Camagru, recuperez votre compte !\n";
    //$url = "http://localhost:8080/Tempest/view/reset_password.php?id_user=" . $id_user_db . "&key_pass=" . $forget_password;
    $url = "http://localhost:8080/Or/index.php?action=reset&id_user=" . $id_user_db . "&key_pass=" . $forget_password;
    $message = "Cliquez sur le lien suivant $url";
    //$data['username'] mettre le vrai destinataire
    $destinataires = "zanoujiamine@gmail.com";
    $var = mail($destinataires, $sujet, $message);
}

function checkTokenForgetMail()
{
    $db = dbConnect();
    $req = $db->prepare('SELECT * FROM id_user WHERE id=?');
    $req->execute(array($_GET['id_user']));
    $data = $req->fetch();
    $req->closeCursor();
    if (isset($data['forget_password']) && $data['forget_password'] == $_GET['key_pass'])
        return (true);
    return (false);
}

function updatePassword($id_user_db, $key_pass)
{
    $db = dbConnect();
    $req = $db->prepare('UPDATE id_user SET forget_password=?, activated=1, password=? WHERE id=?');
    $req->execute(array(NULL, password_hash($_POST['password'], PASSWORD_DEFAULT), $id_user_db));
    $req->closeCursor();

    /*    $req = $db->prepare('UPDATE id_user SET activated = 1 WHERE id=?');
    $req->execute(array($id_user_db));
    $req->closeCursor();*/
}
