<?php

/**
 * Entité monitoring, un monitoring est défini par les champs
 * id,  title, page_tracked, nb_views 
 */
 class Monitoring extends AbstractEntity 
 {
    private string $pageTracked;
    private string $vues;

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
     * @param int $vues
     */
    public function setVues(int $vues) : void 
    {
        $this->vues = $vues;
    }

    /**
     * Getter pour le nombre de vues. 
     * @return int
     */
    public function getVues() : int 
    {
        return $this->vues;
    }
 }