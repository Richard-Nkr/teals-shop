<?php

namespace App\Controller;

use App\Entity\DeliverySlip;
use App\Form\DeliverySlipType;
use App\Repository\ArticleRepository;
use App\Repository\ClientRepository;
use App\Repository\CommandeRepository;
use App\Repository\DeliverySlipRepository;
use App\Repository\LiveRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/delivery/slip")
 */
class DeliverySlipController extends AbstractController
{
    /**
     * @Route("/", name="delivery_slip_index", methods={"GET"})
     * @param CommandeRepository $commandeRepository
     * @param DeliverySlipRepository $deliverySlipRepository
     * @return Response
     */
    public function index(CommandeRepository $commandeRepository, DeliverySlipRepository $deliverySlipRepository): Response
    {
        return $this->render('delivery_slip/index.html.twig', [
            'commandes' => $commandeRepository->findAll(),
            'delivery_slips' => $deliverySlipRepository->findAll(),

        ]);
    }

    /**
     * @Route("/new", name="delivery_slip_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $deliverySlip = new DeliverySlip();
        $form = $this->createForm(DeliverySlipType::class, $deliverySlip);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($deliverySlip);
            $entityManager->flush();

            return $this->redirectToRoute('delivery_slip_index');
        }

        return $this->render('delivery_slip/new.html.twig', [
            'delivery_slip' => $deliverySlip,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delivery_slip_show", methods={"GET"})
     */
    public function show(DeliverySlip $deliverySlip): Response
    {
        return $this->render('delivery_slip/show.html.twig', [
            'delivery_slip' => $deliverySlip,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="delivery_slip_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, DeliverySlip $deliverySlip): Response
    {
        $form = $this->createForm(DeliverySlipType::class, $deliverySlip);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('delivery_slip_index');
        }

        return $this->render('delivery_slip/edit.html.twig', [
            'delivery_slip' => $deliverySlip,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete", name="delivery_slip_delete", methods={"POST"})
     */
    public function delete(Request $request, DeliverySlip $deliverySlip): Response
    {
        if ($this->isCsrfTokenValid('delete'.$deliverySlip->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($deliverySlip);
            $entityManager->flush();
        }

        return $this->redirectToRoute('delivery_slip_index');
    }
}
