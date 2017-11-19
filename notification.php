<?php
require_once 'config/init.conf.php';
require_once 'config/bdd.conf.php';
if (isset($_SESSION['notification'])) {
    $notification_result = $_SESSION['notification_result'] == TRUE ? 'alert-success' : 'alert-danger';
// On vérifie si il y a bien quelque chose dans la variable notifications
    //alert-success = notif en vert sinon en rouge
    ?>
    <div class="alert <?= $notification_result ?> alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>


        <?= $_SESSION['notification']; ?> 
    </div>
    <?php
    unset($_SESSION['notification']);
    unset($_SESSION['notification_result']);
    // on l'enleve quand on rafraichit la page
}
?>