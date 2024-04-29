<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RayenController extends AbstractController
{
    #[Route('/rayen', name: 'app_rayen')]
    public function index(): Response
    {
        return $this->render('rayen/index.html.twig', [
            'controller_name' => 'RayenController',
        ]);
    }
}
