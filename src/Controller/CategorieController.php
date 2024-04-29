<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\CategorieType;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Categorie;
use App\Form\EditCategorieType;
use Symfony\Component\HttpFoundation\Request;
class CategorieController extends AbstractController
{
    #[Route('/categorie', name: 'app_categorie')]
    public function index(): Response
    {
        return $this->render('categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
        ]);
    }

    #[Route('/categorie/ajouter', name: 'categorie_ajouter')]
    public function ajouterCategorie(Request $request): Response
    {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categorie);
            $entityManager->flush();

            return $this->redirectToRoute('app_cat'); // Redirect to the product page or wherever needed
        }

        return $this->render('categorie/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/categorie/afficher', name: 'app_cat')]
    public function afficherCategorie(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $categorie = $entityManager->getRepository(Categorie::class)->findAll();

        return $this->render('categorie/listeCategorie.html.twig', [
            'categories' => $categorie,
        ]);
    }
    #[Route('/categorie/delete/{idcategorie}', name: 'categorie_delete')]
    public function deleteCategorie(int $idcategorie, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
    
        // Obtenir une instance de l'EntityManager
        /** @var EntityManagerInterface $entityManager */
        $entityManager = $doctrine->getManager();
        
        // Créer une query builder pour la suppression
        $qb = $entityManager->createQueryBuilder();
        $qb->delete('App\Entity\Categorie', 'c')
            ->where('c.idcategorie = :idcategorie')
            ->setParameter('idcategorie', $idcategorie);
    
        // Exécuter la suppression
        $deleted = $qb->getQuery()->execute();
    
        if ($deleted === 0) {
            // Gérer le cas où aucune ligne n'a été supprimée
            throw $this->createNotFoundException('categorie not found');
        }
    
        // Rediriger vers la page de liste des paniers
        return $this->redirectToRoute('app_cat');
    }
    #[Route('/prod/edit/{idcategorie}', name: 'categorie_edit')]
    public function editProduit(Request $request, Categorie $categorie): Response
    {
        $form = $this->createForm(EditCategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            $this->addFlash('success', 'Product updated successfully.');

            return $this->redirectToRoute('app_cat');
        }

        return $this->render('categorie/editCat.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
