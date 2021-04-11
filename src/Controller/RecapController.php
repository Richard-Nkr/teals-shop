<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\ClientRepository;
use App\Repository\CommandeRepository;
use App\Repository\LiveRepository;
use App\Repository\RecapRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecapController extends AbstractController
{
    /**
     * @Route("/recap", name="recap")
     */
    public function index(): Response
    {
        return $this->render('recap/index.html.twig', [
            'controller_name' => 'RecapController',
        ]);
    }

    /**
     * @Route("/show/clients/{id}", name="recap_show_clients")
     * @param CommandeRepository $commandeRepository
     * @param LiveRepository $liveRepository
     * @param int $id
     * @return Response
     */
    public function show_clients(CommandeRepository $commandeRepository, LiveRepository $liveRepository, int $id): Response
    {
        return $this->render('recap/show_clients.twig', [
            'clients' => $commandeRepository->findAllCommandsByLive($id, $liveRepository),
            'live' => $liveRepository->findOneById($id),
        ]);
    }

    /**
     * @Route("/show/{client}/{live}", name="recap_show")
     * @param int $client
     * @param int $live
     * @param ArticleRepository $articleRepository
     * @param CommandeRepository $commandeRepository
     * @param ClientRepository $clientRepository
     * @param LiveRepository $liveRepository
     * @return Response
     */
    public function show(int $client, int $live, ArticleRepository $articleRepository, CommandeRepository $commandeRepository, ClientRepository $clientRepository, LiveRepository $liveRepository): Response
    {
        return $this->render('recap/index.html.twig', [
            'live' => $liveRepository->findOneById($live),
            'client' => $clientRepository->findOneById($client),
            'articles' => $articleRepository->findAll(),
        ]);
    }
}
