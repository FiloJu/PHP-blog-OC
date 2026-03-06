<?php

/**
 * Affichage des statistiques des articles : vues, commentaires, date.
 * Tableau triable par colonne.
 */

use App\Services\StatsHelper;

?>

<h2>Statistiques des articles</h2>

<a class="submit" href="index.php?action=admin">← Retour à l'administration</a>

<table class="statsTable">
    <thead>
        <tr>
            <th>
                <a href="<?= StatsHelper::sortUrl('title', $sortBy, $reverseOrder) ?>">
                    Titre<?= StatsHelper::sortArrow('title', $sortBy, $order) ?>
                </a>
            </th>
            <th>
                <a href="<?= StatsHelper::sortUrl('views', $sortBy, $reverseOrder) ?>">
                    Vues<?= StatsHelper::sortArrow('views', $sortBy, $order) ?>
                </a>
            </th>
            <th>
                <a href="<?= StatsHelper::sortUrl('nb_comments', $sortBy, $reverseOrder) ?>">
                    Commentaires<?= StatsHelper::sortArrow('nb_comments', $sortBy, $order) ?>
                </a>
            </th>
            <th>
                <a href="<?= StatsHelper::sortUrl('date_creation', $sortBy, $reverseOrder) ?>">
                    Date<?= StatsHelper::sortArrow('date_creation', $sortBy, $order) ?>
                </a>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($articles as $index => $article) { ?>
            <tr class="<?= ($index % 2 === 0) ? 'rowEven' : 'rowOdd' ?>">
                <td><?= \App\Services\Utils::format($article->getTitle()) ?></td>
                <td><?= $article->getViewsCount() ?></td>
                <td><?= $article->getNbComments() ?></td>
                <td><?= $article->getDateCreation()->format('d/m/Y') ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>