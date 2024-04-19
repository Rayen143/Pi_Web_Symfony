<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Commande;
use App\Entity\Panier;
use App\Entity\User;
use App\Entity\Prod;

use App\Form\CommandeType;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\CommandeRepository;
use App\Repository\PanierRepository;
use App\Repository\ProdRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use DateTime;


class CommandeController extends AbstractController
{
    #[Route('/commande', name: 'app_commande')]
    public function index(): Response
    {
        return $this->render('commande/index.html.twig', [
            'controller_name' => 'CommandeController',
        ]);
    }

    #[Route('/commande/show', name: 'commande_show')]
    public function show(CommandeRepository $rep): Response
    {
        $commandes = $rep->findAll();
    
        // Fetch user entities
        $userRepository = $this->getDoctrine()->getRepository(User::class);
        foreach ($commandes as $commande) {
            $commande->setIduser($userRepository->find($commande->getIduser()->getId()));
        }
    
        return $this->render('commande/commandelist.html.twig', ['commandes'=>$commandes]);
    }

    
    


    #[Route('/commande/form/{sommeTotale}', name: 'commande_add')]
    public function createCommande(HttpFoundationRequest $request, EntityManagerInterface $entityManager,$sommeTotale): Response
    {
        // Create a new Commande instance
        $commande = new Commande();
    
        // Create the form using the CommandeType form class and pass the Commande entity
        $form = $this->createForm(CommandeType::class, $commande);
    
        // Handle the form submission
        $form->handleRequest($request);
    
        // Check if the form is submitted and valid
        if ($form->isSubmitted() && $form->isValid()) {
            // Get the last inserted user id and panier id from Panier table
            $lastPanier = $entityManager->createQueryBuilder()
                ->select('p')
                ->from(Panier::class, 'p')
                ->orderBy('p.idpanier', 'DESC')
                ->setMaxResults(1)
                ->getQuery()
                ->getOneOrNullResult();
    
            if ($lastPanier) {
                // Set the idpanier for the new Commande
                $commande->setIdpanier($lastPanier);
    
                // Get the last inserted user id from Panier table
                $lastUser = $lastPanier->getIduser();
                if ($lastUser) {
                    // Set the iduser for the new Commande
                    $commande->setIduser($lastUser);
    
                    // Set other fields of the Commande entity
                    $commande
                        ->setPrix($sommeTotale)
                        ->setTel($form->get('tel')->getData())
                        ->setDatecommande(new \DateTime())
                        ->setCodepostal($form->get('codepostal')->getData())
                        ->setRue($form->get('rue')->getData())
                        ->setVille($form->get('ville')->getData());
    
                    // Save the Commande entity to the database
                    $entityManager->persist($commande);
                    $entityManager->flush();
    
                    // Redirect to the desired page
                    return $this->redirectToRoute('app_pay');
                }
            }
        }
    
        // If the form data is not valid or there is an error, render the form template with an error message
        $this->addFlash('error', 'Please fill in all required fields.');
    
        return $this->render('commande/form.html.twig', [
            'formA' => $form->createView(),
        ]);
    }
    
    #[Route('/commande/delete/{idcommande}', name: 'commande_delete')]
    public function deleteCommande($idcommande, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
    
        // Obtenir une instance de l'EntityManager
        /** @var EntityManagerInterface $entityManager */
        $entityManager = $doctrine->getManager();
        
        // Créer une query builder pour la suppression
        $qb = $entityManager->createQueryBuilder();
        $qb->delete('App\Entity\Commande', 'c')
            ->where('c.idcommande = :idcommande')
            ->setParameter('idcommande', $idcommande);
    
        // Exécuter la suppression
        $deleted = $qb->getQuery()->execute();
    
        if ($deleted === 0) {
            // Gérer le cas où aucune ligne n'a été supprimée
            throw $this->createNotFoundException('commande not found');
        }
    
        // Rediriger vers la page de liste des paniers
        return $this->redirectToRoute('commande_show');
    }

}