<?php 
    /** 
     * Affichage de la partie admin : liste des articles avec un bouton "modifier" pour chacun. 
     * Et un formulaire pour ajouter un article. 
     */
?>

<h2>Edition des articles</h2>
<a class="submit" href="index.php?action=showUpdateArticleForm">Ajouter un article</a>
<div class="adminArticle">
    <?php foreach ($articles as $article) { ?>
        <div class="articleLine">
            <div class="title"><?= htmlspecialchars($article->getTitle()) ?></div>
            <div class="content"><?= htmlspecialchars($article->getContent(200)) ?></div>
            <div><a class="submit" href="index.php?action=showUpdateArticleForm&id=<?= htmlspecialchars($article->getId()) ?>">Modifier</a></div>
            <div><a class="submit" href="index.php?action=deleteArticle&id=<?= htmlspecialchars($article->getId()) ?>" <?= Utils::askConfirmation("Êtes-vous sûr de vouloir supprimer cet article ?") ?> >Supprimer</a></div>
        </div>
    <?php } ?>
</div>
<a class="submit" href="index.php?action=showStats">Voir les statistiques</a>