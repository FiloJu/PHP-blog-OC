<?php

namespace App\Services;

class StatsHelper
{
    /**
     * Fonction pour générer l'URL de tri
     * @param string $column
     * @param string $currentSortBy
     * @param string $reverseOrder
     * @return string
     */
    public static function sortUrl(
        string $column,
        string $currentSortBy,
        string $reverseOrder
    ): string {
        $order = ($column === $currentSortBy) ? $reverseOrder : 'ASC';
        return htmlspecialchars(
            "index.php?action=showStats&sortBy=$column&order=$order"
        );
    }

    /**
     * Flèche pour indiquer le tri actif
     * @param string $column
     * @param string $currentSortBy
     * @param string $order
     * @return string
     */
    public static function sortArrow(
        string $column,
        string $currentSortBy,
        string $order
    ): string {
        if ($column !== $currentSortBy) {
            return '';
        }
        return $order === 'ASC' ? ' ▲' : ' ▼';
    }
}