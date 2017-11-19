

<div class="container">
    
    <div class="container">

        <div class="col-lg-12 text-center">
            <h1 class="mt-5">Nos Articles </h1>


        </div>
    </div>

    <!-- Affichage du contenu d'un article sur la page index pour chaque article -->

{foreach from=$tab_articles item=value}
        <div class="container" >
            <img class="card-img-top" src="img/{$value['id']}.jpg" alt="{$value['id']}.jpg">
            <div class="card">
            <div class="card-body">
                <h4 class="card-title">{$value['titre']}</h4>
                <p class="card-text">{$value['texte']}</p>
                <a href="#" class="btn btn-primary">{$value['date_fr']}</a>
                
              <a href="article_page.php?id_article={$value['id']}" class="btn btn-primary">Lire l'article</a>
              
    <!-- Affichage du bouton Modifer et Supprimer si l'utilisateur est connecté -->
                {if $is_connect == TRUE}
                     
       
                    <a href="article.php?action=Modifier&id_article={$value['id']}" class="btn btn-primary">Modifier l'article</a>
                    {/if}
                    <!-- Le compte admin peut supprimer n'importe quel article -->
                    {if $admin == TRUE}
                    <a href="article.php?action=Supprimer&id_article={$value['id']}" class="btn btn-danger">Supprimer l'article</a>
           {/if}
        </div></div></div><br>

    {/foreach}
    <br>
    <div class="container">
    <nav aria-label="Page navigation example">
        <ul class="pagination">
   
    <!-- Pagination jusqu'au nombre de page calculé dans la page php -->
    
        {for $i =1 to $nb_pages}
                <li class="page-item {if $page_courante == $i}active{/if}">
                    <a class="page-link" href="?page={$i}?search={$recherche}">{$i}</a>
                </li>{/for}
        </ul>
    </nav>
</div>
</div>





<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/popper/popper.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>


