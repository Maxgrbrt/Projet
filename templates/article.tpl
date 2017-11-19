<!-- Page Content -->
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1 class="mt-5">
    {echo $_GET['action'], ' votre article';}
    
   
                </h1>
            </div>
                  


        </div>
    </div>

    <div class="container">
        <form <?php if ($_GET['action'] == 'Modifier') { ?>action="article.php?action=Modifier&id_article=<?php echo $id_article ?>"<?php } else { ?>action="article.php" <?php } ?>method="post" enctype="multipart/form-data" id="form_article">
            <div class="form-row"> 
                <div class="form-group col-md-6">
                    <label for="titre" class="col-form-label">Titre</label>

                    <input type="text" class="form-control" id="titre" placeholder="Titre de votre article" name="titre" value="<?php
        if ($_GET['action'] == 'Modifier') {
            echo $tab_articles[0]['titre'];
        } else {
            
        }
                ?>">

                </div>

            </div>
            <div class="form-group">
                <label for="texte" class="col-form-label">Texte</label>
                <textarea class="form-control" id="texte" name="texte" rows="3"  ><?php
                if ($_GET['action'] == 'Modifier') {
                    echo $tab_articles[0]['texte'];
                } else {
                    
                }
                ?></textarea>

            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="file" >Image</label>
                    <input type="file" class="form-control" id="image" name="image">
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
                        <input class="form-check-input" type="checkbox" value="1" name="publie" <?php if ($_GET['action'] == 'Modifier') {
                    ?> checked=""<?php } ?>> Publié
                    </label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary" name="submit" id="submit" value="<?php echo $_GET['action']; ?>"><?php echo $_GET['action']; ?></button>

        </form>
    </div>
    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/popper/popper.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>