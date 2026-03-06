<?php

    /**
     * Template pour afficher une page d'erreur.
     */

?>

<div class="error">
    <h2>Erreur</h2>
    <p><?= htmlspecialchars($errorMessage) ?></p>
    <a href="index.php?action=home">Retour à la page d'accueil</a>
</div>
