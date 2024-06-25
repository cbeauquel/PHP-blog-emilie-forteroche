<?php

/**
 * Classe qui gère le monitoring.
 */
class MonitoringManager extends AbstractEntityManager
{
/**
 * on récupère le nombre de views.
 */
    public function showViews() : array {
        $sql = "SELECT  `id_article`, COUNT(`id`) as `nbViews`  FROM `connections` group BY `id_article`";

        $result = $this->db->query($sql);
        $rows = $result->fetchAll(PDO::FETCH_ASSOC);
        $nbViews = [];
        // Conversion des résultats en objets nbViews
        foreach ($rows as $row) {
            $monitoring = new Monitoring();
            $monitoring->setNbViews($row['nbViews']);
            $monitoring->setIdArticle($row['id_article']);
            $nbViews[] = $monitoring;
        }
        return $nbViews;
    }

/**
 * on récupère le nombre de commentaires.
 */
        public function showNbComments() : array {
            $sql = "SELECT `id_article`, COUNT(`id`) as `nbComments` FROM `comment` group by `id_article`";
            $result = $this->db->query($sql);
            $rows = $result->fetchAll(PDO::FETCH_ASSOC);
    
            $nbComments = [];
            // Conversion des résultats en objets nbComments
            foreach ($rows as $row) {
                $monitoring = new Monitoring();
                $monitoring->setNbComments($row['nbComments']);
                $monitoring->setIdArticle($row['id_article']);
                $nbComments[] = $monitoring;
            }
        
        return $nbComments;
    }

    /**
     * on récupère les données.
     */
    public function extractStats() : array {
        $sql = "SELECT a. `title`, a.`id` as `IdArticle`,  a. `date_creation`, COUNT(DISTINCT(b.`id`)) as `nbViews`, COUNT(DISTINCT(c.`id`)) as `nbComments`
                FROM `article` a
                LEFT JOIN `connections` b ON a. `id` = b. `id_article`
                LEFT JOIN `comment` c ON a. `id` = c. `id_article`
                GROUP BY a. `title`,  a.`id`
                ORDER BY a.`id`";
        $result = $this->db->query($sql);
        //$rows = $result->fetchAll(PDO::FETCH_ASSOC);

        $stats = [];
        while ($stat = $result->fetch()) {
            $stats[] = new Monitoring($stat);
        }
        // Conversion des résultats en objets nbComments
        // foreach ($rows as $row) {
        //     $monitoring = new Monitoring();
        //     $monitoring->setIdArticle($row['IdArticle']);
        //     $monitoring->setTitle($row['title']);
        //     $monitoring->setDateCreation($row['date_creation']);
        //     $monitoring->setNbComments($row['nbViews']);
        //     $monitoring->setNbComments($row['nbComments']);

        //     $stats[] = $monitoring;
        // }

    return $stats;
    }


}