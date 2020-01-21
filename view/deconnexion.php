<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$_SESSION = array();
session_destroy();
//chemin basolu
header('Location: /Or');
exit(0);
?>
