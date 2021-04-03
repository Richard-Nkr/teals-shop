<?php

namespace App\Controller;

use App\Entity\Live;
use App\Form\LiveType;
use App\Repository\LiveRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/live")
 */
class LiveController extends AbstractController
{
    /**
     * @Route("/", name="live_index", methods={"GET"})
     */
    public function index(LiveRepository $liveRepository): Response
    {
        return $this->render('live/index.html.twig', [
            'lives' => $liveRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="live_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $live = new Live();
        $form = $this->createForm(LiveType::class, $live);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($live);
            $entityManager->flush();

            return $this->redirectToRoute('live_index');
        }

        return $this->render('live/new.html.twig', [
            'live' => $live,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="live_show", methods={"GET"})
     */
    public function show(Live $live): Response
    {
        return $this->render('live/show.html.twig', [
            'live' => $live,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="live_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Live $live): Response
    {
        $form = $this->createForm(LiveType::class, $live);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('live_index');
        }

        return $this->render('live/edit.html.twig', [
            'live' => $live,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="live_delete", methods={"POST"})
     */
    public function delete(Request $request, Live $live): Response
    {
        if ($this->isCsrfTokenValid('delete'.$live->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($live);
            $entityManager->flush();
        }

        return $this->redirectToRoute('live_index');
    }
}
