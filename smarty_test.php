
<?php
require_once 'config/init.conf.php';


require_once 'config/bdd.conf.php';
require_once 'config/connexion.inc.php';
require_once 'include/fonction.inc.php';
require_once('libs/Smarty.class.php');


$smarty = new Smarty();

$smarty->setTemplateDir('templates/');
$smarty->setCompileDir('templates_c/');
//$smarty->setConfigDir('configs/');
//$smarty->setCacheDir('cache/');

$smarty->assign('is_connect',$is_connect);
$smarty->assign('nom_correct',$nom_correct);
$smarty->assign('prenom_correct',$prenom_correct);
$smarty->assign('session_tab',$_SESSION);
$smarty->assign('tab_articles',$tab_articles);
$smarty->assign('nb_pages',$nb_pages);
$smarty->assign('nb_articles_par_page',$nb_articles_par_page);
$smarty->assign('page_courante',$page_courante);
$smarty->assign('index',$index);
$smarty->assign('nb_total_article_publie',$nb_total_article_publie);
$smarty->assign('recherche',$recherche);
$smarty->assign('notification',$notification);
$smarty->assign('is_connect',$is_connect);

//** un-comment the following line to show the debug console
//$smarty->debugging = true;

include 'include/header.inc.php';
$smarty->display('index.tpl');

include 'include/footer.inc.php';
?>

