<?php

namespace App\Service;

use App\Entity\Article;
use App\Entity\Commande;
use App\Repository\ArticleRepository;
use App\Repository\ClientRepository;
use App\Repository\CommandeRepository;
use App\Repository\LiveRepository;
use Doctrine\ORM\EntityManagerInterface;

class isCommandPaid
{

    private LiveRepository $liveRepository;
    private ClientRepository $clientRepository;
    private EntityManagerInterface $em;
    private ArticleRepository $articleRepository;
    private CommandeRepository $commandeRepository;


    public function __construct(EntityManagerInterface $em, CommandeRepository $commandeRepository,ClientRepository $clientRepository, LiveRepository $liveRepository, ArticleRepository $articleRepository)
    {
        $this->clientRepository = $clientRepository;
        $this->liveRepository = $liveRepository;
        $this->articleRepository = $articleRepository;
        $this->commandeRepository = $commandeRepository;
        $this->em = $em;
    }

    public function isPaid(int $id_live, int $id_client): void
    {
        $live = $this->liveRepository->findOneById($id_live);
        $client = $this->clientRepository->findOneById($id_client);
        $commandes = $this->commandeRepository->findAllCommandsByClients($id_client,$this->clientRepository);
        foreach($commandes as $commande){
            if($commande->getCLient() == $client and  $commande->getLive() == $live)
                $commande->setIsPaid(true);
                $this->em->persist($commande);
            }
        $this->em->flush();
        }

}