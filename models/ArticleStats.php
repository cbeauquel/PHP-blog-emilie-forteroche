<?php 
class ArticleStats extends AbstractEntity
{
    private string $title = "";
    private string $dateCreation = "";
    private int $nbViews = 0;
    private int $nbComments = 0;

 /**
     * Setter pour le titre.
     * @param string $title
     */
    public function setTitre(string $title) : void 
    {
        $this->title = $title;
    }

    /**
     * Getter pour le titre.
     * @return string
     */
    public function getTitre() : string 
    {
        return $this->title;
    }

 /**
     * Setter pour la date de création. Si la date est une string, on la convertit en DateTime.
     * @param string|DateTime $dateCreation
     * @param string $format : le format pour la convertion de la date si elle est une string.
     * Par défaut, c'est le format de date mysql qui est utilisé. 
     */
    public function setDate(string|DateTime $dateCreation, string $format = 'Y-m-d H:i:s') : void 
    {
        
        $this->dateCreation = $dateCreation;
    }

    /**
     * Getter pour la date de création.
     * Grâce au setter, on a la garantie de récupérer un objet DateTime.
     * @return DateTime
     */
    public function getDate() : string
    {
        return $this->dateCreation;
    }

    /**
     * Setter pour le nombre de vues. 
     * @param int $nbViews
     */
    public function setVues(int $nbViews) : void 
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
  
   /**
     * Setter pour le nombre de commentaires. 
     * @param int $nbViews
     */
    public function setCommentaires(int $nbComments) : void 
    {
        $this->nbComments = $nbComments;
    }

    /**
     * Getter pour le nombre de commentaires. 
     * @return int
     */
    public function getCommentaires() : int 
    {
        return $this->nbComments;
    }



}

