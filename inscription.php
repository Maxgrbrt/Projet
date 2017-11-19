
<meta charset="utf-8">

<?php
require_once 'config/init.conf.php';
require_once 'config/bdd.conf.php';
require_once 'include/fonction.inc.php';
require_once 'config/connexion.inc.php';

include 'notification.php';
require_once('libs/Smarty.class.php');
// Si l'utilisateur tente d'acceder à cette page alors qu'il n'est pas connecté on lui afficage ce message
if ($is_connect == FALSE) {
    echo 'Vous devez être connecté pour accédez à cette page';
    exit();
}
if (isset($_POST['submit'])) {



    print_r($_POST);




    $notification = 'Aucune notification à afficher';
    $_SESSION['notification_result'] = FALSE;
// On vérifie qu'il a bien renseigné tous les champs
    if (!empty($_POST['nom']) AND !empty($_POST['prenom']) AND !empty($_POST['email']) AND !empty($_POST['mdp'])) {

        // On regarde dans la base de donnée si on a un email qui correspond a celui entrée 
        $select_user = "SELECT email "
                . "FROM utilisateurs "
                . "WHERE email = :email ";

        /* @var $bdd PDO */
        //on met les champs rentrés par l'utilisateur dans $sth
        $sth_mail = $bdd->prepare($select_user);
        $sth_mail->bindValue(':email', $_POST['email'], PDO::PARAM_STR);

// count prendre la valeur du nombre de email + mdp corresponndant a l'entrée
        if ($sth_mail->execute() == TRUE) {
            $count = $sth_mail->rowCount();
            // Si un email correspond on affiche que cet email est deja utilise
            if ($count > 0) {
                $notification = 'Email déjà utilisé';
                $_SESSION['notification_result'] = FALSE;
                $_SESSION['notification'] = $notification;
                header('Location: inscription.php');
                exit();
            } else {
// Si l'email n'est pas deja utilise et que tous les chams sont remplis on insert ces champs dans la base de donnée utilisateurs
                $insert = "INSERT INTO utilisateurs (nom, prenom, email, mdp)"
                        . "VALUES (:nom, :prenom, :email, :mdp)";



                /* @var $bdd PDO */
                $sth = $bdd->prepare($insert);
                $sth->bindValue(':nom', $_POST['nom'], PDO::PARAM_STR);
                $sth->bindValue(':prenom', $_POST['prenom'], PDO::PARAM_STR);
                $sth->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
                $sth->bindValue(':mdp', cryptPassword($_POST['mdp']), PDO::PARAM_STR);

                if ($sth->execute() == TRUE) {
// On avertit l'utilisateur que tout a été enregistrés

                    $notification = '<strong>Vos informations ont bien été enregistrés</strong>';
                    $_SESSION['notification_result'] = TRUE;
                } else {
                    $notification = 'Veuillez renseigner les champs obligatoires';
                    $_SESSION['notification_result'] = FALSE;
                }
            }
        } else {
            
        }
    } else {
        $notification = 'Veuillez compléter les champs ';
        $_SESSION['notification_result'] = FALSE;
    }


    $_SESSION['notification'] = $notification;
    header('Location: inscription.php');
    exit();
} else {
    $smarty = new Smarty();

    $smarty->setTemplateDir('templates/');
    $smarty->setCompileDir('templates_c/');
//$smarty->setConfigDir('configs/');
//$smarty->setCacheDir('cache/');
    $smarty->assign('is_connect', $is_connect);
    include 'include/header.inc.php';


    $smarty->display('inscription.tpl');
    include 'include/footer.inc.php';
}
