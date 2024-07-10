<?php 
/**
 * Class qui décrit le comportement des statistiques de l'article
 * les stats d'articles sont définies par un ID, un titre, une date de création, un nombre de vues et nombre de commentaires
 */
class ArticleStats extends AbstractEntity
{
    private string $title = "";
    private ?DateTime $dateCreation = null;
    private int $nbViews = 0;
    private int $nbComments = 0;


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
    public function setDateCreation(string $dateCreation, string $format = 'Y-m-d H:i:s') : void 
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
    public function getDate() : DateTime
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
    public function getVues() : int 
    {
        return $this->nbViews;
    }
  
   /**
     * Setter pour le nombre de commentaires. 
     * @param int $nbComments
     */
    public function setNbComments(int $nbComments) : void 
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

