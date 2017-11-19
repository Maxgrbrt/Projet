<?php
require_once 'config/init.conf.php';
require_once 'config/bdd.conf.php';
require_once 'include/fonction.inc.php';
require_once 'config/connexion.inc.php';

include 'include/header.inc.php';

include 'notification.php';
?>
<?php
if (isset($_POST['submit'])) {
    // print_r($_POST);


    $notification = 'aucune notification a afficher ';
    $_SESSION['notification_result'] = FALSE;
    // Si les champs email et mot de passe ne sont pas vide 
    if (!empty($_POST['email']) AND !empty($_POST['mdp'])) {

        $mdp_hash = cryptPassword($_POST['mdp']);
// On regarde l'email et le mdp correspondent a quelqu'un dans la base de donnée
        $select_user = "SELECT email, "
                . "mdp "
                . "FROM utilisateurs "
                . "WHERE email = :email "
                . "AND mdp = :mdp";

        /* @var $bdd PDO */
        //on met les champs rentrés par l'utilisateur dans $sth
        $sth = $bdd->prepare($select_user);
        $sth->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
        $sth->bindValue(':mdp', $mdp_hash, PDO::PARAM_STR);
// count prendre la valeur du nombre de email + mdp corresponndant a l'entrée
        if ($sth->execute() == TRUE) {
            $count = $sth->rowCount();
            // Si il y a une correspondance
            if ($count > 0) {
                $sid = sid($_POST['email']);
                // Requete SQL pour mettre un sid sur l'utilisateur correspondant a la connexion
                $update_sid = "UPDATE utilisateurs "
                        . "SET sid = :sid "
                        . "WHERE email = :email";
// On met a jour a valeur du sid dans la base de donnée
                $sth_update = $bdd->prepare($update_sid);
                $sth_update->bindValue(':sid', $sid, PDO::PARAM_STR);
                $sth_update->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
// On crée le cookie 
                if ($sth_update->execute() == TRUE) {
                    setcookie('sid', $sid, time() + 86400);
                    $_SESSION['notification_result'] = TRUE;
                    $notification = 'Vous etes connecte';
                    $_SESSION['notification'] = $notification;

                    header("Location: index.php");
                    exit();
                } else {
                    $notification = 'Une erreur technique est survenue';
                    $_SESSION['notification_result'] = FALSE;
                    $_SESSION['notification'] = $notification;
                }
            } else {
                // On avertit l'utilisateur que les champs entrés sont incorrects
                $notification = 'Mauvais email ou mot de passe';
                $_SESSION['notification_result'] = FALSE;
                $_SESSION['notification'] = $notification;
            }
        } else {
            $notification = 'Une erreur est survenue';
            $_SESSION['notification_result'] = FALSE;
            $_SESSION['notification'] = $notification;
        }
    } else {
        // On avertit l'utilisateur qu'il n'a rien entré
        $notification = 'Veuillez renseigner les champs';
        $_SESSION['notification_result'] = FALSE;
        $_SESSION['notification'] = $notification;
    }
}
?>
<!-- Affichage de la page, avec email et mot de passe  -->
<div class="container">
    <div class="row">
        <div class="col-lg-12 text-center">
            <h1 class="mt-5">Connexion</h1>
        </div>
        <div class="container">

            <form action="connexion.php" method="post" enctype="multipart/form-data" id="form_inscription">


                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="email" >Adresse mail</label>


                        <input type="email" class="form-control" id="email" name="email" required>
                        <label id ="email-error" class="error" for="email" ></label>
                    </div>

                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="mdp" class="col-form-label">Mot de passe </label>
                        <input type="password" class="form-control" id ="mdp"name="mdp" required> 
                        <label id ="mdp-error" class="error" for="mdp" ></label>

                    </div>
                </div>
                <button type="submit" class="btn btn-primary" name="submit" id="submit">Envoyer</button>

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
        ?>