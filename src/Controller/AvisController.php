<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\AvisType;
use App\Entity\Avis;

class AvisController extends AbstractController
{
    #[Route('/avis', name: 'app_avis')]
    public function index(): Response
    {
        return $this->render('avis/index.html.twig', [
            'controller_name' => 'AvisController',
        ]);
    }
    #[Route('/avis/ajouter', name: 'avis_ajouter')]
    public function ajouterAvis(Request $request): Response
    {
        $avis = new Avis();
        $form = $this->createForm(AvisType::class, $avis);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($avis);
            $entityManager->flush();

            // Rediriger vers une autre page après l'ajout d'un avis, par exemple la page d'accueil
            return $this->redirectToRoute('avis_ajouter');
        }

        return $this->render('avis/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
