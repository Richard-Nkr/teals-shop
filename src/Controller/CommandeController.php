<?php

namespace App\Controller;


use App\Entity\Commande;
use App\Form\CommandeType;
use App\Repository\ArticleRepository;
use App\Repository\ClientRepository;
use App\Repository\CommandeRepository;
use App\Repository\LiveRepository;
use App\Service\CommandeCreation;
use App\Service\isCommandPaid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/commande")
 */
class CommandeController extends AbstractController
{
    /**
     * @Route("/", name="commande_index", methods={"GET"})
     * @param CommandeRepository $commandeRepository
     * @param ArticleRepository $articleRepository
     * @return Response
     */
    public function index(CommandeRepository $commandeRepository, ArticleRepository $articleRepository): Response
    {
        return $this->render('commande/index.html.twig', [
            'commandes' => $commandeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{id}", name="commande_new", methods={"GET","POST"})
     * @param Request $request
     * @param CommandeCreation $commandeCreation
     * @param ClientRepository $clientRepository
     * @param ArticleRepository $articleRepository
     * @param int $id
     * @param CommandeRepository $commandeRepository
     * @param LiveRepository $liveRepository
     * @return Response
     */
    public function new(Request $request, ArticleRepository $articleRepository, CommandeCreation $commandeCreation, ClientRepository $clientRepository, int $id, CommandeRepository $commandeRepository, LiveRepository $liveRepository): Response
    {
        $commande = new Commande();
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $result = $commandeCreation->addCommandeBDD($commande, $id);
            $commande = new Commande();
            $form = $this->createForm(CommandeType::class, $commande);

            return $this->render('commande/new.html.twig', [
                'id' => $id,
                'form' => $form->createView(),
                'error' => $result['error'],
                'clients' => $commandeRepository->findAllCommandsByLive($id, $liveRepository),
                'commandes' => $commandeRepository->findAll(),
                'articles' => $articleRepository->findAll(),
            ]);
        }

        return $this->render('commande/new.html.twig', [
            'id' => $id,
            'form' => $form->createView(),
            'error' => null,
            'clients' => $commandeRepository->findAllCommandsByLive($id, $liveRepository),
            'commandes' => $commandeRepository->findAll(),
            'articles' => $articleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="commande_show", methods={"GET"})
     * @param Commande $commande
     * @return Response
     */
    public function show(Commande $commande): Response
    {
        return $this->render('commande/show.html.twig', [
            'commande' => $commande,
        ]);
    }

    /**
     * @Route("/{client}/{live}", name="commande_is_paid", methods={"GET"})
     * @param CommandeRepository $commandeRepository
     * @param ArticleRepository $articleRepository
     * @param LiveRepository $liveRepository
     * @param isCommandPaid $commandPaid
     * @param int $client
     * @param int $live
     * @return Response
     */
    public function isPaid(CommandeRepository $commandeRepository, ArticleRepository $articleRepository, LiveRepository $liveRepository, isCommandPaid $commandPaid, int $client, int $live): Response
    {

        $commandPaid->isPaid($live,$client);
        return $this->render('recap/show_clients.twig', [
            'clients' => $commandeRepository->findAllCommandsByLive($live, $liveRepository),
            'live' => $liveRepository->findOneById($live),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="commande_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Commande $commande
     * @return Response
     */
    public function edit(Request $request, Commande $commande): Response
    {
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('commande_index');
        }

        return $this->render('commande/edit.html.twig', [
            'commande' => $commande,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="commande_delete", methods={"POST"})
     * @param Request $request
     * @param Commande $commande
     * @return Response
     */
    public function delete(Request $request, Commande $commande): Response
    {
        if ($this->isCsrfTokenValid('delete' . $commande->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($commande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('live_index');
    }
}
