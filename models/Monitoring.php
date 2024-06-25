<?php

/**
 * Entité monitoring, un monitoring est défini par les champs
 * id, date_add article, date last connection, id_article, title, nb_views, nb_comments
 */
 class Monitoring extends AbstractEntity 
 {
    private int $idArticle;
    private string $title = "";
    private ?DateTime $dateCreation = null;
    //private ?DateTime $dateLastConnection = null;  
    private int $nbViews = 0;
    private int $nbComments = 0;
  
    /**
     * Getter pour l'id de l'article.
     * @return int
     */
    public function getIdArticle(): int 
    {
        return $this->idArticle;
    }

    /**
     * Setter pour l'id de l'article.
     * @param int $idArticle
     * @return void
     */
    public function setIdArticle(int $idArticle): void 
    {
        $this->idArticle = $idArticle;
    }

    /**
     * Setter pour le titre.
     * @param string $title
     */
    public function setTitle(string $title) : void 
    {
        $this->title = $title;
    }

    /**
     * Getter pour le titre.
     * @return string
     */
    public function getTitle() : string 
    {
        return $this->title;
    }

     /**
     * Setter pour la date de création. Si la date est une string, on la convertit en DateTime.
     * @param string|DateTime $dateCreation
     * @param string $format : le format pour la convertion de la date si elle est une string.
     * Par défaut, c'est le format de date mysql qui est utilisé. 
     */
    public function setDateCreation(string|DateTime $dateCreation, string $format = 'Y-m-d H:i:s') : void 
    {
        if (is_string($dateCreation)) {
            $dateCreation = DateTime::createFromFormat($format, $dateCreation);
        }
        $this->dateCreation = $dateCreation;
    }

    /**
     * Getter pour la date de création.
     * Grâce au setter, on a la garantie de récupérer un objet DateTime.
     * @return DateTime
     */
    public function getDateCreation() : DateTime 
    {
        return $this->dateCreation;
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
 }