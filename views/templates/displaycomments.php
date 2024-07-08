<?php 
    /** 
     * Affichage de la partie admin : commentaires et suppression des commentaires. 
     */
?>

<h2>Gestion des commentaires</h2>

<div class="adminComment">
    <?php foreach ($comments as $comment) { ?>
        <div class="commentLine">
            <div class="pseudo"><?= $comment->getPseudo() ?></div>
            <div class="content"><?= $comment->getContent() ?></div>
            <div class="date"><?= ucfirst(Utils::convertDateToFrenchFormat($comment->getDateCreation())) ?></div>
            <div class="supprimer">
                <form method="post" id="delete" action="index.php?action=deleteComment&id=<?= $comment->getId()?>" class="hidden">
                    <input type="hidden" id="id" name="id" value="<?= $comment->getId()?>">
                    <input type="hidden" id="pseudo" name="pseudo" value="<?= $comment->getPseudo()?>">
                    <input type="hidden" id="content" name="content" value="<?= $comment->getContent()?>">
                    <input type="hidden" id="datecreation" name="datecreation" value="<?php $comment->getDateCreation();?>">
                </form>
                <a class="submit" href="#" onclick='document.getElementById("delete").submit(); return confirm("Êtes-vous sûr de vouloir supprimer cet article ?")'>Supprimer</a>
            </div>
        </div>
    <?php } ?>
</div>

<nav>
    <div class="nav">
        <a class="submit" href="index.php?action=admin">Retour aux articles</a>

    </div>
</nav>