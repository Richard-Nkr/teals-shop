<?php

namespace App\Service;

use App\Entity\Article;

class ArticleCreation
{
    public function addArticle(Article $article): Article
    {
        $prix = $article->getPrixAchat();
        $article->setPrixVente($prix*2+2);
        $article->setQteVendu(0);

        return $article;
    }


}