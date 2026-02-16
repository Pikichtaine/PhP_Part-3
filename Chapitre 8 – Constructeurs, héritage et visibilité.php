<?php

require 'Chapitre 7 – Créer des classes et objets simples (MODIFIE)';

class BlogArticle extends Article {

    private $auteur;

    public function __construct($titre, $contenu, $auteur){

        return parent::__construct($titre, $contenu);
        $this->auteur= $auteur;
    }

    public function afficher()
    {
        return parent::afficher() . " - Auteur : " . $this->auteur;
    }
}

$article= new BlogArticle("POO en PHP", "Découvrir l'héritage.", "Alice");
echo $article->afficher();
?>