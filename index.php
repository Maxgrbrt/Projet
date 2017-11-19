<?php

// On appelle les fichiers dont on a besoin sur la page
require_once 'config/init.conf.php';
require_once 'config/bdd.conf.php';
require_once 'config/connexion.inc.php';
require_once 'include/fonction.inc.php';
include 'include/header.inc.php';



require_once('libs/Smarty.class.php');


// Mise en place du nombre d'articles par page, ici 2 par pages
$nb_articles_par_page = 2;
// Si ma valeur est poste alors elle prend la valeur de la variable page sinon elle prend 1a valeur 1
$page_courante = isset($_GET['page']) ? $_GET['page'] : 1;
// On prend la valeur de notre index depuis notre fonction
$index = pagination($page_courante, $nb_articles_par_page);

$nb_total_article_publie = nb_total_article_publie($bdd);
// fonction ceil arrondit au supérieur pour avoir le nombre de page
$nb_pages = ceil($nb_total_article_publie / $nb_articles_par_page);

// valeur par defaut de notre varaible de barre de recherche
$recherche = "";

// requete SQL pour afficher les articles sur la page en partant du plus récent article au plus récent
$select = "SELECT id, "
        . "titre, "
        . "texte, "
        . "DATE_FORMAT(date, '%d/%m/%Y') as date_fr "
        . "FROM articles  "
        . "WHERE publie = :publie "
        . "ORDER BY id DESC "
        . "LIMIT :index, :nb_articles_par_page;";


//echo $select;
/* @var $bdd PDO */
$sth = $bdd->prepare($select);
// on sécurise les variables
$sth->bindValue(':publie', 1, PDO::PARAM_BOOL);
$sth->bindValue(':index', $index, PDO::PARAM_INT);
$sth->bindValue(':nb_articles_par_page', $nb_articles_par_page, PDO::PARAM_INT);
if ($sth->execute() == TRUE) {
    $tab_articles = $sth->fetchAll(PDO::FETCH_ASSOC); // Prends toutes les données de ton tableau
    //print_r($tab_articles);
    // echo $tab_articles[0]['texte'];
} else {
    echo ' une erreur est survenue...';
}

// Si on a effectuer une recherche
if (isset($_GET['search'])) {

    // Je donne à 'recherche' le champre rentrer dans la barre de recherche
    $recherche = $_GET['search'];
    if (!empty($recherche)) {
        // Je regarde dans ma base SQL si j'ai des correspondances
        $sql = "SELECT "
                . "id, "
                . "texte , "
                . "titre, "
                . "DATE_FORMAT(date, '%d/%m/%Y') as date_fr "
                . "FROM articles WHERE(titre LIKE :recherche OR texte LIKE :recherche) "
                . "AND publie = 1 ORDER BY id DESC";

        //Securisation des variables
        /* @var $bdd PDO */
        $sth = $bdd->prepare($sql);
        $sth->bindValue(':recherche', '%' . $recherche . '%', PDO::PARAM_STR);
        $sth->bindValue(':publie', 1, PDO::PARAM_BOOL);
// Je mets dans la variable tab_articles le corps de mon article 
        if ($sth->execute() == TRUE) {
            $tab_articles = $sth->fetchAll(PDO::FETCH_ASSOC); // Prends toutes les données de ton tableau
            // print_r($tab_articles);
            //  echo $tab_articles[0]['texte'];
           // Je mets un message dans la variable notification pour lui montrer que la recherche a ete effectuer et on affiche le nombre de correspondance
            
            $count = $sth->rowCount();
            $notification = "$count Article(s) trouvé(s)";
            $nb_pages = 1;
            $_SESSION['notification_result'] = TRUE;
            $_SESSION['notification'] = $notification;
             // Si j'ai aucun article correspondant à la recherche je le renvoie sur l'accueil avec un message 
            if ($count == 0) {
                $notification = 'Aucun article ne correspond à votre recherche';
                $_SESSION['notification_result'] = FALSE;
                $_SESSION['notification'] = $notification;
                header('Location: index.php');
                exit();
            }
        } else {
            echo ' une erreur est survenue...';
        }
    } else {
        // si l'utilisateur clique sur le bouton sans rien avoir renseigner dans le champs
        $notification = 'Veuillez insérer une recherche';
        $_SESSION['notification_result'] = FALSE;
        $_SESSION['notification'] = $notification;
    }
}


include 'notification.php';

if (isset($_SESSION['notification'])) {
    $notification_result = $_SESSION['notification_result'] == TRUE ? 'alert-success' : 'alert-danger';
// On vérifie si il y a bien quelque chose dans la variable notifications

    unset($_SESSION['notification']);
    unset($_SESSION['notification_result']);
    // on l'enleve quand on rafraichit la page
} else {
    $notification_result = "";
    $notification = "";
}
// mise en place de Smarty
$smarty = new Smarty();

$smarty->setTemplateDir('templates/');
$smarty->setCompileDir('templates_c/');
//$smarty->setConfigDir('configs/');
//$smarty->setCacheDir('cache/');
$smarty->assign('is_connect', $is_connect);
$smarty->assign('admin', $admin);
if ($is_connect == TRUE) {
    $smarty->assign('nom_correct', $nom_correct);
    $smarty->assign('prenom_correct', $prenom_correct);
}
$smarty->assign('session_tab', $_SESSION);
$smarty->assign('tab_articles', $tab_articles);
$smarty->assign('nb_pages', $nb_pages);
$smarty->assign('nb_articles_par_page', $nb_articles_par_page);
$smarty->assign('page_courante', $page_courante);
$smarty->assign('index', $index);
$smarty->assign('nb_total_article_publie', $nb_total_article_publie);
$smarty->assign('recherche', $recherche);
$smarty->assign('notification', $notification);
$smarty->assign('is_connect', $is_connect);

$smarty->assign('notification_result', $notification_result);
//$smarty->assign('name',$prenom);
//** un-comment the following line to show the debug console
//$smarty->debugging = true;

include 'include/header.inc.php';
$smarty->display('index.tpl');

include 'include/footer.inc.php';
?>