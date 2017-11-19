<?php
require_once 'config/init.conf.php';
require_once 'config/bdd.conf.php';

require_once 'config/connexion.inc.php';
require_once 'include/fonction.inc.php';
include 'include/header.inc.php';
include 'notification.php';

// Si j'appuie sur mon bouton poster le commentaire
if (isset($_POST['envoyer'])) {
    // Je vérifie si jai bien rempli mon texte et mon email
    if (!empty($_POST['texte']) AND !empty($_POST['email'])) {
        // Si j'ai pas renseigné mon pseudo je mets Anonymous
        if (empty($_POST['pseudo'])) {
            $_POST['pseudo'] = 'Anonymous';
        } else {
            
        }
// je prends la valeur de l'article que je commente et je mets un timestamp dans la date pour connaitre la date ou le commentaire a été posté
        $id_article = $_GET['id_article'];
         $date_du_jour = time();
        $insert = "INSERT INTO commentaire (texte_com, email, id_commentaire, pseudo,date)"
                . "VALUES (:texte, :email, $id_article, :pseudo, :date)";

        /*      */

        /* @var $bdd PDO */
        $sth = $bdd->prepare($insert);
        $sth->bindValue(':texte', $_POST['texte'], PDO::PARAM_STR);
        $sth->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
$sth->bindValue(':date', $date_du_jour, PDO::PARAM_STR);
        $sth->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
    }
    if ($sth->execute() == TRUE) {
        // On avertit que l'utilisateur a bien poster son commentaire
        $notification = 'Félicitation votre commentaire a été posté';
        $_SESSION['notification_result'] = TRUE;
        $_SESSION['notification'] = $notification;
        header("Location: article_page.php?id_article=$id_article");
        exit();
    }
} else {
    
}
// On selectionne l'article que l'utilisateu veut consulter dans la base de donnée
$id_article = $_GET['id_article'];
$page_article = "SELECT titre, "
        . "texte "
        . "FROM articles  "
        . "WHERE id = $id_article ";

//echo $select;
/* @var $bdd PDO */
$sth_modif = $bdd->prepare($page_article);
if ($sth_modif->execute() == TRUE) {
    //Je mets le contenu de l'article dans la variable tab_articles
    $tab_articles = $sth_modif->fetchAll(PDO::FETCH_ASSOC); // Prends toutes les données de ton tableau
}
// On prends les commentaire de l'article correspondant du plus ancien au plus recent grace au timestamp
$commentaire = "SELECT texte_com, "
        . "email, "
        . "pseudo "
        . "FROM commentaire "
        . "INNER JOIN articles ON articles.id = commentaire.id_commentaire AND commentaire.id_commentaire = $id_article ORDER BY commentaire.date ";
$sth_com = $bdd->prepare($commentaire);
if ($sth_com->execute() == TRUE) {
    // On met le contenu (pseudo,email,texte) dans la variable tab_com
    $tab_com = $sth_com->fetchAll(PDO::FETCH_ASSOC); // Prends toutes les données de ton tableau
}


?>


<!-- Page Content -->
<div class="container">
    <div class="row">
        <div class="col-lg-12 text-center">
            <div class="card-body">
            <br>
            <h3 class="card-title">

                <?php
                // Affichage du titre de l'article que l'utilisateur veut consulter
                print_r(($tab_articles[0]['titre']));
                echo ('<br>');
                echo ('<br>');
                ?>
            </h3>
            <?php // Affichage de l'image de l'article ?>
            <img class="card-img-top" src="img/<?= $id_article ?>.jpg" alt="<?= $id_article ?>.jpg">
            <p class="alert alert-secondary">
                <?php
                // Affichage du texte de l'article
                echo ('<br>');
                print_r(($tab_articles[0]['texte']));
                ?>
            </p>
            </ul>
        </div></div>
    </div>
</div>
<form action="article_page.php?id_article=<?php echo $id_article ?>" method="post" enctype="multipart/form-data" id="form_article">

    <br>
<!-- Affichage de la section commentaire -->
    <div class="container">

        <h4 class="card-title text-center"> Commentaires</h4><br>
        <?php
        foreach ($tab_com as $value) {
            // pour chaque commentaire de cette page dans la base de donnée on affiche le contenu
            ?>

            <p class="alert alert-secondary">Posté par : <?php 
            // Affichage du pseudo puis du contenu du message
            print_r(($value['pseudo'])); ?><br>
                <?php print_r(($value['texte_com']));
            } ?></p></div>
    
    <div class="container">
        <h4 class="card-title text-center"> Insérer un commentaire</h4><br>
        <div class="row">
            <div class="col">
                <input type="text" name="pseudo" id="pseudo" class="form-control" placeholder="Pseudo">
            </div>
            <div class="col">
                <input type="email" name="email" id="email" class="form-control" placeholder="Email" required>
            </div>
        </div>
        <br>
        <textarea name="texte" id="texte"cols="155" rows="6" required></textarea><br>
        <br><button type="submit" class="btn btn-primary" name="envoyer" id="envoyer" value="Envoyer">Poster commentaire</button>

    </div>
</form>

<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/popper/popper.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<?php
include 'include/footer.inc.php';
?>