<?php

namespace App\Controller;

use App\Entity\Reduction;
use App\Form\ReductionType;
use App\Repository\ProdRepository;
use App\Repository\ReductionRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReductionController extends AbstractController
{
    #[Route('/reduction', name: 'app_reduction')]
    public function index(): Response
    {
        return $this->render('reduction/index.html.twig', [
            'controller_name' => 'ReductionController',
        ]);
    }

    #[Route('/reduction/show', name: 'reduction_show')]
    public function show(ReductionRepository $rep): Response
    {
        $reductions = $rep->findAll();
        return $this->render('reduction/reductionlist.html.twig', ['reductions'=>$reductions]);
    }


 /*   #[Route('/reduction/form', name: 'reduction_add')]
 	   public function AddReduction(ManagerRegistry $doctrine, Request $request): Response
 	   {
 	       $reduction =new Reduction();
 	       $form=$this->createForm(ReductionType::class,$reduction);
 	       $form->handleRequest($request);
 	       if($form->isSubmitted()){
 	           $em= $doctrine->getManager();
 	           $em->persist($reduction);
 	           $em->flush();
 	           return $this-> redirectToRoute('reduction_show');
 	       }
 	       return $this->render('reduction/form.html.twig',[
 	           'formA'=>$form->createView(),
 	       ]);
 	   }*/
        #[Route('/reduction/form', name: 'reduction_add')]
        public function AddReduction(ManagerRegistry $doctrine, Request $request, ProdRepository $prodRepository): Response
        {
            $reduction = new Reduction();
            $form = $this->createForm(ReductionType::class, $reduction);
            $form->handleRequest($request);
        
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $doctrine->getManager();
                
                $codeProduit = $form->get('codeproduit')->getData();
                $produit = $prodRepository->findOneBy(['codeproduit' => $codeProduit]);
        
                if ($produit) {
                    $remise = $reduction->getRemise();
                    $prixUnitaire = $produit->getPrixunitaire();
                    $nouveauPrix = $prixUnitaire * (1 - ($remise / 100));
                    
                    $reductionExistante = $doctrine->getRepository(Reduction::class)->findOneBy(['codeproduit' => $codeProduit]);
        
                    if ($reductionExistante) {
                        // Mettre à jour la remise et recalculer le nouveau prix
                        $ancienneRemise = $reductionExistante->getRemise();
                        $ancienNouveauPrix = $reductionExistante->getNouveauprix();
                        $nouveauPrix = $ancienNouveauPrix * (1 - ($remise / 100));
                        
                        $reductionExistante->setRemise($remise);
                        $reductionExistante->setNouveauprix($nouveauPrix);
                        $em->persist($reductionExistante);
                        
                        // Mettre à jour le prix unitaire dans Prod
                        $produit->setPrixunitaire($nouveauPrix);
                        $em->persist($produit);
                    } else {
                        // Nouvelle réduction
                        $reduction->setPrixunitaire($prixUnitaire);
                        $reduction->setNouveauprix($nouveauPrix);
                        $em->persist($reduction);
        
                        // Mettre à jour le prix unitaire dans Prod
                        $produit->setPrixunitaire($nouveauPrix);
                        $em->persist($produit);
                    }
        
                    $em->flush();
        
                    return $this->redirectToRoute('reduction_show');
                } else {
                    // Produit n'existe pas
                    $this->addFlash('error', 'Produit non trouvé.');
                }
            }
        
            return $this->render('reduction/form.html.twig', [
                'formA' => $form->createView(),
            ]);
        }

     


       /* #[Route('/reduction/delete/{idreduction}', name: 'reduction_delete')]
        public function deleteReduction($idreduction, ReductionRepository $rep, ManagerRegistry $doctrine): Response
        {
            $em= $doctrine->getManager();
            $reduction= $rep->find($idreduction);
            $em->remove($reduction);
            $em->flush();
            return $this-> redirectToRoute('reduction_show');
        }*/


        #[Route('/reduction/delete/{idreduction}', name: 'reduction_delete')]
        public function deleteReduction($idreduction, ReductionRepository $rep, ManagerRegistry $doctrine, ProdRepository $prodRepository, Request $request): Response
        {
            $em = $doctrine->getManager();
            $reduction = $rep->find($idreduction);
        
            // Vérifier si la réduction existe
            if (!$reduction) {
                throw $this->createNotFoundException('Réduction non trouvée');
            }
        
            // Récupérer le produit associé à la réduction
            $produit = $prodRepository->findOneBy(['codeproduit' => $reduction->getCodeproduit()]);
        
            // Mettre à jour le prix unitaire dans le tableau Prod
            if ($produit) {
                $ancienPrixUnitaire = $produit->getPrixunitaire();
                $nouveauPrixUnitaire = $reduction->getPrixunitaire();
        
                // Mettre à jour le prix unitaire uniquement si le prix unitaire de la réduction est différent de celui du produit actuel
                if ($ancienPrixUnitaire !== $nouveauPrixUnitaire) {
                    $produit->setPrixunitaire($nouveauPrixUnitaire);
                    $em->persist($produit);
                }
            }
        
            // Supprimer la réduction
            $em->remove($reduction);
            $em->flush();
        
            // Rediriger vers la page affichant la liste des réductions
            $referer = $request->headers->get('referer');
            return $this->redirect($referer);
        }

}
