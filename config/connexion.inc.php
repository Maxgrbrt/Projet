<?php
require_once 'config/init.conf.php';
require_once 'config/bdd.conf.php';
$is_connect = FALSE;
$admin = false;
// Je verifie le sid dans mes cookies
if (!empty($_COOKIE['sid'])) {
// Je regarde si le sid de mes cookies correspond z mon sid de ma bdd
$connexion = "SELECT sid, nom, prenom,email FROM utilisateurs WHERE sid = :sid ";
/* @var $bdd PDO */
//on met les champs rentrés par l'utilisateur dans $sth
$sth = $bdd->prepare($connexion);
$sth->bindValue(':sid', $_COOKIE['sid'], PDO::PARAM_STR);

if ($sth->execute() == TRUE) {
    //on met le contenu de notre tableau das la variable tab_result
    $tab_result = $sth->fetch(PDO::FETCH_ASSOC);
    // on compte le nombre de sid corresondant 
    $count = $sth->rowCount();

    if ($count > 0) {
        //  echo 'Vous etes connecte';

        $is_connect = TRUE;
        $email_correct = $tab_result['email'];
        $nom_correct = $tab_result['nom'];
        $prenom_correct = $tab_result['prenom'];
        // Si l'email correspond a root@root.fr je suis sur le compte admin
        if ($email_correct == 'root@root.fr'){
           $admin = TRUE;
           
        }
    } else {
       // echo 'Aucun sid correspondant';
    }
} else {
    echo 'erreur';
}
if ($is_connect == TRUE) {
    $_SESSION['notification_result'] = TRUE;
}

    $sid = $_COOKIE['sid'];
    //  echo $sid;
} else {
    
}


// On vérifie si il y a bien quelque chose dans la variable notifications
?> 
<div class="container">
<?php
// Si l'utilisateur est connecté je l'affichage en haut de la page 
if ($is_connect == TRUE) {
    // On avertit qu'on est connecté en administrateur si c'est le cas sinon on affichage le nom et prenom de l'utilisateur
if ($admin == TRUE) {
    ?>

    <div class="alert alert-primary" role="alert">
        Vous etes connecté en tant que Administrateur
    <?php
} else {
    ?>

     <div class="alert alert-primary" role="alert">
        Vous etes connecté en tant que <?php echo $nom_correct, " ", $prenom_correct ?>
   <?php
    }
}
   
    
 else {
   
    
}
?>
</div>

</div>

