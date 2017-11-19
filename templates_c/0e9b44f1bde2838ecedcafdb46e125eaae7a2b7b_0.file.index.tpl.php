<?php
/* Smarty version 3.1.30, created on 2017-10-23 14:44:02
  from "C:\Users\mllea\Desktop\test\UwAmp\www\startbootstrap-bare-gh-pages\startbootstrap-bare-gh-pages\index.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59ee0032a34a44_57723458',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0e9b44f1bde2838ecedcafdb46e125eaae7a2b7b' => 
    array (
      0 => 'C:\\Users\\mllea\\Desktop\\test\\UwAmp\\www\\startbootstrap-bare-gh-pages\\startbootstrap-bare-gh-pages\\index.tpl',
      1 => 1508769345,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59ee0032a34a44_57723458 (Smarty_Internal_Template $_smarty_tpl) {
?>


<div class="container">
    <div class="row">

        <div class="col-lg-12 text-center">
            <h1 class="mt-5">Nos Articles </h1>


        </div>
    </div>

<?php echo '<?php
';?>foreach ($tab_articles as $value) {
    <?php echo '?>';?>

        <div class="card" >

            <img class="card-img-top" src="img/<?php echo '<?=';?> $value['id'] <?php echo '?>';?>.jpg" alt="<?php echo '<?=';?> $value['id'] <?php echo '?>';?>.jpg">
            <div class="card-body">
                <h4 class="card-title"><?php echo '<?=';?> $value['titre'] <?php echo '?>';?></h4>
                <p class="card-text"><?php echo '<?=';?> $value['texte'] <?php echo '?>';?></p>
                <a href="#" class="btn btn-primary"><?php echo '<?=';?> $value['date_fr'] <?php echo '?>';?></a>
                <a href="article.php?action=Modifier&id_article=<?php echo '<?=';?> $value['id'] <?php echo '?>';?>" class="btn btn-primary">Modifier l'article</a>
            </div>
        </div>

    <?php echo '<?php
';?>}
<?php echo '?>';?>
    <br>
    <nav aria-label="Page navigation example">
        <ul class="pagination">
    <?php echo '<?php
    ';?>for ($i = 1; $i <= $nb_pages; $i++) {
        $is_active = $page_courante == $i ? 'active' : '';
        <?php echo '?>';?>
                <li class="page-item <?php echo '<?=';?> $is_active <?php echo '?>';?>">
                    <a class="page-link" href="?page=<?php echo '<?=';?> $i <?php echo '?>';?>"><?php echo '<?=';?> $i <?php echo '?>';?></a>
                </li><?php echo '<?php
            ';?>}
            <?php echo '?>';?>

        </ul>
    </nav>

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
<?php echo '<?php
';?>include 'include/footer.inc.php';
<?php echo '?>';?>


<?php }
}
