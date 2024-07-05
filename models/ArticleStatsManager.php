<?php 
class ArticleStatsManager extends AbstractEntityManager{

     /**
     * on récupère les données sur l'article.
     */
    public function extractStatsArticle() : array {
        $sql = "SELECT a. `id`, a. `title` as `titre`, a. `date_creation` as `date`, COUNT(DISTINCT(b.`id`)) as `vues`, COUNT(DISTINCT(c.`id`)) as `commentaires`, b. id 
                FROM `article` a
                LEFT JOIN `connections` b ON a. `id` = b. `id_article`
                LEFT JOIN `comment` c ON a. `id` = c. `id_article`
                GROUP BY a. `title`";

        $result = $this->db->query($sql);

        $stats = [];
        while ($stat = $result->fetch()) {
            $statsArticle[] = new ArticleStats($stat);
        }

       return $statsArticle;
    }

}