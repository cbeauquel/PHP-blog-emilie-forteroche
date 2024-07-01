<?php

/**
 * Classe qui gère le monitoring.
 */
class MonitoringManager extends AbstractEntityManager
{

    /**
     * on récupère les données.
     */
    public function extractStats() : array {
        $sql = "SELECT a. `title`, a.`id` as `IdArticle`,  a. `date_creation`, COUNT(DISTINCT(b.`id`)) as `nbViews`, COUNT(DISTINCT(c.`id`)) as `nbComments`, b. page_tracked as PageTracked, b. ip_adress as IpAdress, b. id 
                FROM `article` a
                LEFT JOIN `connections` b ON a. `id` = b. `id_article`
                LEFT JOIN `comment` c ON a. `id` = c. `id_article`
                GROUP BY a. `title`,  a.`id`
                ORDER BY a.`id`";
        $result = $this->db->query($sql);

        $stats = [];
        while ($stat = $result->fetch()) {
            $stats[] = new Monitoring($stat);
        }
   

    return $stats;
    }

    public function collectStats() : void
    {
        // On récupère le nom de la page actuelle
        $pattern ='/^\/index\.php\?action\=([a-zA-Z]+)/';
        if(preg_match($pattern, $_SERVER['REQUEST_URI'], $matches)) {
            $pageTracked = $matches[1];
        } else {
            $pageTracked = "index.php";
        }
        //Si la page est un article, on récupère l'ID
        $idArticle = null;
        $pattern ='/^\/index\.php\?action\=showArticle\&id\=(\d+)$/';
        if(preg_match($pattern, $_SERVER['REQUEST_URI'], $matches)) {
             $idArticle = $matches[1];
        } 
        // On récupère l'adresse IP du visiteur
        $ipAdress = $_SERVER['REMOTE_ADDR'];
        
        // On vérifie si l'IP est déjà enregistrée pour cette session
        if (!isset($_SESSION['visite_enregistree_' . $pageTracked])) {
            $sql = "SELECT id FROM connections WHERE :ip_adress AND :page_tracked";
            $stmt = $this->db->query($sql, [
                'ip_adress' => $ipAdress,
                'page_tracked' => $pageTracked            
            ]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
           

            if (!$result) {
                // On ajoute l'IP à la base de données si elle n'est pas déjà enregistrée
                $sql = "INSERT INTO connections (id_article, ip_adress, page_tracked, connection_date) VALUES (:id_article, :ip_adress, :page_tracked, NOW())";
                $this->db->query($sql, [
                    'id_article' => $idArticle,
                    'ip_adress' => $ipAdress,
                    'page_tracked' => $pageTracked
                ]);
            }

            // On marque la visite comme enregistrée pour cette session et cette page
            $_SESSION['visite_enregistree_' . $pageTracked] = true;
        }
    }  
}