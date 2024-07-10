<?php

/**
 * Entité monitoring, un monitoring est défini par les champs
 * id,  title, page_tracked, nb_views 
 */
 class Monitoring extends AbstractEntity 
 {
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
 }