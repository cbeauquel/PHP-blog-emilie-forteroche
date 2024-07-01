<?php 
    /** 
     * Affichage de la partie admin : statistiques de consultation des articles et commentaires. 
     */
?>

<h2>Statistiques de consultation</h2>

<div class="adminArticle">
    <?php
    Utils::createTable($stats);
    //var_dump($_POST);
    //var_dump(buildSortCol($colonnes, $header));
    ?>
</div>

<nav>
    <div class="nav">
        <a class="submit" href="index.php?action=admin">Retour aux articles</a>

    </div>
</nav>