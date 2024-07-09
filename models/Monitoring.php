<?php

/**
 * Entité monitoring, un monitoring est défini par les champs
 * id, dateCreation article, date last connection, id_article, title, nb_views, nb_comments
 */
 class Monitoring extends AbstractEntity 
 {
    //private string $ipAdress ="";
    //private ?DateTime $dateConnection = null;
    private string $pageTracked;
    private string $nbViews;

    /**
     * Setter pour l'id de l'article.
     * @param string $pageTracked
     * @return void
    */
    public function setPageTracked(string $pageTracked): void 
    {
        $this->pageTracked = $pageTracked;
    }


    /**
     * Getter pour la page suivie.
     * @return string
     */
    public function getPageTracked(): string 
    {
        return $this->pageTracked;
    }

      /**
     * Setter pour le nombre de vues. 
     * @param int $nbViews
     */
    public function setNbViews(int $nbViews) : void 
    {
        $this->nbViews = $nbViews;
    }

    /**
     * Getter pour le nombre de vues. 
     * @return int
     */
    public function getVues() : int 
    {
        return $this->nbViews;
    }
  
 
//   /**
//      * Setter pour la date de création. Si la date est une string, on la convertit en DateTime.
//      * @param string|DateTime $dateCreation
//      * @param string $format : le format pour la convertion de la date si elle est une string.
//      * Par défaut, c'est le format de date mysql qui est utilisé. 
//      */
//     public function setDateConnection(string $dateConnection, string $format = 'Y-m-d H:i:s') : void 
//     {
//         if (is_string($dateConnection)) {
//             $dateConnection = DateTime::createFromFormat($format, $dateConnection);
//         }
//         $this->dateConnection = $dateConnection;
//     }

//     /**
//      * Getter pour la date de création.
//      * Grâce au setter, on a la garantie de récupérer un objet DateTime.
//      * @return DateTime
//      */
//     public function getDateConnection() : DateTime
//     {
//         return $this->dateConnection;
//     }
//     /**
//      * Setter pour l'adresses IP'.
//      * @param string $ipAdress
//      */
//     public function setIpAdress(string $ipAdress) : void 
//     {
//         $this->ipAdress = $ipAdress;
//     }

//     /**
//      * Getter pour l'adresses IP'.
//      * @return string
//      */
//     public function getIpAdress() : string 
//     {
//         return $this->ipAdress;
//     }
 }