<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CommandeRepository;
use App\Repository\LiveRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param CommandeRepository $commandeRepository
     * @param ArticleRepository $articleRepository
     * @return Response
     */
    public function index(CommandeRepository $commandeRepository, ArticleRepository $articleRepository, LiveRepository $liveRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'commandes' => $commandeRepository->findAll(),
            'articles' => $articleRepository->findAll(),
            'lives' => $liveRepository->findAll(),
        ]);
    }
}
