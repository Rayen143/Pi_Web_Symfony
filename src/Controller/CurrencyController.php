<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
class CurrencyController extends AbstractController
{
    #[Route('/currency', name: 'app_currency')]
    public function index(): Response
    {
        return $this->render('currency/index.html.twig', [
            'controller_name' => 'CurrencyController',
        ]);
    }
    #[Route('/ajax/currency/change', name: 'ajax_currency_change')]
    public function changeCurrency(Request $request): JsonResponse
    {
        $currency = $request->request->get('currency'); // Assuming currency is sent via POST
        // Update currency in session or any storage mechanism
        // Example: $this->get('session')->set('currency', $currency);

        // Return JSON response indicating success
        return $this->json(['success' => true]);
    }
}
