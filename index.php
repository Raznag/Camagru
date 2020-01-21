<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once('controller/controller.php');
require_once('model/model.php');

if (isset($_GET['action']) && $_GET['action'] == 'subscription') {
    inscrireUser();
} else if (isset($_GET['action']) && $_GET['action'] == 'connexion') {
    connexionUser();
} else if (isset($_GET['action']) && $_GET['action'] == 'validate') {
    validateUser();
} else if (isset($_GET['action']) && $_GET['action'] == 'reset') {
    resetPassword();
} 
else if (isset($_GET['action']) && $_GET['action'] == 'change') {
    changeParams();
}else if (isset($_GET['action']) && $_GET['action'] == 'revalidate') {
    sendValidateMail($_SESSION['id_user']);
} 
else
    accueil();
