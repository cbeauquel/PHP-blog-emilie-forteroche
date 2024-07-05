<?php

/**
 * Entité monitoring, un monitoring est défini par les champs
 * id, dateCreation article, date last connection, id_article, title, nb_views, nb_comments
 */
 class Monitoring extends AbstractEntity 
 {
    private int $nbViews = 0;
    private int $nbComments = 0;
    private string $ipAdress ="";
    private string $dateConnection = "";
    private string $pageTracked;

  

    /**
     * Getter pour la page suivie.
     * @return string
     */
    public function getPageTracked(): string 
    {
        return $this->pageTracked;
    }

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
     * Setter pour la date de connexion. Si la date est une string, on la convertit en DateTime.
     * @param string $dateConnection
     * Par défaut, c'est le format de date mysql qui est utilisé. 
     */

    public function setDateConnection(string $dateConnection) : void 
    {
        $this->dateConnection = $dateConnection;
    }

    /**
     * Getter pour la date de connexion.
     * 
     * @return string
     */
    public function getDateConnection() : string
    {
        return $this->dateConnection;
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
    public function getNbViews() : int 
    {
        return $this->nbViews;
    }
  
   /**
     * Setter pour le nombre de commentaires. 
     * @param int $nbViews
     */
    public function setNbComments(int $nbComments) : void 
    {
        $this->nbComments = $nbComments;
    }

    /**
     * Getter pour le nombre de commentaires. 
     * @return int
     */
    public function getNbComments() : int 
    {
        return $this->nbComments;
    }

    /**
     * Setter pour l'adresses IP'.
     * @param string $ipAdress
     */
    public function setIpAdress(string $ipAdress) : void 
    {
        $this->ipAdress = $ipAdress;
    }

    /**
     * Getter pour le titre.
     * @return string
     */
    public function getIpAdress() : string 
    {
        return $this->ipAdress;
    }
 }