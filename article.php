
<meta charset="utf-8">

<?php
// On fait venir les fichiers dont on a besoin
require_once 'config/init.conf.php';
require_once 'config/bdd.conf.php';
require_once 'config/connexion.inc.php';
require_once 'include/fonction.inc.php';
// Si l'utilisateur n'est pas connecte et tente d'accepter a cette page il recoit un message
if ($is_connect == FALSE) {
    echo 'Vous devez être connecté pour accéder à cette page';
    exit();
}

// Si je n'ai pas appuyer de bouton sur cette page et que j'ai Modifier dans l'URL
if (isset($_POST['submit']) == FALSE) {
    if ($_GET['action'] == 'Modifier') {
        $id_article = $_GET['id_article'];
        // Requete SQL pour récuperer le contenu de l'article que je souhaite modifier
        $modif = "SELECT titre, "
                . "texte "
                . "FROM articles  "
                . "WHERE id = $id_article ";

        //echo $select;
        /* @var $bdd PDO */
        $sth_modif = $bdd->prepare($modif);
        if ($sth_modif->execute() == TRUE) {
            $tab_articles = $sth_modif->fetchAll(PDO::FETCH_ASSOC); // Prends toutes les données de ton tableau
        } else {
            echo ' une erreur est survenue...';
        }
    }
// Si j'ai Supprimer dans l'URL c'est que j'ai appuyer sur le bouton supprimer sous l'article dans l'index
    if ($_GET['action'] == 'Supprimer') {
        $id_article = $_GET['id_article'];
        // Requete SQL pour supprimer l'article en question
        $supprimer = "DELETE "
                . "FROM articles  "
                . "WHERE id = $id_article ";

        //echo $select;
        /* @var $bdd PDO */
        $sth_modif = $bdd->prepare($supprimer);
        if ($sth_modif->execute() == TRUE) {
            // Notification pour dire a l'utilisateur que l'article a bien été supprimé
            $notification = 'Article Supprimé';
            $_SESSION['notification_result'] = FALSE;
            $_SESSION['notification'] = $notification;
            header('Location: index.php');
        } else {

            echo ' une erreur est survenue...';
        }
    }
}

