<?php

try {
    
    $bdd = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', 'root');
     
     
    /*
    $bdd = new PDO('mysql:host=localhost;dbname=id3522028_bddsite;charset=utf8', 'id3522028_bddsite', '3ybc9d6x');
     * 
     */
    $bdd->exec("set names utf8");
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
?>
