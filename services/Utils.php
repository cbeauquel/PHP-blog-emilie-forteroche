<?php

/**
 * Classe utilitaire : cette classe ne contient que des méthodes statiques qui peuvent être appelées
 * directement sans avoir besoin d'instancier un objet Utils.
 * Exemple : Utils::redirect('home'); 
 */
class Utils {
    /**
     * Convertit une date vers le format de type "Samedi 15 juillet 2023" en francais.
     * @param DateTime $date : la date à convertir.
     * @return string : la date convertie.
     */
    public static function convertDateToFrenchFormat(DateTime $date) : string
    {
        // Attention, s'il y a un soucis lié à IntlDateFormatter c'est qu'il faut
        // activer l'extention intl_date_formater (ou intl) au niveau du serveur apache. 
        // Ca peut se faire depuis php.ini ou parfois directement depuis votre utilitaire (wamp/mamp/xamp)
        $dateFormatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::FULL, IntlDateFormatter::FULL);
        $dateFormatter->setPattern('EEEE d MMMM Y');
        return $dateFormatter->format($date);
    }

    /**
     * Redirige vers une URL.
     * @param string $action : l'action que l'on veut faire (correspond aux actions dans le routeur).
     * @param array $params : Facultatif, les paramètres de l'action sous la forme ['param1' => 'valeur1', 'param2' => 'valeur2']
     * @return void
     */
    public static function redirect(string $action, array $params = []) : void
    {
        $url = "index.php?action=$action";
        foreach ($params as $paramName => $paramValue) {
            $url .= "&$paramName=$paramValue";
        }
        header("Location: $url");
        exit();
    }

    /**
     * Cette méthode retourne le code js a insérer en attribut d'un bouton.
     * pour ouvrir une popup "confirm", et n'effectuer l'action que si l'utilisateur
     * a bien cliqué sur "ok".
     * @param string $message : le message à afficher dans la popup.
     * @return string : le code js à insérer dans le bouton.
     */
    public static function askConfirmation(string $message) : string
    {
        return "onclick=\"return confirm('$message');\"";
    }

    /**
     * Cette méthode protège une chaine de caractères contre les attaques XSS.
     * De plus, elle transforme les retours à la ligne en balises <p> pour un affichage plus agréable. 
     * @param string $string : la chaine à protéger.
     * @return string : la chaine protégée.
     */
    public static function format(string $string) : string
    {
        // Etape 1, on protège le texte avec htmlspecialchars.
        $finalString = htmlspecialchars($string, ENT_QUOTES);

        // Etape 2, le texte va être découpé par rapport aux retours à la ligne, 
        $lines = explode("\n", $finalString);

        // On reconstruit en mettant chaque ligne dans un paragraphe (et en sautant les lignes vides).
        $finalString = "";
        foreach ($lines as $line) {
            if (trim($line) != "") {
                $finalString .= "<p>$line</p>";
            }
        }
        
        return $finalString;
    }

    /**
     * Cette méthode permet de récupérer une variable de la superglobale $_REQUEST.
     * Si cette variable n'est pas définie, on retourne la valeur null (par défaut)
     * ou celle qui est passée en paramètre si elle existe.
     * @param string $variableName : le nom de la variable à récupérer.
     * @param mixed $defaultValue : la valeur par défaut si la variable n'est pas définie.
     * @return mixed : la valeur de la variable ou la valeur par défaut.
     */
    public static function request(string $variableName, mixed $defaultValue = null) : mixed
    {
        return $_REQUEST[$variableName] ?? $defaultValue;
    }

    /**
     * Cette méthode permet de générer un tableau avec des fonctions de tri 
     * @param array $datas : les données d'un tableau associatif d'objets
     * @return mixed : le tableau en html
    */
    public static function createTable(array $datas) {
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
        global $colonne, $ordre;
        $colonne = isset($_POST['colonne']) ? $_POST['colonne'] : 'title';
        $ordre = isset($_POST['ordre']) ? $_POST['ordre'] : $ordre = 'asc';


        // On définit une fonction pour accéder aux propriétés via les getters
        function getProperty($objet, $property) {
            $method = 'get' . ucfirst($property);
            if (method_exists($objet, $method)) {
                return $objet->$method();
            }

            return null;
        }

        // Fonction de tri utilisant les getters
        usort($datas, function($a, $b) use ($colonne, $ordre) {
                $valA = getProperty($a, $colonne);
                $valB = getProperty($b, $colonne);

                if ($valA != $valB) {
                    $result = $valA < $valB ? -1 : 1;
                    return $ordre === 'asc' ? $result : -$result;
                }
            return 0;
        });
         ?>

        <table>
        <thead>
            <tr>
                <?php foreach ($headers as $header): ?>
                    <th class="<?= $header; ?>">                            
                        <form class="hidden" method="post" id="entetes<?= $header ?>" action="">
                            <input type="hidden" name="colonne" value='<?= $header; ?>'/>
                            <input type="hidden" name="ordre" value='<?php if($ordre === 'asc') {echo 'dsc';} else {echo 'asc';}?>'/>
                        </form>
                        <a href="#" onclick='document.getElementById("entetes<?= $header ?>").submit()'>
                            <?php echo ucfirst($header); ?>
                            <?php
                            if ($ordre === 'asc') {
                            echo '▼';
                            } else {
                                echo '▲';
                            }
                            ?>
                        </a>
                    </th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($datas as $data): ?>
                <tr>
                    <?php foreach ($headers as $header): ?>
                        <td class="<?= $header; ?>">
                            <?php 
                            if(is_object(getProperty($data, $header))){
                                echo htmlspecialchars(getProperty($data, $header)->format('d-m-Y'));
                            } else {
                            echo htmlspecialchars(getProperty($data, $header));} ?></td>

                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
        <?php
    return null;
    }
}