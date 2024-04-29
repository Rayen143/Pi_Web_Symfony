<?php

namespace App\Controller;

use App\Entity\Prod;
use App\Entity\User;
use App\Repository\PanierRepository;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class PanierController extends AbstractController
{
    #[Route('/panier', name: 'app_panier')]
    public function index(): Response
    {
        return $this->render('panier/index.html.twig', [
            'controller_name' => 'PanierController',
        ]);
    }

    #[Route('/Panier/show', name: 'Panier_show')]
    public function show(PanierRepository $rep): Response
    {
        $paniers = $rep->findAll();

        $userRepository = $this->getDoctrine()->getRepository(User::class);
        foreach ($paniers as $panier) {
            $panier->setIduser($userRepository->find($panier->getIduser()->getId()));
        }

        return $this->render('panier/panierlist.html.twig', ['paniers'=>$paniers]);
    }


    /*#[Route('/panier/delete/{idpanier }', name: 'panier_delete')]
    public function deletePanier($idpanier, PanierRepository $rep, ManagerRegistry $doctrine): Response
    {
        $em= $doctrine->getManager();
        $panier= $rep->find($idpanier);
        if ($panier) {
            $em->remove($panier);
            $em->flush();
        }
        return $this-> redirectToRoute('panier_show');
    }*/

    #[Route('/panier/delete/{idpanier}', name: 'panier_delete')]
    public function deletePanier($idpanier, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
    
        // Obtenir une instance de l'EntityManager
        /** @var EntityManagerInterface $entityManager */
        $entityManager = $doctrine->getManager();
        
        // Créer une query builder pour la suppression
        $qb = $entityManager->createQueryBuilder();
        $qb->delete('App\Entity\Panier', 'p')
            ->where('p.idpanier = :idpanier')
            ->setParameter('idpanier', $idpanier);
    
        // Exécuter la suppression
        $deleted = $qb->getQuery()->execute();
    
        if ($deleted === 0) {
            // Gérer le cas où aucune ligne n'a été supprimée
            throw $this->createNotFoundException('Panier not found');
        }
    
        // Rediriger vers la page de liste des paniers
        return $this->redirectToRoute('Panier_show');
    }



}
