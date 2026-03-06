<?php
/**
 * Affichage des statistiques des articles : vues, commentaires, date.
 * Tableau triable par colonne.
 */

// Petite fonction locale pour générer l'URL de tri.
function sortUrl(string $column, string $currentSortBy, string $reverseOrder): string
{
    $order = ($column === $currentSortBy) ? $reverseOrder : 'ASC';
    return htmlspecialchars("index.php?action=showStats&sortBy=$column&order=$order");
}

// Flèche pour indiquer le tri actif.
function sortArrow(string $column, string $currentSortBy, string $order): string
{
    if ($column !== $currentSortBy)
        return '';
    return $order === 'ASC' ? ' ▲' : ' ▼';
}
?>

<h2>Statistiques des articles</h2>

<a class="submit" href="index.php?action=admin">← Retour à l'administration</a>

<table class="statsTable">
    <thead>
        <tr>
            <th>
                <a href="<?= sortUrl('title', $sortBy, $reverseOrder) ?>">
                    Titre<?= sortArrow('title', $sortBy, $order) ?>
                </a>
            </th>
            <th>
                <a href="<?= sortUrl('views', $sortBy, $reverseOrder) ?>">
                    Vues<?= sortArrow('views', $sortBy, $order) ?>
                </a>
            </th>
            <th>
                <a href="<?= sortUrl('nb_comments', $sortBy, $reverseOrder) ?>">
                    Commentaires<?= sortArrow('nb_comments', $sortBy, $order) ?>
                </a>
            </th>
            <th>
                <a href="<?= sortUrl('date_creation', $sortBy, $reverseOrder) ?>">
                    Date<?= sortArrow('date_creation', $sortBy, $order) ?>
                </a>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($articles as $index => $article) { ?>
            <tr class="<?= ($index % 2 === 0) ? 'rowEven' : 'rowOdd' ?>">
                <td><?= Utils::format($article->getTitle()) ?></td>
                <td><?= $article->getViewsCount() ?></td>
                <td><?= $article->getNbComments() ?></td>
                <td><?= $article->getDateCreation()->format('d/m/Y') ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>