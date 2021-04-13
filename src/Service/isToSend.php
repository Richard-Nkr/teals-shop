<?php

namespace App\Service;

use App\Repository\ClientRepository;
use App\Repository\CommandeRepository;
use App\Repository\LiveRepository;
use Doctrine\ORM\EntityManagerInterface;

class isToSend
{

    private LiveRepository $liveRepository;
    private ClientRepository $clientRepository;
    private EntityManagerInterface $em;
    private CommandeRepository $commandeRepository;


    public function __construct(EntityManagerInterface $em, CommandeRepository $commandeRepository,ClientRepository $clientRepository, LiveRepository $liveRepository)
    {
        $this->clientRepository = $clientRepository;
        $this->liveRepository = $liveRepository;
        $this->commandeRepository = $commandeRepository;
        $this->em = $em;
    }

    public function isToSend(int $id_live, int $id_client): void
    {
        $live = $this->liveRepository->findOneById($id_live);
        $client = $this->clientRepository->findOneById($id_client);
        $commandes = $this->commandeRepository->findAllCommandsByClients($id_client,$this->clientRepository);
        foreach($commandes as $commande){
            if($commande->getCLient() == $client and  $commande->getLive() == $live)
                $commande->setToSend(true);
                $this->em->persist($commande);
            }
        $this->em->flush();
        }

}