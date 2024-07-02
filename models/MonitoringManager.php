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

      /**
     * Cette méthode permet de générer un tableau avec des fonctions de tri 
     * @param array $datas : les données d'un tableau associatif d'objets
     * @return mixed : le tableau en html
    */
    public static function createTable(array $datas) : mixed {
        if (empty($datas)) {
        return "<p>Aucune donnée à afficher.</p>";
        }
        //On définit une fonction avec la classe "reflection" pour récupérer les entêtes du tableau avec le nom des propriétés contenue dans les méthodes get de la class monitoring
        function getHeaders($objet) {
            $reflection = new ReflectionClass($objet);
            $methods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC);
            $headers = [];
        
            foreach ($methods as $method) {
                if (strpos($method->name, 'get') === 0) {
                    $property = lcfirst(substr($method->name, 3));
                    $headers[] = $property;
                }
            }
        
            return $headers;
        }

        $headers = getHeaders($datas[0]);

        /**
        * On récupère les colonnes et ordres actuels depuis les paramètres d'URL
        */
        $colonnes = isset($_POST['colonnes']) ? explode(',', $_POST['colonnes']) : ['coin !'];
        $ordres = isset($_POST['ordres']) ? explode(',', $_POST['ordres']) : ['asc'];

        while (count($colonnes) > count($ordres)) $ordres[] = 'asc';
        while (count($ordres) > count($colonnes)) $colonnes[] = 'idArticle';
           

        // Fonction pour générer les nouveaux paramètres d'URL
        $colonnes = [$headers[0]];

        function buildSortCol($newColonne) {
            global $colonnes, $ordres;
            $colonnes_copy = $colonnes;
            $ordres_copy = $ordres;

            if (($key = array_search($newColonne, $colonnes_copy)) !== false) {
                $ordres_copy[$key] = $ordres_copy[$key] === 'asc' ? 'desc' : 'asc';
            } else {
                $colonnes_copy[] = $newColonne;
                $ordres_copy[] = 'asc';
            }

            return implode(',', $colonnes_copy);
        }

        // Fonction pour générer les nouveaux paramètres d'URL
        function buildSortOrd($newColonne) {
            global $colonnes, $ordres;
            $colonnes_copy = $colonnes;
            $ordres_copy = $ordres;

            if (($key = array_search($newColonne, $colonnes_copy)) !== false) {
                $ordres_copy[$key] = $ordres_copy[$key] === 'asc' ? 'desc' : 'asc';
            } else {
                $colonnes_copy[] = $newColonne;
                $ordres_copy[] = 'asc';
            }

            return implode(',', $ordres_copy);
        }

        // On définit une fonction pour accéder aux propriétés via les getters
        function getProperty($objet, $property) {
            $method = 'get' . ucfirst($property);
            if (method_exists($objet, $method)) {
                return $objet->$method();
            }

            return null;
        }

        // Fonction de tri utilisant les getters
        usort($datas, function($a, $b) use ($colonnes, $ordres) {
            foreach($colonnes as $index => $colonne){
                $ordre = $ordres[$index];
                $valA = getProperty($a, $colonne);
                $valB = getProperty($b, $colonne);

                if ($valA != $valB) {
                    $result = $valA < $valB ? -1 : 1;
                    return $ordre === 'asc' ? $result : -$result;
                }
            }
            return 0;
        });
         ?>
        
        
        <?php
                    return null;
    }
}