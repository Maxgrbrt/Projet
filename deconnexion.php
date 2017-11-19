<?php
require_once 'config/init.conf.php';
require_once 'config/bdd.conf.php';
require_once 'config/connexion.inc.php';
require_once 'include/fonction.inc.php';
// On affichage à l'utilisateur qu'il est bien déconnecté
$notification = "Vous n'êtes plus connecté";
                $_SESSION['notification_result'] = FALSE;
                $_SESSION['notification'] = $notification;
setcookie("sid",0,(time() + 3600));
header('Location: index.php');
   
?>
