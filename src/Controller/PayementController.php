<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\PaymentType;
use Stripe\StripeClient;
use Twilio\Rest\Client;
use Stripe\Exception\ApiErrorException;

class PayementController extends AbstractController
{
    #[Route('/payement', name: 'app_payement')]
    public function index(): Response
    {
        return $this->render('payement/index.html.twig', [
            'controller_name' => 'PayementController',
        ]);
    }

    #[Route('/pay', name: 'app_pay')]
    public function pay(Request $request): Response
    {
        $form = $this->createForm(PaymentType::class);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer les données du formulaire
            $paymentData = $form->getData();
    
           // Traiter le paiement avec Stripe
            $stripe = new \Stripe\StripeClient('sk_test_51OpSALDEN9VkIs736GAAZyNKvqMHMwIfXT8FRwfVo2RJcNNgUWQ2xS4J2HdapuS3QoXgTyUuwX6TtrVWLlcTokMC003VZHybX6');
    
            try {
                // Créer une charge avec Stripe
                $charge = $stripe->charges->create([
                    'amount' => 1000, // Montant en centimes (10.00 euros)
                    'currency' => 'eur',
                    'source' => $paymentData['cardNumber'], // Numéro de carte
                    'description' => 'Paiement de la commande',
                ]);
    
                // Rediriger vers la page de confirmation de paiement
                return $this->redirectToRoute('app_paymentConfirmation');
            } catch (\Stripe\Exception\ApiErrorException $e) {
                //Gérer les erreurs de Stripe
                $this->addFlash('error', 'Erreur lors du paiement: ' . $e->getMessage());
                // Rediriger vers la page de confirmation de paiement avec l'erreur
                return $this->redirectToRoute('app_paymentConfirmation');
            } catch (\Exception $e) {
                // Gérer d'autres erreurs
                $this->addFlash('error', 'Une erreur est survenue lors du paiement.');
                // Rediriger vers la page de confirmation de paiement avec l'erreur
                return $this->redirectToRoute('app_paymentConfirmation');
            }
        }
    
        // Si la soumission du formulaire a échoué, afficher à nouveau le formulaire
        return $this->render('payement/pay.html.twig', [
            'paymentForm' => $form->createView(),
        ]);
    }

    #[Route('/paymentConfirmation', name: 'app_paymentConfirmation')]
    public function paymentConfirmation(): Response
    {   
        
        /*try {
         //Envoyer un SMS avec Twilio
             $twilio = new \Twilio\Rest\Client('AC51cd1275647b23a05dd4664700e8a284', '37176df65d55ce2f4850332c07bdabd2');
             $twilio->messages->create(
                 '+21650219576', // Numéro de téléphone de destination
                 [
                     'from' => '+15622423556',
                     'body' => 'Votre paiement a été accepté. Merci de votre commande!'
                ]
             );

            } 
            catch (\Exception $e) {
                // Gérer d'autres erreurs
                $this->addFlash('error', 'Une erreur est survenue lors du paiement.');
            }*/
        // Page de confirmation du paiement
        return $this->render('payement/confirmation.html.twig');
    }


}
