
<!DOCTYPE html>
<html lang="fr">
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Max's Website</title>

        <!-- Bootstrap core CSS -->
        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <style>
            body {
                padding-top: 54px;
            }
            @media (min-width: 992px) {
                body {
                    padding-top: 56px;
                }
            }

        </style>

    </head>

    <body>

        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">

            <div class="container">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="container">
                    <form action="index.php" class="form-inline" method="get"  role="search" >

                        <input type="text" class="form-control mr-sm-2" name="search" placeholder="Rechercher un article">

                        <input class="btn btn-outline-success my-2 my-sm-0" type="submit" class="">
                    </form>
                </div>

                <div class="collapse navbar-collapse" id="navbarResponsive">

                    <ul class="navbar-nav ml-auto">

                        <li class="nav-item active">
                            <a class="nav-link" href="index.php">Accueil
                            </a>
                            
                        </li><?php 
                        //Je vérifie si quelqu'un est connecte
                        if ($is_connect == TRUE) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="article.php?action=Ajouter">Ajouter un article</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="inscription.php">Inscription</a>
                        </li>
                        <?php } ?>

                        <li class="nav-item">
                            <?php
                             //Je vérifie si quelqu'un est connecte
                            if ($is_connect == TRUE) {
                                ?>
                                <a class="nav-link" href="deconnexion.php">Déconnexion</a><?php } else {
                                ?>
                                <a class="nav-link" href="connexion.php">Connexion</a>
                                <?php
                            }
                            ?>

                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        


