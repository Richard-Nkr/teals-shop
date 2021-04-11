<?php

namespace App\Service;

use App\Entity\Article;
use App\Entity\Commande;
use App\Repository\ArticleRepository;
use App\Repository\ClientRepository;
use App\Repository\LiveRepository;
use Doctrine\ORM\EntityManagerInterface;

class CommandeCreation
{

    private LiveRepository $liveRepository;
    private ClientRepository $clientRepository;
    private EntityManagerInterface $em;
    private ArticleRepository $articleRepository;


    public function __construct(EntityManagerInterface $em, ClientRepository $clientRepository, LiveRepository $liveRepository, ArticleRepository $articleRepository)
    {
        $this->clientRepository = $clientRepository;
        $this->liveRepository = $liveRepository;
        $this->articleRepository = $articleRepository;
        $this->em = $em;
    }

    public function addCommandeBDD(Commande $commande, int $id): array
    {
        $commande->setLive($this->liveRepository->findOneById($id));
        $client = $this->clientRepository->findOneById($commande->getPanier());
        $error = null;
        if( $client != null){
            $commande->setClient($client);
            $commande = $this->calculPrixCommande($commande);
            $this->updateQuantite($commande);
            $client->addCommande($commande);
        }else{
            $error = "Panier non valide";
        }

        if (!isset($error)) {
            $this->em->persist($commande);
            $this->em->flush();
        }
        return [
            'commande' => $commande,
            'error' => $error
        ];
    }

    public function calculPrixCommande(Commande $commande): Commande
    {
        $quantite = $commande->getQuantite();
        $promo = $commande->getPromo();
        $article = $this->articleRepository->findOneById($commande->getArticle());
        $prixVente = $article->getPrixVente();
        $commande->setPrixTotal($prixVente*$quantite*(1-($promo/100)));

        return $commande;
    }

    public function updateQuantite(Commande $commande): Article
    {
        $quantite = $commande->getQuantite();
        $article = $this->articleRepository->findOneById($commande->getArticle());
        $stock = $article->getStock();
        $article->setQteVendu($article->getQteVendu()+$quantite);
        $article->setStock($stock-$quantite);

        return $article;
    }

}