// Si j'appuie sur le bouton envoyer de la page article.php
if (isset($_POST['submit'])) {


    print_r($_FILES);
// Une image est nécessaire pour envoyer un article ou le modifier
    if ($_FILES['image']['error'] == 0) {



        $notification = 'Aucune notification à afficher';
        $_SESSION['notification_result'] = FALSE;
        $date_du_jour = date("Y-m-d");
        // Si mon titre et mon texte ne sont pas vide 
        if (!empty($_POST['titre']) AND !empty($_POST['texte'])) {
// Si j'ai cliquer sur le bouton envoyer pour modifier un article je passe dans cette boucle
            if ($_POST['submit'] == 'Modifier') {
                $publie = isset($_POST['publie']) ? $_POST['publie'] : 0;
                $id_article = $_GET['id_article'];
                // requete sql pour mettre a jour l'article dans la base de donnée
                $update = "UPDATE articles "
                        . "SET titre = :titre, "
                        . "texte = :texte, "
                        . "publie = :publie "
                        . "WHERE id = $id_article ";

                $sth = $bdd->prepare($update);
                // on sécurise les variables
                $sth->bindValue(':titre', $_POST['titre'], PDO::PARAM_STR);
                $sth->bindValue(':texte', $_POST['texte'], PDO::PARAM_STR);

                $sth->bindValue(':publie', $publie, PDO::PARAM_BOOL);
            }


// Si on souhaite ajouter un article

            if ($_POST['submit'] == 'Ajouter') {
                $publie = isset($_POST['publie']) ? $_POST['publie'] : 0;
// On insert a l'interieur de notre article dans titre, texte etc leur valeur 

                $insert = "INSERT INTO articles (titre, texte, date,publie)"
                        . "VALUES (:titre, :texte, :date, :publie)";

                /*      */
//On sécurise les variables
                /* @var $bdd PDO */
                $sth = $bdd->prepare($insert);
                $sth->bindValue(':titre', $_POST['titre'], PDO::PARAM_STR);
                $sth->bindValue(':texte', $_POST['texte'], PDO::PARAM_STR);
                $sth->bindValue(':date', $date_du_jour, PDO::PARAM_STR);
                $sth->bindValue(':publie', $publie, PDO::PARAM_BOOL);
            }
            // $sth->bindValue(':id', $id_article, PDO::PARAM_INT);

            if ($sth->execute() == TRUE) {


                $id_article = $bdd->lastInsertId();
                $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                /*     $tab_extension = array(
                  'jpg',
                  'png',
                  'jpeg'
                  );
                  $result_extension_image = in_array($extension, $tab_extension);
                 */
// On récupére l'id de l'article en question dans une variable pour le modifier
                if ($_GET['action'] == 'Modifier') {
                    $id_article = $_GET['id_article'];
                }
                move_uploaded_file($_FILES['image']['tmp_name'], 'img/' . $id_article . '.' . $extension);

// On avertit l'utilisateur que l'article a été inséré

                $notification = '<strong>Félicitations, votre article est inséré</strong>';
                $_SESSION['notification_result'] = TRUE;
            } else {
                // On avertit l'utilisateur qu'il a oublié de compléter des champs
                $notification = 'Veuillez renseigner les champs obligatoires';
                $_SESSION['notification_result'] = FALSE;
            }
        } else {
            $notification = 'Erreur lors du traitement de votre image...';
            $_SESSION['notification_result'] = FALSE;
        }
    }
    $_SESSION['notification'] = $notification;
    header('Location: article.php?action=Ajouter');
    exit();
} else {
    include 'include/header.inc.php';
    include 'notification.php';
    ?>
    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1 class="mt-5"><?php
                // Affichage du mot "Ajouter" ou "Modifer" en fonction de ce que fait l'utilisateur
                    echo $_GET['action'], ' votre article';
                    ?>
                </h1>
            </div>



        </div>
    </div>

    <div class="container">
        <form <?php 
        // On renvoie vers la page Modifer ou Ajouter
        if ($_GET['action'] == 'Modifier') { ?>action="article.php?action=Modifier&id_article=<?php echo $id_article ?>"<?php } else { ?>action="article.php" <?php } ?>method="post" enctype="multipart/form-data" id="form_article">
            <div class="form-row"> 
                <div class="form-group col-md-6">
                    <label for="titre" class="col-form-label">Titre</label>

                    <input  type="text" class="form-control" id="titre" placeholder="Titre de votre article" name="titre"  value="<?php
                   // Affichage du titre de l'article a modifié
                    if ($_GET['action'] == 'Modifier') {
                        echo $tab_articles[0]['titre'];
                    } else {
                        
                    }
                    ?>" required>

                </div>

            </div>
            <div class="form-group">
                <label for="texte" class="col-form-label">Texte</label>
                <textarea class="form-control" id="texte" name="texte" rows="3" required ><?php
                // Affichage du texte de l'article a modifer
                    if ($_GET['action'] == 'Modifier') {
                        echo $tab_articles[0]['texte'];
                    } else {
                        
                    }
                    ?></textarea>

            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="file" >Image</label>
                    <input type="file" class="form-control" id="image" name="image" required>
                    <?php if ($_GET['action'] == 'Modifier') {
                        ?>
                        <img class="card-img-top"  src="img/<?= $id_article ?>.jpg" alt="<?= $id_article ?>.jpg" style="width: 150px;"><?php
                    } else {
                        
                    }
                    ?>
                </div>

            </div>
            <div class="form-group">
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" value="1" name="publie" <?php
                        //Si l'utilisateur souhaite modifier un article on met la case coché par default
                        if ($_GET['action'] == 'Modifier') {
                        ?> checked=""<?php } ?>> Publié
                    </label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary" name="submit" id="submit" value="<?php 
            // On change la valeur du bouton en fonction de ce que veut faire l'utilisateur Modifer ou Ajouter
            echo $_GET['action']; ?>"><?php echo $_GET['action']; ?></button>

        </form>
    </div>
    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/popper/popper.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="js/dist/jquery.validate.min.js"></script>
    <script src="js/dist/localization/messages_fr.min.js"></script>
    <script>
        $(document).ready(function() {

            $("#form_inscription").validate();
        })
        document.getElementById('email-error').style.color = 'red';

        document.getElementById('mdp-error').style.color = 'red';

    </script>
    <?php
    include 'include/footer.inc.php';
}
?>