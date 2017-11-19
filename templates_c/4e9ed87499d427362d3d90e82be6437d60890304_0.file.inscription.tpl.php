<?php
/* Smarty version 3.1.30, created on 2017-11-18 00:23:01
  from "C:\Users\Max\Desktop\Site\www\Projet\templates\inscription.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a0f7d65d5e9d4_79582057',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4e9ed87499d427362d3d90e82be6437d60890304' => 
    array (
      0 => 'C:\\Users\\Max\\Desktop\\Site\\www\\Projet\\templates\\inscription.tpl',
      1 => 1509983020,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a0f7d65d5e9d4_79582057 (Smarty_Internal_Template $_smarty_tpl) {
?>
<meta charset="utf-8">
<div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1 class="mt-5">Inscription</h1>
            </div> 
          
           
       


        </div>
    </div>

    <div class="container">

        <form action="inscription.php" method="post" enctype="multipart/form-data" id="form_inscription">
            <div class="form-row"> 
                <div class="form-group">
                    <label for="nom" class="col-form-label">Nom</label>
                    <input type="text" class="form-control" id="nom"  name="nom" required>
                     <label id ="nom-error" class="error" for="nom" ></label>
                </div>

            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="prenom" class="col-form-label" >Prénom</label>
                    <input type="text" class="form-control" id="prenom" name="prenom" required >
<label id ="prenom-error" class="error" for="prenom" ></label>
                </div></div>

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
    <?php echo '<script'; ?>
 src="vendor/jquery/jquery.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="vendor/popper/popper.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="vendor/bootstrap/js/bootstrap.min.js"><?php echo '</script'; ?>
>
     <?php echo '<script'; ?>
 src="js/dist/jquery.validate.min.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="js/dist/localization/messages_fr.min.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
>
            $(document).ready(function() {

                $("#form_inscription").validate();
            })
            document.getElementById('nom-error').style.color='red';
            
            document.getElementById('prenom-error').style.color='red';
            document.getElementById('email-error').style.color='red';
            document.getElementById('mdp-error').style.color='red';

        <?php echo '</script'; ?>
>
  <?php }
}
