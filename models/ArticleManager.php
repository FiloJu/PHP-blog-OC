<?php

/**
 * Classe qui gère les articles.
 */
class ArticleManager extends AbstractEntityManager
{
    /**
     * Récupère tous les articles.
     * @return array : un tableau d'objets Article.
     */
    public function getAllArticles(): array
    {
        $sql = "SELECT * FROM article";
        $result = $this->db->query($sql);
        $articles = [];

        while ($article = $result->fetch()) {
            $articles[] = new Article($article);
        }
        return $articles;
    }

    /**
     * Récupère un article par son id.
     * @param int $id : l'id de l'article.
     * @return Article|null : un objet Article ou null si l'article n'existe pas.
     */
    public function getArticleById(int $id): ?Article
    {
        $sql = "SELECT * FROM article WHERE id = :id";
        $result = $this->db->query($sql, ['id' => $id]);
        $article = $result->fetch();
        if ($article) {
            return new Article($article);
        }
        return null;
    }

    /**
     * Récupère tous les articles avec leurs stats (vues, commentaires, date).
     * @param string $sortBy : colonne de tri.
     * @param string $order : ASC ou DESC.
     * @return array : un tableau d'arrays associatifs.
     */
    public function getAllArticlesWithStats(string $sortBy = 'date_creation', string $order = 'DESC'): array
    {
        // On liste les colonnes autorisées pour éviter les injections SQL.
        $allowedSortBy = ['title', 'views_count', 'nb_comments', 'date_creation'];
        $allowedOrder = ['ASC', 'DESC'];

        // Si la valeur reçue n'est pas autorisée, on remet la valeur par défaut.
        if (!in_array($sortBy, $allowedSortBy)) {
            $sortBy = 'date_creation';
        }
        if (!in_array($order, $allowedOrder)) {
            $order = 'DESC';
        }

        $sql = "SELECT 
                a.id,
                a.title,
                a.views_count,
                a.date_creation,
                COUNT(c.id) AS nb_comments
            FROM article a
            LEFT JOIN comment c ON c.id_article = a.id
            GROUP BY a.id
            ORDER BY $sortBy $order";

        $result = $this->db->query($sql);
        $articles = [];

        while ($row = $result->fetch()) {
            $articles[] = $row;
        }
        return $articles;
    }


    /**
     * Ajoute ou modifie un article.
     * On sait si l'article est un nouvel article car son id sera -1.
     * @param Article $article : l'article à ajouter ou modifier.
     * @return void
     */
    public function addOrUpdateArticle(Article $article): void
    {
        if ($article->getId() == -1) {
            $this->addArticle($article);
        } else {
            $this->updateArticle($article);
        }
    }

    /**
     * Ajoute un article.
     * @param Article $article : l'article à ajouter.
     * @return void
     */
    public function addArticle(Article $article): void
    {
        $sql = "INSERT INTO article (id_user, title, content, date_creation) VALUES (:id_user, :title, :content, NOW())";
        $this->db->query($sql, [
            'id_user' => $article->getIdUser(),
            'title' => $article->getTitle(),
            'content' => $article->getContent()
        ]);
    }

    /**
     * Modifie un article.
     * @param Article $article : l'article à modifier.
     * @return void
     */
    public function updateArticle(Article $article): void
    {
        $sql = "UPDATE article SET title = :title, content = :content, date_update = NOW() WHERE id = :id";
        $this->db->query($sql, [
            'title' => $article->getTitle(),
            'content' => $article->getContent(),
            'id' => $article->getId()
        ]);
    }

    /**
     * Supprime un article.
     * @param int $id : l'id de l'article à supprimer.
     * @return void
     */
    public function deleteArticle(int $id): void
    {
        $sql = "DELETE FROM article WHERE id = :id";
        $this->db->query($sql, ['id' => $id]);
    }

    public function incrementViewsCount(int $id): void
    {
        $sql = "UPDATE article SET views_count = views_count + 1 WHERE id = :id";
        $this->db->query($sql, ['id' => $id]);
    }
}