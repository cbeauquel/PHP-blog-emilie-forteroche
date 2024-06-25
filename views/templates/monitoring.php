<?php 
    /** 
     * Affichage de la partie admin : statistiques de consultation des articles et commentaires. 
     */
?>

<h2>Statistiques de consultation</h2>

<div class="statConsultations">
    <?php foreach ($stats as $stat) { ?>
        <div class="articleLine">
            <div class="title"><?= $stat->getTitle() ?></div>
            <div class="content"><?= ucfirst(Utils::convertDateToFrenchFormat($stat->getDateCreation())) ?></div>
            <div class="content"><?= $stat->getNbViews() ?></div>
            <div class="content"><?= $stat->getNbComments() ?></div>
        </div>
    <?php } ?>
</div>

<nav>
    <div class="nav">
        <a class="submit" href="index.php?action=admin">Retour aux articles</a>

    </div>
</nav>